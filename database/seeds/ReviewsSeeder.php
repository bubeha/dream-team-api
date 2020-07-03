<?php

declare(strict_types=1);

use App\Models\Reviews\Review;
use App\Models\User;
use App\Services\Reviews\CreateReviewService;
use Faker\Factory;
use Illuminate\Database\Seeder;

/**
 * Class ReviewsSeeder
 */
class ReviewsSeeder extends Seeder // @codingStandardsIgnoreLine
{

    /**
     * @var CreateReviewService
     */
    private $service;

    public function __construct(CreateReviewService $service)
    {
        $this->service = $service;
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function run(): void
    {
        if (Review::query()->count() > 0) {
            return;
        }

        foreach (User::query()->cursor() as $user) {
            /** @var User $user */

            for ($i = 0, $iMax = random_int(5, 20); $i < $iMax; $i++) {
                $this->service
                    ->create($this->getAuthor($user->getKey()), $user, $this->generateAttributes());
            }
        }
    }

    /**
     * @param $ignoreId
     * @return mixed
     */
    private function getAuthor($ignoreId)
    {
        $user = User::query()->where('id', '!=', $ignoreId)->orderByRaw('RAND()')->first();

        if ($user) {
            return $user;
        }

        throw new RuntimeException('Dosen\'t have users');
    }

    /**
     * @return array
     */
    private function generateAttributes(): array
    {
        $faker = Factory::create();

        $array = [-2, -1, 1, 2];

        return [
            'workInTeam_perceiveConstructiveCriticism' => $this->getRandomItem($array),
            'workInTeam_takesInitiative' => $this->getRandomItem($array),
            'workInTeam_teamworkToSolveProblems' => $this->getRandomItem($array),
            'workInTeam_involvedInWork' => $this->getRandomItem($array),
            'workInTeam_trustworthyTeamMember' => $this->getRandomItem($array),
            'communication_respectAndTactfulInCommunication' => $this->getRandomItem($array),
            'communication_listensAndClarifiesInformation' => $this->getRandomItem($array),
            'communication_openAndAvailableForCommunication' => $this->getRandomItem($array),
            'communication_explainsIdeasInSpokenLanguage' => $this->getRandomItem($array),
            'communication_explainsWrittenIdeas' => $this->getRandomItem($array),
            'effectiveness_showsDiligenceInDayToDayWork' => $this->getRandomItem($array),
            'effectiveness_meetsDeadlines' => $this->getRandomItem($array),
            'effectiveness_worksWithoutMistakes' => $this->getRandomItem($array),
            'effectiveness_goodInMultitasking' => $this->getRandomItem($array),
            'effectiveness_findsEffectiveSolutionsToSimplifyWork' => $this->getRandomItem($array),
            'independence_responsibleForResultsOfHisWork' => $this->getRandomItem($array),
            'independence_independentWork' => $this->getRandomItem($array),
            'independence_independentWorkWithDifficulties' => $this->getRandomItem($array),
            'independence_adequatelyEvaluateSkillsAndAbilities' => $this->getRandomItem($array),
            'independence_ableToTakeResponsibilityForMistakes' => $this->getRandomItem($array),
            'interpersonalQualities_understandingOfOtherPointsOfView' => $this->getRandomItem($array),
            'interpersonalQualities_takesIntoConsiderationOtherPointsOfView' => $this->getRandomItem($array),
            'interpersonalQualities_stressResistance' => $this->getRandomItem($array),
            'interpersonalQualities_providesHonestReviews' => $this->getRandomItem($array),
            'interpersonalQualities_openForNewIdeas' => $this->getRandomItem($array),
            'workExperienceWithAnEmployee' => $this->getRandomItem([-2, -1, 0, 1, 2]),
            'strongPersonalCharacteristics' => $faker->realText(255, 500),
            'weakSides' => $faker->realText(255, 500),
            'otherComments' => $faker->realText(255, 500),
        ];
    }

    /**
     * @param array $array
     * @return mixed
     */
    private function getRandomItem(array $array)
    {
        $index = array_rand($array);

        return $array[$index];
    }
}
