<?php

declare(strict_types=1);

namespace GildedRose\Updater;

use GildedRose\Contracts\ItemUpdater;
use GildedRose\Item;

final class SulfurasUpdater implements ItemUpdater
{
    private const NAME = 'Sulfuras, Hand of Ragnaros';

    public function supports(Item $item): bool
    {
        return $item->name === self::NAME;
    }

    public function update(Item $item): void
    {
        // Legendary item: nothing changes.
    }
}
