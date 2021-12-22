<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Api;

use Prisma\DecidirPromotions\Model\ResourceModel\Transaction\Collection;
use Prisma\DecidirPromotions\Model\Transaction;

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
