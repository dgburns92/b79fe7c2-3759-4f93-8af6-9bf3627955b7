<?php

declare(strict_types=1);

namespace App\Factory;

use App\Builder\ReportBuilderInterface;
use App\Enum\ReportType;

interface ReportBuilderFactoryInterface
{
    public function createBuilderFromType(ReportType $type): ReportBuilderInterface;
}
