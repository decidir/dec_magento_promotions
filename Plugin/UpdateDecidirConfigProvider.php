<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types = 1);

namespace Prisma\DecidirPromotions\Plugin;

use Prisma\Decidir\Model\Ui\ConfigProvider;
use Prisma\DecidirPromotions\Model\Management\RuleManagement;

/**
 * Class UpdateDecidirConfigProvider
 *
 * Updates checkoutConfig with acvire promotions
 */
class UpdateDecidirConfigProvider
{

    /**
     * @var RuleManagement $ruleManagement
     */
    protected $ruleManagement;

    /**
     * UpdateDecidirConfigProvider constructor.
     *
     * @param RuleManagement $ruleManagement
     */
    public function __construct(RuleManagement $ruleManagement)
    {
        $this->ruleManagement = $ruleManagement;
    }

    /**
     * @param ConfigProvider $subject
     * @param $result
     * @return array
     */
    public function afterGetConfig(ConfigProvider $subject, $result)
    {
        // fill getConfig with available banks, ccards & plans
        $rules = $this->ruleManagement->getAvailableRules();
        $isActive = count($rules) < 1
            ? false
            : true
        ;
        $result['payment'][ConfigProvider::CODE]['is_active'] = $isActive;

        if ($isActive) {
            $result['payment'][ConfigProvider::CODE]['available_banks'] =
                $this->ruleManagement->getAvailableBanks($rules);
            $result['payment'][ConfigProvider::CODE]['available_cards'] =
                $this->ruleManagement->getAvailableCards($rules);
            $result['payment'][ConfigProvider::CODE]['available_plans'] =
                $this->ruleManagement->getAvailablePlans($rules);
        }

        return $result;
    }
}
