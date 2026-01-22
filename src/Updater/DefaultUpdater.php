<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Contracts\ItemUpdater;
use GildedRose\Item;

final class DefaultUpdater implements ItemUpdater
{
    public function supports(Item $item): bool
    {
        return true; // catch-all
    }

    public function update(Item $item): void
    {
        $item->sellIn--;
        $delta = 1 + ($item->sellIn < 0 ? 1 : 0);
        $item->quality = max(0, $item->quality - $delta);
    }
}
