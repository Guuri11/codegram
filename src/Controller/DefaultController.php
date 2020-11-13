<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\PostRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(PostRepository $postRepository): Response
    {
        /**
         * extraer posts de la gente sigo y yo mismo.
         * posts en el que el usuario tenga de seguidor a mua || post tenga de usuario a mua 
         * ordenado de mas nuevo a viejo
         */
        //$posts = $postRepository->findBy()

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/profile", name="profile_redirect", methods={"GET"})
     */
    public function profile_redirect(): Response
    {
        return $this->redirect('/profile/'.$this->getUser()->getUsername());
    }

    /**
     * @Route("/profile/{username}", name="user_profile", methods={"GET", "POST"})
     */
    public function profile(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
