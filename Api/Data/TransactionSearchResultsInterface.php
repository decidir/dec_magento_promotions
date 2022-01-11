<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for transaction search results.
 * @api
 * @since 100.0.2
 */
interface TransactionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Transaction list.
     *
     * @return TransactionInterface[]
     */
    public function getItems();

    /**
     * Set Transaction list.
     *
     * @param TransactionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
