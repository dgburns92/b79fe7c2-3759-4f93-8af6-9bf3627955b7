<?php

declare(strict_types=1);

namespace App\Tests\Unit\Repository;

use App\Entity\Student;
use App\Repository\JsonStudentRepository;
use PHPUnit\Framework\TestCase;

class JsonStudentRepositoryTest extends TestCase
{
    public function testFindExpectsStudentWhenUsingCorrectId(): void
    {
        // Arrange
        $studentId = 'student1';
        $repository = new JsonStudentRepository();

        // Act
        $actual = $repository->find($studentId);

        // Assert
        self::assertInstanceOf(Student::class, $actual);
        self::assertSame($studentId, $actual->id);
    }

    public function testFindExpectsNullWhenUsingIncorrectId(): void
    {
        // Arrange
        $repository = new JsonStudentRepository();

        // Act
        $actual = $repository->find('this-id-does-not-exist');

        // Assert
        self::assertNull($actual);
    }
}
