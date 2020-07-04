<?php

declare(strict_types=1);

namespace App\Services\Validation\Rules;

use App\Services\Validation\RulesFactory;

/**
 * Class ReviewRules
 * @package App\Services\Validation\Rules
 */
class ReviewRules implements RulesFactory
{
    /**
     * @inheritDoc
     */
    public function getRules(): array
    {
        return array_merge(
            $this->getWorkInTeamRules(),
            $this->getCommunicationRules(),
            $this->getEffectivenessRules(),
            $this->getIndependenceRules(),
            $this->getInterpersonalQualitiesRules(),
            $this->getOtherRules()
        );
    }

    /**
     * @return array
     */
    protected function getWorkInTeamRules(): array
    {
        $prefix = 'workInTeam_';

        return [
            $prefix . 'perceiveConstructiveCriticism' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'takesInitiative' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'teamworkToSolveProblems' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'involvedInWork' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'trustworthyTeamMember' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getCommunicationRules(): array
    {
        $prefix = 'communication_';

        return [
            $prefix . 'respectAndTactfulInCommunication' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'listensAndClarifiesInformation' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'openAndAvailableForCommunication' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'explainsIdeasInSpokenLanguage' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'explainsWrittenIdeas' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getEffectivenessRules(): array
    {
        $prefix = 'effectiveness_';

        return [
            $prefix . 'showsDiligenceInDayToDayWork' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'meetsDeadlines' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'worksWithoutMistakes' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'goodInMultitasking' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'findsEffectiveSolutionsToSimplifyWork' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getIndependenceRules(): array
    {
        $prefix = 'independence_';

        return [
            $prefix . 'responsibleForResultsOfHisWork' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'independentWork' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'independentWorkWithDifficulties' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'adequatelyEvaluateSkillsAndAbilities' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'ableToTakeResponsibilityForMistakes' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
        ];
    }

    /**
     * @return array
     */
    private function getInterpersonalQualitiesRules(): array
    {
        $prefix = 'interpersonalQualities_';

        return [
            $prefix . 'understandingOfOtherPointsOfView' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'takesIntoConsiderationOtherPointsOfView' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'stressResistance' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'providesHonestReviews' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
            $prefix . 'openForNewIdeas' => [
                'required',
                'string',
                'in:-2,-1,1,2',
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getOtherRules(): array
    {
        return [
            'workExperienceWithAnEmployee' => [
                'required',
                'string',
                'between:-2,2',
            ],
            'strongPersonalCharacteristics' => [
                'required',
                'string',
                'min:20',
                'max:32500',
            ],
            'weakSides' => [
                'required',
                'string',
                'min:20',
                'max:32500',
            ],
            'otherComments' => [
                'required',
                'string',
                'min:20',
                'max:32500',
            ],
        ];
    }
}
