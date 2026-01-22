<?php

declare(strict_types=1);

namespace GildedRose\Contracts;

use GildedRose\Item;

/**
 * Defines how a specific item variant should be updated.
 */
interface ItemUpdater
{
    public function supports(Item $item): bool;

    public function update(Item $item): void;
}
