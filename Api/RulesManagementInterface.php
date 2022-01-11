<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Api;

use Prisma\DecidirPromotions\Model\ResourceModel\Rule\Collection;
use Prisma\DecidirPromotions\Model\Rule;

/**
 * @api
 */
interface RulesManagementInterface
{
    /**
     * Get all rules
     *
     * @return Collection
     */
    public function getRules();

    /**
     * Get Rule Item
     *
     * @param int $ruleId
     * @return Rule
     */
    public function getRuleById(int $ruleId);

    /**
     * Get only active rules
     *
     * @return Collection[]
     */
    public function getActiveRules();

    /**
     * Get rules by cart id
     *
     * @param int $cardId
     * @return Collection[]
     */
    public function getRuleByCardId(int $cardId);

    /**
     * Get rules by bank id
     *
     * @param int $bankId
     * @return Collection[]
     */
    public function getRuleByBankId(int $bankId);
}
