<?php

namespace App\Controller;

use App\Entity\ForumPost;
use App\Entity\ForumReply;
use App\Form\ForumPostType;
use App\Form\ForumReplyType;
use App\Repository\ForumPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/forum/post')]
final class ForumPostController extends AbstractController
{
    #[Route(name: 'app_forum_post_index', methods: ['GET'])]
    public function index(ForumPostRepository $forumPostRepository): Response
    {
        return $this->render('forum_post/index.html.twig', [
            'forum_posts' => $forumPostRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_forum_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $forumPost = new ForumPost();
        $forumPost->setAuthor($this->getUser());  // Set current user as author
        $forumPost->setCreatedAt(new \DateTimeImmutable());  // Set timestamp
        $form = $this->createForm(ForumPostType::class, $forumPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($forumPost);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum_post/new.html.twig', [
            'forum_post' => $forumPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_post_show', methods: ['GET'])]
    public function show(ForumPost $forumPost): Response
    {
        return $this->render('forum_post/show.html.twig', [
            'forum_post' => $forumPost,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_forum_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ForumPost $forumPost, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForumPostType::class, $forumPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum_post/edit.html.twig', [
            'forum_post' => $forumPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_post_delete', methods: ['POST'])]
    public function delete(Request $request, ForumPost $forumPost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forumPost->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($forumPost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_forum_post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/forum/post/{id}', name: 'app_forum_post_show', methods: ['GET', 'POST'])]
    public function showReply(ForumPost $forumPost, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Ensure user is logged in to reply (optional but recommended)
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Create a new reply and pre-set the post
        $reply = new ForumReply();
        $reply->setPost($forumPost);
        $reply->setAuthor($this->getUser());  // Set current user as author
        $reply->setCreatedAt(new \DateTimeImmutable());  // Set timestamp
        // Create and handle the form
        $form = $this->createForm(ForumReplyType::class, $reply);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reply);
            $entityManager->flush();
            // Redirect back to the post after saving
            return $this->redirectToRoute('app_forum_post_show', ['id' => $forumPost->getId()]);
        }
        return $this->render('forum_post/show.html.twig', [
            'forum_post' => $forumPost,
            'reply_form' => $form->createView(),
        ]);
    }
}
