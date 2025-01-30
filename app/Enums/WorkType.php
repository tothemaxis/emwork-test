<?php

namespace App;

enum WorkType: string
{
    case DEVELOPMENT = 'Development';
    case TEST = 'Test';
    case DOCUMENT = 'Document';
}
