<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;
use Prisma\PaywayPromotions\Model\Management\RuleManagement;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Ports data into the additional information field for further use
 */
class DataAssignObserver extends AbstractDataAssignObserver
{
    const TOKEN = 'token';
    const BIN = 'bin';
    const CC_TYPE = 'cc_type';
    const CC_EXP_MONTH = 'cc_exp_month';
    const CC_EXP_YEAR = 'cc_exp_year';
    const LAST_FOUR_DIGITS = 'last_four_digits';
    const INSTALLMENTS =  'installments';
    const PLAN_INFO = 'plan_info';
    const RULE_DETAIL = 'rule_detail';

    /**
     * @var string[]
     */
    protected $additionalFields = [
        self::TOKEN,
        self::BIN,
        self::CC_TYPE,
        self::CC_EXP_MONTH,
        self::CC_EXP_YEAR,
        self::LAST_FOUR_DIGITS,
        self::INSTALLMENTS,
        self::PLAN_INFO,
        self::RULE_DETAIL
    ];

    /**
     * @var RuleManagement
     */
    private $ruleManagement;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * DataAssignObserver constructor.
     *
     * @param RuleManagement $ruleManagement
     * @param SerializerInterface $serializer
     */
    public function __construct(
        RuleManagement $ruleManagement,
        SerializerInterface $serializer
    ) {
        $this->ruleManagement = $ruleManagement;
        $this->serializer = $serializer;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);

        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if (!is_array($additionalData)) {
            return;
        }

        $paymentInfo = $this->readPaymentModelArgument($observer);

        foreach ($this->additionalFields as $key) {
            if (isset($additionalData[$key])) {
                // set applied rule promotion info if exists
                if ($key == self::PLAN_INFO
                    && $ruleInfo = $this->getAppliedRuleInfo($additionalData[$key])
                ) {
                    $additionalData[self::RULE_DETAIL] = $this->serializer->serialize($ruleInfo);
                }
                $paymentInfo->setAdditionalInformation(
                    $key,
                    $additionalData[$key]
                );
            }
        }
    }

    /**
     * @param string
     * @return array|bool|float|int|string|null
     */
    private function getAppliedRuleInfo($planInfo)
    {
        return $this->ruleManagement->getAppliedRule($planInfo);
    }
}
