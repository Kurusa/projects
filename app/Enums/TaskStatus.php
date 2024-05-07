<?php

namespace App\Enums;

enum TaskStatus: string
{
    case TODO = 'todo';
    case COMPLETE = 'complete';
}
