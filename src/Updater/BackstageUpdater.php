<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Contracts\ItemUpdater;
use GildedRose\Item;

final class BackstageUpdater implements ItemUpdater
{
    private const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function supports(Item $item): bool
    {
        return $item->name === self::NAME;
    }

    public function update(Item $item): void
    {
        $item->sellIn--;
        if ($item->sellIn < 0) {
            $item->quality = 0;
            return;
        }

        $boost = 1;
        if ($item->sellIn < 10) {
            $boost++;
        }
        if ($item->sellIn < 5) {
            $boost++;
        }

        $item->quality = min(50, $item->quality + $boost);
    }
}
