<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const AGED_BRIE = 'Aged Brie';
    private const BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';
    private const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    private const CONJURED = 'Conjured'; // any name containing this degrades twice as fast

    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items // inventory to manage
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateItem($item); // process each item independently
        }
    }

    private function updateItem(Item $item): void
    {
        if ($this->isSulfuras($item)) { // Sulfuras never changes
            return;
        }

        $this->applyQualityDelta($item, $this->qualityDeltaBeforeSellDate($item)); // adjust quality before sellIn drop
        $item->sellIn--; // one day passes
        if ($item->sellIn < 0) { // after sell date, apply extra rule
            $this->applyQualityDelta($item, $this->qualityDeltaAfterSellDate($item));
        }
    }

    private function qualityDeltaBeforeSellDate(Item $item): int
    {
        if ($this->isAgedBrie($item)) { // Brie improves daily
            return 1;
        }

        if ($this->isBackstagePass($item)) {
            $delta = 1; // base increase
            if ($item->sellIn <= 10) { // extra boost when <=10 days
                $delta++;
            }
            if ($item->sellIn <= 5) { // extra boost when <=5 days
                $delta++;
            }

            return $delta;
        }

        return -$this->getDegradeRate($item); // normal and conjured degrade
    }

    private function qualityDeltaAfterSellDate(Item $item): int
    {
        if ($this->isAgedBrie($item)) { // Brie still improves after expiry
            return 1;
        }

        if ($this->isBackstagePass($item)) { // backstage drops to zero after concert
            return -$item->quality; // zero out
        }

        return -$this->getDegradeRate($item); // normal/conjured degrade again
    }

    
    private function getDegradeRate(Item $item): int
    {
        return $this->isConjured($item) ? 2 : 1; // conjured decays twice as fast
    }

    private function applyQualityDelta(Item $item, int $delta): void
    {
        $item->quality = max(0, min(50, $item->quality + $delta)); // clamp to 0..50
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
