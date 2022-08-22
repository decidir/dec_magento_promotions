<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Api;

use Prisma\PaywayPromotions\Model\ResourceModel\Transaction\Collection;
use Prisma\PaywayPromotions\Model\Transaction;

/**
 * @api
 */
interface TransactionManagementInterface
{
    /**
     * Get all transactions
     *
     * @return Collection
     */
    public function getTransactions();

    /**
     * Get Transaction Item
     *
     * @param int $transacionId
     * @return Transaction
     */
    public function getTransactionById(int $transacionId);
}
