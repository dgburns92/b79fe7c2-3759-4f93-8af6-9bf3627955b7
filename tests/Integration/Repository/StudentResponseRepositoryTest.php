<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Entity\Student;
use App\Repository\Json\AssessmentRepository;
use App\Repository\Json\StudentRepository;
use App\Repository\Json\StudentResponseRepository;
use PHPUnit\Framework\TestCase;

class StudentResponseRepositoryTest extends TestCase
{
    public function testFindByStudentExpectsAllToBeRelatedToStudent(): void
    {
        // Arrange
        $student = new Student('student1', 'Tony', 'Stark', 6);
        $repo = new StudentResponseRepository(new StudentRepository(), new AssessmentRepository());

        // Act
        $actual = $repo->findByStudent($student);

        // Assert
        foreach ($actual as $response) {
            self::assertSame($student->id, $response->student->id);
        }
    }
}
