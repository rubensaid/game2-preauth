<?php

declare(strict_types=1);

namespace GildedRose\Factory;

final class ItemUpdaterFactoryBuilder
{
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
