<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Reponse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuizFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création du quiz
        $quiz = new Quiz();
        $quiz->setTitre('Quiz de test - Clinikids');
        $quiz->setDescription('Un quiz de démonstration pour tester le système.');
        $manager->persist($quiz);

        // Tableau des questions et réponses
        $data = [
            [
                'texte' => 'Quelle couleur obtient-on en mélangeant le bleu et le jaune ?',
                'reponses' => [
                    ['Vert', true, 'Bleu + Jaune = Vert.'],
                    ['Rouge', false, 'Rouge ne résulte pas de ce mélange.'],
                    ['Orange', false, 'Orange = Rouge + Jaune.'],
                    ['Violet', false, 'Violet = Bleu + Rouge.'],
                ],
            ],
            [
                'texte' => 'Combien de pattes a une araignée ?',
                'reponses' => [
                    ['6', false, 'Les insectes ont 6 pattes, mais pas les araignées.'],
                    ['8', true, 'Une araignée a bien 8 pattes.'],
                    ['10', false, 'Trop !'],
                    ['4', false, 'Trop peu.'],
                ],
            ],
            [
                'texte' => 'Quel organe pompe le sang dans le corps humain ?',
                'reponses' => [
                    ['Le cœur', true, 'Le cœur pompe le sang.'],
                    ['Le cerveau', false, 'Le cerveau contrôle, mais ne pompe pas le sang.'],
                    ['Le foie', false, 'Le foie filtre, mais ne pompe pas.'],
                    ['Les poumons', false, 'Ils servent à la respiration, pas à pomper le sang.'],
                ],
            ],
        ];

        // Boucle sur chaque question
        foreach ($data as $qData) {
            $question = new Question();
            $question->setTexte($qData['texte']);
            $question->setQuiz($quiz);
            $manager->persist($question);

            foreach ($qData['reponses'] as [$texte, $correcte, $justif]) {
                $reponse = new Reponse();
                $reponse->setTexte($texte);
                $reponse->setCorrecte($correcte);
                $reponse->setJustification($justif);
                $reponse->setQuestion($question);
                $manager->persist($reponse);
            }
        }

        $manager->flush();
    }
}
