<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Prisma\DecidirPromotions\Api\Data\RuleInterface;
use Prisma\DecidirPromotions\Model\ResourceModel\Rule as ResourceModel;

class Rule extends AbstractModel implements RuleInterface, IdentityInterface
{
    const CACHE_TAG = 'prisma_decidir_promotions_rules';

    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    public function getCards()
    {
        return $this->getData(RuleInterface::CARDS_FIELD);
    }

    public function setCards($cards)
    {
        $this->setData(RuleInterface::CARDS_FIELD, $cards);
    }

    public function getBanks()
    {
        return $this->getData(RuleInterface::BANKS_FIELD);
    }

    public function setBanks($banks)
    {
        $this->setData(RuleInterface::BANKS_FIELD, $banks);
    }

    public function getFromDate()
    {
        return $this->getData(RuleInterface::FROM_DATE);
    }

    public function setFromDate($date)
    {
        $this->setData(RuleInterface::FROM_DATE, $date);
    }

    public function getToDate()
    {
        return $this->getData(RuleInterface::TO_DATE);
    }

    public function setToDate($date)
    {
        $this->setData(RuleInterface::TO_DATE, $date);
    }

    public function getPriority()
    {
        return $this->getData(RuleInterface::PRIORITY_FIELD);
    }

    public function setPriority($priority)
    {
        $this->setData(RuleInterface::PRIORITY_FIELD, $priority);
    }

    public function getIsActive()
    {
        return $this->getData(RuleInterface::IS_ACTIVE_FIELD);
    }

    public function setIsActive($isActive)
    {
        $this->setData(RuleInterface::IS_ACTIVE_FIELD, $isActive);
    }

    public function getApplicableDays()
    {
        return $this->getData(RuleInterface::APPLICABLE_DAYS_FIELD);
    }

    public function setApplicableDays($days)
    {
        $this->setData(RuleInterface::APPLICABLE_DAYS_FIELD, $days);
    }

    public function getApplicableStores()
    {
        return $this->getData(RuleInterface::APPLICABLE_STORES_FIELD);
    }

    public function setApplicableStores($stores)
    {
        $this->setData(RuleInterface::APPLICABLE_STORES_FIELD, $stores);
    }

    public function getFeePlans()
    {
        return $this->getData(RuleInterface::FEE_PLANS_FIELD);
    }

    public function setFeePlans($plans)
    {
        $this->setData(RuleInterface::FEE_PLANS_FIELD, $plans);
    }

    public function getRuleName()
    {
        return $this->getData(RuleInterface::RULE_NAME_FIELD);
    }

    public function setRuleName($name)
    {
        $this->setData(RuleInterface::RULE_NAME_FIELD, $name);
    }
}
