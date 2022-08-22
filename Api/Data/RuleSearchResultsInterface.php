<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for rule search results.
 * @api
 * @since 100.0.2
 */
interface RuleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Rule list.
     *
     * @return RuleInterface[]
     */
    public function getItems();

    /**
     * Set Rule list.
     *
     * @param RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
