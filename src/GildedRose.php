<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Contracts\ItemUpdater;
use GildedRose\Factory\ItemUpdaterFactory;
use GildedRose\Updater\AgedBrieUpdater;
use GildedRose\Updater\BackstageUpdater;
use GildedRose\Updater\ConjuredUpdater;
use GildedRose\Updater\DefaultUpdater;
use GildedRose\Updater\SulfurasUpdater;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items,
        private ?ItemUpdaterFactory $factory = null,
    ) {
        $this->factory ??= self::defaultFactory();
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->factory->for($item)->update($item);
        }
    }

    private static function defaultFactory(): ItemUpdaterFactory
    {
        $updaters = [
            new SulfurasUpdater(),
            new BackstageUpdater(),
            new AgedBrieUpdater(),
            new ConjuredUpdater(),
            new DefaultUpdater(),
        ];

        return new ItemUpdaterFactory($updaters);
    }
}
