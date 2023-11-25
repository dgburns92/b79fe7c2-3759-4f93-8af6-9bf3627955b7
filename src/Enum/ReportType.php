<?php

declare(strict_types=1);

namespace App\Enum;

enum ReportType: string
{
    case Diagnostic = 'Diagnostic';

    case Progress = 'Progress';

    case Feedback = 'Feedback';
}
