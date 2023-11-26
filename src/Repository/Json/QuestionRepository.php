<?php

declare(strict_types=1);

namespace App\Repository\Json;

use App\Dto\Option;
use App\Entity\Question;
use App\Entity\Student;
use App\Repository\QuestionRepositoryInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    /** @var array<string, Question> $questions */
    private array $questions;

    public function __construct()
    {
        $this->questions = $this->loadQuestions();
    }

    public function findByIds(array $ids): array
    {
        return array_filter($this->questions, static fn(Question $question) => in_array($question->id, $ids, true));
    }

    /** @return array<string, Question> */
    private function loadQuestions(): array
    {
        $json = file_get_contents(__DIR__ . '/data/questions.json');
        if ($json === false) {
            return [];
        }

        /** @var array<int, array{
         *     id: string,
         *     stem: string,
         *     type: string,
         *     strand: string,
         *     config: array{
         *          options: array<int, array{id: string, label: string, value: string}>,
         *          key: string,
         *          hint: string
         *     }
         * }> $data
         */
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $questions = [];

        foreach ($data as $row) {
            $questions[$row['id']] = new Question(
                id: $row['id'],
                stem: $row['stem'],
                type: $row['type'],
                strand: $row['strand'],
                hint: $row['config']['hint'],
                options: array_map(
                    static fn (array $option) => new Option($option['id'], $option['label'], $option['value']),
                    $row['config']['options']
                ),
                answer: $row['config']['key']
            );
        }

        return $questions;
    }
}
