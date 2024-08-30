<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionnaireFixtures extends Fixture
{
    private const array QUESTIONNAIRE = [
        'Do you have difficulty getting or maintaining an erection?' => [
            'Yes',
            'No',
        ],
        'Have you tried any of the following treatments before?' => [
            'Viagra or Sildenafil',
            'Cialis or Tadalafil',
            'Both',
            'None of the above',
        ],
        'Do you have, or have you ever had, any heart or neurological conditions?' => [
            'Yes',
            'No',
        ],
        'Do any of the listed medical conditions apply to you?' => [
            'Significant liver problems (such as cirrhosis of the liver) or kidney problems',
            'Currently prescribed GTN, Isosorbide mononitrate, Isosorbide dinitrate , Nicorandil (nitrates) or Rectogesic ointment',
            'Abnormal blood pressure (lower than 90/50 mmHg or higher than 160/90 mmHg)',
            "Condition affecting your penis (such as Peyronie's Disease, previous injuries or an inability to retract your foreskin)",
            "I don't have any of these conditions",
        ],
        'Are you taking any of the following drugs?' => [
            'Alpha-blocker medication such as Alfuzosin, Doxazosin, Tamsulosin, Prazosin, Terazosin or over-the-counter Flomax',
            'Riociguat or other guanylate cyclase stimulators (for lung problems)',
            'Saquinavir, Ritonavir or Indinavir (for HIV)',
            'Cimetidine (for heartburn)',
            "I don't take any of these drugs",
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $category = (new Category())
            ->setName('Erectile Dysfunction (ED)')
        ;

        $manager->persist($category);

        $conditionalQuestion = null;
        $lastQuestionOrder = 0;
        foreach (static::QUESTIONNAIRE as $question => $answers) {
            $q = (new Question())
                ->setCategory($category)
                ->setOrder(++$lastQuestionOrder)
                ->setText($question)
            ;

            $manager->persist($q);

            if ($question === 'Have you tried any of the following treatments before?') {
                $conditionalQuestion = $q;
            }

            foreach ($answers as $answer) {
                $a = (new Answer())
                    ->setText($answer)
                    ->setQuestion($q)
                ;

                $manager->persist($a);
            }
        }

        $manager->flush();

        $this->createConditionedQuestionsAndAnswers($manager, $category, $conditionalQuestion, $lastQuestionOrder);

        $manager->flush();
    }

    private function createConditionedQuestionsAndAnswers(ObjectManager $manager, Category $category, ?Question $conditionalQuestion, int $lastQuestionOrder)
    {
        if ($conditionalQuestion === null) {
            throw new \UnexpectedValueException('The conditionalQuestion variable should not be null!');
        }

        $manager->refresh($conditionalQuestion);

        $conditionedQuestions = [
            'Was the Viagra or Sildenafil product you tried before effective?' => [
                'Yes',
                'No',
                'conditionalAnswer' => 'Viagra or Sildenafil',
            ],
            'Was the Cialis or Tadalafil product you tried before effective?' => [
                'Yes',
                'No',
                'conditionalAnswer' => 'Cialis or Tadalafil',
            ],
            'Which is your preferred treatment?' => [
                'Viagra or Sildenafil',
                'Cialis or Tadalafil',
                'None of the above',
                'conditionalAnswer' => 'Both',
            ],
        ];

        foreach ($conditionedQuestions as $question => $answers) {
            $q = (new Question())
                ->setCategory($category)
                ->setOrder(++$lastQuestionOrder)
                ->setText($question)
                ->setRestrictedByAnswer($conditionalQuestion->getAnswers()->findFirst(
                    fn(int $key, Answer $answer) => $answer->getText() === $answers['conditionalAnswer'])
                )
            ;

            $manager->persist($q);

            foreach ($answers as $answer) {
                $a = (new Answer())
                    ->setText($answer)
                    ->setQuestion($q)
                ;

                $manager->persist($a);
            }
        }
    }
}
