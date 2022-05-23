<?php

namespace App\Config;

enum PropertyEnumType: string
{
    case Condo = 'Condominium';
    case Villa = 'Villa';
    case TownHouse = 'TownHouse';
    case Bungalow = 'Bungalow';
}