<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Factory\ItemUpdaterFactory;
use GildedRose\Factory\ItemUpdaterFactoryBuilder;
use GildedRose\Item;
use GildedRose\Updater\DefaultUpdater;
use GildedRose\Updater\SulfurasUpdater;
use PHPUnit\Framework\TestCase;

class ItemUpdaterFactoryTest extends TestCase
{
    public function testReturnsFirstUpdaterThatSupportsItem(): void
    {
        $factory = new ItemUpdaterFactory([
            new SulfurasUpdater(),
            new DefaultUpdater(),
        ]);

        $item = new Item('+5 Dexterity Vest', 10, 20);
        $updater = $factory->for($item);

        $this->assertInstanceOf(DefaultUpdater::class, $updater);
    }

    public function testThrowsWhenNoUpdaterMatches(): void
    {
        $this->expectException(\RuntimeException::class);

        $factory = new ItemUpdaterFactory([]);
        $factory->for(new Item('Unknown', 1, 1));
    }

    public function testBuilderProvidesDefaultStrategies(): void
    {
        $factory = ItemUpdaterFactoryBuilder::withDefaults();

        $updater = $factory->for(new Item('Sulfuras, Hand of Ragnaros', 1, 80));

        $this->assertInstanceOf(SulfurasUpdater::class, $updater);
    }
}
