<?php

namespace App\Controller;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class QuizPlayController extends AbstractController
{
    #[Route('/quiz/{id}/play', name: 'quiz_play')]
    public function play(Quiz $quiz, Request $request, SessionInterface $session)
    {
        $qIndex = $request->query->getInt('q', 0);
        $questions = $quiz->getQuestions();
        $total = count($questions);

        if ($total === 0) {
            return $this->render('quiz_play/error.html.twig', [
                'message' => 'Ce quiz ne contient aucune question.'
            ]);
        }

        if ($qIndex >= $total) {
            return $this->redirectToRoute('quiz_result', ['id' => $quiz->getId()]);
        }

        $question = $questions[$qIndex];
        $feedback = null;

        if ($request->isMethod('POST')) {
            $selectedId = (int) $request->request->get('answer');
            $correct = null;
            $justification = null;

            foreach ($question->getReponses() as $r) {
                if ($r->isCorrecte()) {
                    $correct = $r->getId();
                    $justification = $r->getJustification();
                    break;
                }
            }

            $isCorrect = ($selectedId === $correct);

            $answers = $session->get('quiz_'.$quiz->getId().'_answers', []);
            $answers[$question->getId()] = [
                'selected' => $selectedId,
                'isCorrect' => $isCorrect,
                'correct' => $correct,
                'justification' => $justification
            ];
            $session->set('quiz_'.$quiz->getId().'_answers', $answers);

            // Redirection vers la question suivante
            return $this->redirectToRoute('quiz_play', [
                'id' => $quiz->getId(),
                'q' => $qIndex + 1
            ]);
        }

        return $this->render('quiz_play/question.html.twig', [
            'quiz' => $quiz,
            'question' => $question,
            'qIndex' => $qIndex,
            'total' => $total
        ]);
    }

    #[Route('/quiz/{id}/result', name: 'quiz_result')]
    public function result(Quiz $quiz, SessionInterface $session)
    {
        $answers = $session->get('quiz_'.$quiz->getId().'_answers', []);
        $score = 0;
        foreach ($answers as $a) {
            if ($a['isCorrect']) $score++;
        }
        $total = count($quiz->getQuestions());

        return $this->render('quiz_play/result.html.twig', [
            'quiz' => $quiz,
            'answers' => $answers,
            'score' => $score,
            'total' => $total
        ]);
    }
}
