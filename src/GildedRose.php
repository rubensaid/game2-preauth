<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Contracts\ItemUpdaterResolver;
use GildedRose\Factory\ItemUpdaterFactoryBuilder;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items,
        private ?ItemUpdaterResolver $resolver = null,
    ) {
        $this->resolver ??= self::defaultResolver();
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->resolver->for($item)->update($item);
        }
    }

    private static function defaultResolver(): ItemUpdaterResolver
    {
        return ItemUpdaterFactoryBuilder::withDefaults();
    }
}
