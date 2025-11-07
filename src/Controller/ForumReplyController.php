<?php

namespace App\Controller;

use App\Entity\ForumReply;
use App\Form\ForumReplyType;
use App\Repository\ForumReplyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/forum/reply')]
final class ForumReplyController extends AbstractController
{
    #[Route(name: 'app_forum_reply_index', methods: ['GET'])]
    public function index(ForumReplyRepository $forumReplyRepository): Response
    {
        return $this->render('forum_reply/index.html.twig', [
            'forum_replies' => $forumReplyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_forum_reply_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $forumReply = new ForumReply();
        $form = $this->createForm(ForumReplyType::class, $forumReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($forumReply);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_reply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum_reply/new.html.twig', [
            'forum_reply' => $forumReply,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_reply_show', methods: ['GET'])]
    public function show(ForumReply $forumReply): Response
    {
        return $this->render('forum_reply/show.html.twig', [
            'forum_reply' => $forumReply,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_forum_reply_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ForumReply $forumReply, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForumReplyType::class, $forumReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_reply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum_reply/edit.html.twig', [
            'forum_reply' => $forumReply,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_reply_delete', methods: ['POST'])]
    public function delete(Request $request, ForumReply $forumReply, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forumReply->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($forumReply);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_forum_reply_index', [], Response::HTTP_SEE_OTHER);
    }
}
