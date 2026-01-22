<?php

declare(strict_types=1);

namespace GildedRose\Contracts;

use GildedRose\Item;

/**
 * Resolves the correct updater strategy for a given item.
 */
interface ItemUpdaterResolver
{
    public function for(Item $item): ItemUpdater;
}
