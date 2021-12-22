<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Api;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Prisma\DecidirPromotions\Api\Data\TransactionInterface;

interface TransactionRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * Save the transaction log into the database
     *
     * @param TransactionInterface $transaction
     * @return mixed
     * @throws Exception if the rule model can't be saved
     */
    public function save(TransactionInterface $transaction);

    /**
     * Delete the transaction log into the database
     *
     * @param TransactionInterface $transaction
     * @return mixed
     * @throws Exception if the rule model can't be deleted
     */
    public function delete(TransactionInterface $transaction);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Prisma\DecidirPromotions\Api\Data\RuleSearchResultsInterface
     */
    public function getTransactionList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
