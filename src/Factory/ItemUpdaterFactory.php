<?php

declare(strict_types=1);

namespace GildedRose\Factory;

use GildedRose\Contracts\ItemUpdater;
use GildedRose\Contracts\ItemUpdaterResolver;
use GildedRose\Item;

final class ItemUpdaterFactory implements ItemUpdaterResolver
{
    /**
     * @param ItemUpdater[] $updaters
     */
    public function __construct(
        private array $updaters
    ) {
    }

    public function for(Item $item): ItemUpdater
    {
        foreach ($this->updaters as $updater) {
            if ($updater->supports($item)) {
                return $updater;
            }
        }

        throw new \RuntimeException("No updater registered for {$item->name}");
    }
}
