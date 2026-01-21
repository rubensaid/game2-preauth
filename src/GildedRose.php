<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const AGED_BRIE = 'Aged Brie';
    private const BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';
    private const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    private const CONJURED = 'Conjured';

    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($this->isSulfuras($item)) {
                continue;
            }

            $this->updateBeforeSellDate($item);
            $item->sellIn--;
            if ($item->sellIn < 0) {
                $this->updateAfterSellDate($item);
            }
        }
    }

    private function updateBeforeSellDate(Item $item): void
    {
        if ($this->isAgedBrie($item)) {
            $this->increaseQuality($item);

            return;
        }

        if ($this->isBackstagePass($item)) {
            $this->increaseQuality($item);
            if ($item->sellIn <= 10) {
                $this->increaseQuality($item);
            }
            if ($item->sellIn <= 5) {
                $this->increaseQuality($item);
            }

            return;
        }

        $this->degradeQuality($item, $this->getDegradeRate($item));
    }

    private function updateAfterSellDate(Item $item): void
    {
        if ($this->isAgedBrie($item)) {
            $this->increaseQuality($item);

            return;
        }

        if ($this->isBackstagePass($item)) {
            $item->quality = 0;

            return;
        }

        $this->degradeQuality($item, $this->getDegradeRate($item));
    }

    private function getDegradeRate(Item $item): int
    {
        return $this->isConjured($item) ? 2 : 1;
    }

    private function degradeQuality(Item $item, int $amount): void
    {
        $item->quality = max(0, $item->quality - $amount);
    }

    private function increaseQuality(Item $item, int $amount = 1): void
    {
        $item->quality = min(50, $item->quality + $amount);
    }

    private function isAgedBrie(Item $item): bool
    {
        return $item->name === self::AGED_BRIE;
    }

    private function isBackstagePass(Item $item): bool
    {
        return $item->name === self::BACKSTAGE;
    }

    private function isSulfuras(Item $item): bool
    {
        return $item->name === self::SULFURAS;
    }

    private function isConjured(Item $item): bool
    {
        return str_contains($item->name, self::CONJURED);
    }
}
