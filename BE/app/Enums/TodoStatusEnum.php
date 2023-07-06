<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TodoStatusEnum extends Enum
{
    const Todo = 0;
    const Inprogress = 1;
    const Done = 2;
}
