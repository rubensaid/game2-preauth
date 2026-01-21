<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testConjuredLosesTwoBeforeSellDate(): void
    {
        $items = [new Item('Conjured Mana Cake', 3, 10)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame(2, $items[0]->sellIn);
        $this->assertSame(8, $items[0]->quality);
    }

    public function testConjuredLosesFourAfterSellDate(): void
    {
        $items = [new Item('Conjured Mana Cake', 0, 10)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(6, $items[0]->quality);
    }

    public function testConjuredQualityDoesNotGoNegative(): void
    {
        $items = [new Item('Conjured Mana Cake', 0, 1)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame(0, $items[0]->quality);
    }

    public function testNormalItemDegradesTwiceAfterSellDate(): void
    {
        $items = [new Item('Elixir of the Mongoose', 0, 7)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(5, $items[0]->quality);
    }

    public function testAgedBrieIncreasesAndCapsAtFifty(): void
    {
        $items = [new Item('Aged Brie', 1, 49)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame(0, $items[0]->sellIn);
        $this->assertSame(50, $items[0]->quality);
    }

    public function testBackstagePassesDropToZeroAfterConcert(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 0, 40)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);
    }

    public function testSulfurasNeverChanges(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 5, 80)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame(5, $items[0]->sellIn);
        $this->assertSame(80, $items[0]->quality);
    }
}
