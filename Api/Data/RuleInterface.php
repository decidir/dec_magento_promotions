<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Api\Data;

/**
 * Interface RuleInterface
 */
interface RuleInterface
{
    const ENTITY_ID = 'entity_id';
    const RULE_NAME_FIELD = 'rule_name';
    const CARDS_FIELD = 'card_id';
    const BANKS_FIELD = 'bank_id';
    const FROM_DATE = 'from_date';
    const TO_DATE = 'to_date';
    const PRIORITY_FIELD = 'priority';
    const IS_ACTIVE_FIELD = 'is_active';
    const APPLICABLE_DAYS_FIELD = 'applicable_days';
    const APPLICABLE_STORES_FIELD = 'applicable_stores';
    const FEE_PLANS_FIELD = 'fee_plans';
    const PLAN_CHARGES_FIELD = 'plan_charges';

    public function getEntityId();
    public function getRuleName();
    public function setRuleName($name);
    public function getCards();
    public function setCards($cards);
    public function getBanks();
    public function setBanks($banks);
    public function getFromDate();
    public function setFromDate($date);
    public function getToDate();
    public function setToDate($date);
    public function getPriority();
    public function setPriority($priority);
    public function getIsActive();
    public function setIsActive($isActive);
    public function getApplicableDays();
    public function setApplicableDays($days);
    public function getApplicableStores();
    public function setApplicableStores($stores);
    public function getFeePlans();
    public function setFeePlans($plans);
}
