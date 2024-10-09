<?php

namespace App\Enum;


enum OrderStatus: string
{
    case NEW = "new";
    case PENDING = "pending";
    case CLOSED = "closed";
    case IN_PROCESS = "in_process";
}