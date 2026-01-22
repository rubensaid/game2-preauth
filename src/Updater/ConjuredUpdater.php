<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Contracts\ItemUpdater;
use GildedRose\Item;

final class ConjuredUpdater implements ItemUpdater
{
    public function supports(Item $item): bool
    {
        return str_contains($item->name, 'Conjured');
    }

    public function update(Item $item): void
    {
        $item->sellIn--;
        $rate = 2 * ($item->sellIn < 0 ? 2 : 1);
        $item->quality = max(0, $item->quality - $rate);
    }
}
