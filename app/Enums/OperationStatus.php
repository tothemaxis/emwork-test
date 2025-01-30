<?php

namespace App\Enums\Enums;

enum OperationStatus: string
{
    case PROCESSING = 'ดำเนินการ';
    case DONE = 'เสร็จสิ้น';
    case CANCELLED = 'ยกเลิก';
}
