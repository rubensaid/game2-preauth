<?php

declare(strict_types=1);

namespace GildedRose\Contracts;

use GildedRose\Item;

interface ItemUpdaterResolver
{
    public function for(Item $item): ItemUpdater;
}
