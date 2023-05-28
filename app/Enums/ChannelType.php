<?php

namespace App\Enums;

enum ChannelType: int
{
    case TEXT = 0;
    case VOICE = 1;
}