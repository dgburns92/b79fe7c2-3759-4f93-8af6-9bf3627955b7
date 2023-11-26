<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateReportCommandTest extends KernelTestCase
{
    public function testCommandProvidesCorrectDiagnosticReport(): void
    {
        // Arrange
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $command = $application->find('student:generate-report');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['student1', 0]);

        // Act
        $commandTester->execute(['command' => $command->getName()]);

        // Assert
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            'Tony Stark recently completed Numeracy assessment on 16th December 2021 10:46 AM',
            $output
        );
        $this->assertStringContainsString(
            'He got 15 questions right out of 16. Details by strand given below:',
            $output
        );
        $this->assertStringContainsString('Number and Algebra: 5 out of 5 correct', $output);
        $this->assertStringContainsString('Measurement and Geometry: 7 out of 7 correct', $output);
        $this->assertStringContainsString('Statistics and Probability: 3 out of 4 correct', $output);
    }
}
