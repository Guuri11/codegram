<?php

namespace App\Controller;

use App\Entity\Following;
use App\Form\FollowingType;
use App\Repository\FollowingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/following")
 */
class FollowingController extends AbstractController
{
    /**
     * @Route("/", name="following_index", methods={"GET"})
     */
    public function index(FollowingRepository $followingRepository): Response
    {
        return $this->render('following/index.html.twig', [
            'followings' => $followingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="following_new", methods={"GET","POST"})
     */
    public function new(Request $request, FollowingRepository $followingRepository): Response
    {
        $following = new Following();
        $form = $this->createForm(FollowingType::class, $following);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $exists = $followingRepository->findOneBy(['user'=>$following->getUser(), 'user_followed'=> $following->getUserFollowed()]);

            if (!$exists && $following->getUser() !== $following->getUserFollowed()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($following);
                $entityManager->flush();
            }

            return $this->redirectToRoute('following_index');
        }

        return $this->render('following/new.html.twig', [
            'following' => $following,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="following_show", methods={"GET"})
     */
    public function show(Following $following): Response
    {
        return $this->render('following/show.html.twig', [
            'following' => $following,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="following_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Following $following): Response
    {
        $form = $this->createForm(FollowingType::class, $following);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('following_index');
        }

        return $this->render('following/edit.html.twig', [
            'following' => $following,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="following_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Following $following): Response
    {
        if ($this->isCsrfTokenValid('delete'.$following->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($following);
            $entityManager->flush();
        }

        return $this->redirectToRoute('following_index');
    }
}
