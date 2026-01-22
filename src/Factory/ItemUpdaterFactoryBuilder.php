<?php

declare(strict_types=1);

namespace GildedRose\Factory;

/**
 * Composition helpers for building item updater factories.
 */
final class ItemUpdaterFactoryBuilder
{
    /**
     * Build a factory with the standard strategy set in priority order.
     */
    public static function withDefaults(): ItemUpdaterFactory
    {
        return new ItemUpdaterFactory([
            new \GildedRose\Updater\SulfurasUpdater(),
            new \GildedRose\Updater\BackstageUpdater(),
            new \GildedRose\Updater\AgedBrieUpdater(),
            new \GildedRose\Updater\ConjuredUpdater(),
            
            new \GildedRose\Updater\DefaultUpdater(),
        ]);
    }
}
