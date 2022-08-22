<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Api;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Prisma\PaywayPromotions\Api\Data\RuleInterface;

interface RuleRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * Save the rule into the database
     *
     * @param RuleInterface $rule
     * @return mixed
     * @throws Exception if the rule model can't be saved
     */
    public function save(RuleInterface $rule);

    /**
     * Delete the rule and all his specific data from the database
     *
     * @param RuleInterface $rule
     * @return mixed
     * @throws Exception if the rule model  can't be deleted
     */
    public function delete(RuleInterface $rule);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Prisma\PaywayPromotions\Api\Data\RuleSearchResultsInterface
     */
    public function getRuleList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
