<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Api;

use Exception;
use Prisma\PaywayPromotions\Api\Data\CreditCardInterface;

/**
 * Interface CreditCardRepositoryInterface
 *
 * @api
 * Interface for specific CC save and delete entities
 */
interface CreditCardRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * Save the CC into the database
     *
     * @param CreditCardInterface $creditCard
     * @return mixed
     * @throws Exception if the CC model can't be saved
     */
    public function save(CreditCardInterface $creditCard);

    /**
     * Delete the CC and all his specific data from the database
     *
     * @param CreditCardInterface $creditCard
     * @return mixed
     * @throws Exception if the CC model  can't be deleted
     */
    public function delete(CreditCardInterface $creditCard);
}
