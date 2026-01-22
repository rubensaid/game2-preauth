<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Contracts\ItemUpdater;
use GildedRose\Item;

final class AgedBrieUpdater implements ItemUpdater
{
    private const NAME = 'Aged Brie';

    public function supports(Item $item): bool
    {
        return $item->name === self::NAME;
    }

    public function update(Item $item): void
    {
        $item->sellIn--;
        $gain = 1 + ($item->sellIn < 0 ? 1 : 0);
        $item->quality = min(50, $item->quality + $gain);
    }
}
