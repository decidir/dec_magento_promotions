<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Api;

use Exception;
use Prisma\DecidirPromotions\Api\Data\BankInterface;

/**
 * Interface BankRepositoryInterface
 *
 * @api
 * Interface for specific Bank repository methods
 */
interface BankRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * Save the bank into the database
     *
     * @param $bank
     * @throws Exception if the bank model can't be saved
     * @return mixed
     */
    public function save(BankInterface $bank);

    /**
     * Delete the bank and all his specific data from the database
     *
     * @param $bank
     * @throws Exception if the bank model  can't be deleted
     * @return mixed
     */
    public function delete(BankInterface $bank);
}
