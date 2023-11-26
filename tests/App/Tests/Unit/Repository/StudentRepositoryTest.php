<?php

declare(strict_types=1);

namespace App\Tests\Unit\Repository;

use App\Entity\Student;
use App\Repository\Json\StudentRepository;
use PHPUnit\Framework\TestCase;

class StudentRepositoryTest extends TestCase
{
    public function testFindExpectsStudentWhenUsingCorrectId(): void
    {
        // Arrange
        $studentId = 'student1';
        $repository = new StudentRepository();

        // Act
        $actual = $repository->find($studentId);

        // Assert
        self::assertInstanceOf(Student::class, $actual);
        self::assertSame($studentId, $actual->id);
    }

    public function testFindExpectsNullWhenUsingIncorrectId(): void
    {
        // Arrange
        $repository = new StudentRepository();

        // Act
        $actual = $repository->find('this-id-does-not-exist');

        // Assert
        self::assertNull($actual);
    }
}
