<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Contracts\ItemUpdaterResolver;
use GildedRose\Factory\ItemUpdaterFactoryBuilder;

final class GildedRose
{
    /**
     * @param Item[] $items Inventory the service will mutate in place.
     * @param ItemUpdaterResolver|null $resolver Strategy resolver; when null, a default resolver is lazily created.
     */
    public function __construct(
        private array $items,
        private ?ItemUpdaterResolver $resolver = null,
    ) {
        $this->resolver ??= self::defaultResolver();
    }

    /**
     * Advance one day for every item: delegates all rule logic to the registered updaters.
     */
    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->resolver->for($item)->update($item);
        }
    }

    /**
     * Lazily build and cache the default resolver so callers can skip manual wiring.
     */
    private static function defaultResolver(): ItemUpdaterResolver
    {
        return ItemUpdaterFactoryBuilder::withDefaults();
    }
}
