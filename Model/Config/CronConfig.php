<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;

class CronConfig
{

    const XPATH_MODULE_ACTIVE = 'payment/payway/cron_active';
    const XPATH_MODULE_OLDER_DAYS = 'payment/payway/transactions_older_day';
    const PAGE_SIZE = 2500;

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->scopeConfig->isSetFlag(
            self::XPATH_MODULE_ACTIVE
        );
    }

    /**
     * @return int
     */
    public function getTransactionOlderDays()
    {
        return (int) $this->scopeConfig->getValue(
            self::XPATH_MODULE_OLDER_DAYS
        );
    }
}
