<?php


namespace App\Enums;


use Spatie\Enum\Enum;

final class CategoryType extends Enum
{
    const UnActiveCategory = 0;
    const ActiveCategory = 1;
    const mainCategory = 1;
    const subCategory = 2;

}
