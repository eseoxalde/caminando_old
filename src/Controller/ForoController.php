<?php
namespace App\Controller;

use App\Entity\Post;
use App\Entity\Categoria;
use App\Entity\Comentario;
use App\Entity\Foro;
use App\Entity\FavoritePost;
use App\Form\PostType;
use App\Form\CategoriaType;
use App\Form\ComentarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;
use App\Repository\PostRepository;
use App\Repository\ForoRepository;
use App\Repository\CategoriaRepository;

class ForoController extends BaseController
{
    private $sitio;
    private $menues;
    private $entityManager;
    private $foroRepository;
    private $categoriaRepository;
    private $postRepository; 

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository, ForoRepository $foroRepository, CategoriaRepository $categoriaRepository, PostRepository $postRepository) // Modificar el constructor
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();
        $this->foroRepository = $foroRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->postRepository = $postRepository;
    }

    // Manejo de Categorías

    #[Route('/categorias', name: 'categoria_index')]
    public function indexcategoria(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categoria::class)->findAll();
        return $this->renderWithMenu('categoria/index.html.twig', [
            'categories' => $categories,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[Route('/categoria/nuevo', name: 'categoria_new')]
    public function newcategoria(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('categoria_index');
        }

        return $this->renderWithMenu('categoria/new.html.twig', [
            'form' => $form->createView(),
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[Route('/categoria/{id}/editar', name: 'categoria_edit')]
    public function editcategoria(Request $request, EntityManagerInterface $entityManager, Categoria $categoria): Response
    {
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('categoria_index');
        }

        return $this->renderWithMenu('categoria/edit.html.twig', [
            'form' => $form->createView(),
            'categoria' => $categoria,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[Route("/categoria/{id}", name:"categoria_show")]
    public function showcategoria(int $id): Response
    {
        $categoria = $this->categoriaRepository->find($id);
        if (!$categoria) {
            throw $this->createNotFoundException('La categoría no existe.');
        }

        $posts = $this->postRepository->findBy(['categoria' => $categoria]);
        $importantPosts = array_filter($posts, fn($post) => $post->isImportant());
        $normalPosts = array_filter($posts, fn($post) => !$post->isImportant());       

        return $this->render('categoria/show.html.twig', [
            'categoria' => $categoria,
            'importantPosts' => $importantPosts,
            'normalPosts' => $normalPosts,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    // Manejo de Posts

    #[Route('/posts', name: 'post_index')]
    public function index(EntityManagerInterface $entityManager, PostRepository $postRepository, CategoriaRepository $categoriaRepository, ForoRepository $foroRepository): Response
    {
        $foro = $this->foroRepository->findLatest();
        if ($foro === null) {
            throw new \Exception("No se encontraron configuraciones de foro.");
        }
    
        $postsNormalesLimit = $foro->getPostsNormalesLimit();
        $postsImportantesLimit = $foro->getPostsImportantesLimit();
        
        $categories = $categoriaRepository->findWithPostAndCommentCount();
        
        $importantPosts = $postRepository->findImportantPosts($postsImportantesLimit);
        $latestPosts = $postRepository->findLatestPostsExcludingImportant($postsNormalesLimit);
        
        return $this->renderWithMenu('post/index.html.twig', [
            'categories' => $categories,
            'importantPosts' => $importantPosts,
            'latestPosts' => $latestPosts,
            'foro'=>$foro,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }
    


    #[Route('/post/nuevo', name: 'post_new')]
    public function newPost(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $post->setAuthor($user); 

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->renderWithMenu('post/new.html.twig', [
            'form' => $form->createView(),
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }


    #[Route('/post/{id}/editar', name: 'post_edit')]
    public function editPost(Request $request, EntityManagerInterface $entityManager, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        $deleteForm = $this->createFormBuilder()
        ->setAction($this->generateUrl('post_delete', ['id' => $post->getId()]))
        ->setMethod('DELETE')
        ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->renderWithMenu('post/edit.html.twig', [
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            'post' => $post,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

//Favorito
#[Route('/post/{id}/favorito', name: 'post_favorito', methods: ['POST'])]
public function toggleFavorite(Post $post, Request $request): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    $entityManager = $this->getDoctrine()->getManager();
    $user = $this->getUser();

    // Verificar el token CSRF
    if (!$this->isCsrfTokenValid('toggle_favorite', $request->request->get('_token'))) {
        throw new InvalidCsrfTokenException();
    }

    // Lógica para agregar o quitar el favorito
    $favoritePost = $entityManager->getRepository(FavoritePost::class)->findOneBy(['post' => $post, 'user' => $user]);

    if ($favoritePost) {
        // Eliminar el favorito
        $entityManager->remove($favoritePost);
    } else {
        // Agregar el favorito
        $favoritePost = new FavoritePost();
        $favoritePost->setPost($post);
        $favoritePost->setUser($user);
        $entityManager->persist($favoritePost);
    }

    $entityManager->flush();

    return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
}


//Importante
    
    #[Route('/post/{id}/importante', name: 'post_important', methods: ['POST'])]
    public function important(Post $post, EntityManagerInterface $entityManager, Request $request): Response
    {
        $post->setImportant(!$post->isImportant());
        $entityManager->flush();

        return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
    }

    // Manejo de Comentarios

    #[Route('/post/{postId}/comentario/nuevo', name: 'comentario_new', methods: ['POST'])]
    public function newcomentario(Request $request, EntityManagerInterface $entityManager, Post $post): Response
    {
        $comentario = new Comentario();
        $comentario->setPost($post);
        $form = $this->createForm(ComentarioType::class, $comentario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentario->setAuthor($this->getUser());
            $entityManager->persist($comentario);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->renderWithMenu('comentario/new.html.twig', [
            'form' => $form->createView(),
            'post' => $post, 
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[Route('comentario/{id}', name: 'comentario_show')]
    public function show(Comentario $comentario): Response
    {
        $foro = $this->foroRepository->findLatest();

        $post = $comentario->getPost();
        $comentarios = $post->getComentarios();

        $form = $this->createForm(ComentarioType::class);

        return $this->renderWithMenu('comentario/show.html.twig', [
            'sitio' => $this->sitio,
            'menues' => $this->menues,
            'post' => $post,
            'foro' => $foro,
            'comentarios' => $comentarios,
            'comentarioForm'=>$form,
        ]);
    }

    // Mostrar un Post con Comentarios
    #[Route('/post/{id}', name: 'post_show')]
public function showPost(Request $request, Post $post): Response
{
    $comentario = new Comentario();
    $form = $this->createForm(ComentarioType::class, $comentario);
    $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) {
        $comentario->setPost($post);
        $comentario->setAuthor($this->getUser());
        $this->entityManager->persist($comentario);
        $this->entityManager->flush();
 
        return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
    }
 
    $comentarios = $post->getComentarios();
 
    return $this->renderWithMenu('post/show.html.twig', [
        'post' => $post,
        'comentarios' => $comentarios,
        'comentarioForm' => $form->createView(),
        'foro' => $this->foroRepository->findLatest(),
        'sitio' => $this->sitio,
        'menues' => $this->menues,
    ]);
}

    




    // Eliminar un Post

    #[Route('/post/{id}/eliminar', name: 'post_delete')]
    public function deletePost(EntityManagerInterface $entityManager, Post $post): Response
    {
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('post_index');
    }

    // Eliminar una Categoría

    #[Route('/categoria/{id}/eliminar', name: 'categoria_delete')]
    public function deletecategoria(EntityManagerInterface $entityManager, Categoria $categoria): Response
    {
        $entityManager->remove($categoria);
        $entityManager->flush();

        return $this->redirectToRoute('categoria_index'); 
    }
}
