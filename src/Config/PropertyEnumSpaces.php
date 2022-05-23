<?php

namespace App\Config;

enum PropertyEnumSpaces: string
{
    case None = 'None';
    case Private = 'Private';
    case Shared = 'Shared';
}