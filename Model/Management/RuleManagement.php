<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model\Management;

use Prisma\PaywayPromotions\Api\RulesManagementInterface;
use Prisma\PaywayPromotions\Model\Rule;
use Prisma\PaywayPromotions\Model\ResourceModel\Rule\CollectionFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Config\Model\Config\Source\Locale\Weekdays;
use Psr\Log\LoggerInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\CreditCard\CollectionFactory as CardCollectionFactory;
use Prisma\PaywayPromotions\Model\ResourceModel\Bank\CollectionFactory as BankCollectionFactory;
use Prisma\PaywayPromotions\Api\Data\RuleInterface;

/**
 * Class RuleManagement
 *
 * Manage Rule Data
 */
class RuleManagement implements RulesManagementInterface
{
    const COLUMN_TO_SORT_BY = 'priority';

    /**
     * @var  Rule $rule
     */
    protected $rule;

    /**
     * @var CollectionFactory $collectionFactory
     */
    protected $collectionFactory;

    /**
     * @var CardCollectionFactory $cardCollectionFactory
     */
    protected $cardCollectionFactory;

    /**
     * @var BankCollectionFactory $bankCollectionFactory
     */
    protected $bankCollectionFactory;

    /**
     * @var DateTime $date
     */
    protected $date;

    /**
     * @var TimezoneInterface $timezone
     */
    protected $timezone;

    /**
     * @var Weekdays $weekdays
     */
    protected $weekdays;

    /**
     * @var LoggerInterface $logger
     */
    protected $logger;
    /**
     * @var SerializerInterface $serializer
     */
    protected SerializerInterface $serializer;

    /**
     * RuleManagement constructor.
     *
     * @param Rule $rule
     * @param CollectionFactory $collectionFactory
     * @param CardCollectionFactory $cardCollectionFactory
     * @param BankCollectionFactory $bankCollectionFactory
     * @param DateTime $date
     * @param TimezoneInterface $timezone
     * @param Weekdays $weekdays
     * @param LoggerInterface $logger
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Rule $rule,
        CollectionFactory $collectionFactory,
        CardCollectionFactory $cardCollectionFactory,
        BankCollectionFactory $bankCollectionFactory,
        DateTime $date,
        TimezoneInterface $timezone,
        Weekdays $weekdays,
        LoggerInterface $logger,
        SerializerInterface $serializer
    ) {
        $this->rule = $rule;
        $this->collectionFactory = $collectionFactory;
        $this->cardCollectionFactory = $cardCollectionFactory;
        $this->bankCollectionFactory = $bankCollectionFactory;
        $this->date = $date;
        $this->timezone = $timezone;
        $this->weekdays = $weekdays;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function getRules()
    {
        return $this->collectionFactory->create();
    }

    /**
     * {@inheritdoc }
     */
    public function getRuleById(int $ruleId)
    {
        return $this->getRules()->addFilter(RuleInterface::ENTITY_ID, $ruleId)->getFirstItem();
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveRules()
    {
        return $this->getRules()->addFilter(RuleInterface::IS_ACTIVE_FIELD, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function getRuleByCardId($cardId)
    {
        return $this->getRules()->addFilter(RuleInterface::CARDS_FIELD, $cardId);
    }

    /**
     * {@inheritdoc}
     */
    public function getRuleByBankId($bankId)
    {
        return $this->getRules()->addFilter(RuleInterface::BANKS_FIELD, $bankId);
    }

    /**
     * Get available rules sorted by priority
     *
     * @return array
     */
    public function getAvailableRules()
    {
        $availableRules = [];
        $activeRules = $this->getActiveRules();

        if ($activeRules->count() < 1) {
            $this->logger->debug('No active rules found!');
            return $availableRules;
        }

        foreach ($activeRules as $item) {
            if ($this->validateDate($item->getFromDate(), $item->getToDate())
                && $this->validateDays($item->getApplicableDays())
            ) {
                $availableRules[] = $item->getData();
            }
        }
        if (count($availableRules) < 1) {
            $this->logger->debug('No available rule found');
            return $availableRules;
        }

        return  $this->sortRulesByPriority($availableRules);
    }

    /**
     * Valide rule date applicable
     *
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function validateDate(string $from, string $to): bool
    {
        $date = strtotime($this->timezone->date()->format('Y-m-d'));
        $from = strtotime($from);
        $to = strtotime($to);

        return $date >= $from && $date <= $to;
    }

    /**
     * Validate rule date applicable
     *
     * @param $days
     * @return bool
     */
    public function validateDays($days): bool
    {
        $today = date('w');
        $days = explode(',', $days);
        return in_array($today, $days);
    }

    /**
     * Sort array by priority desc order
     *
     * @param $rules
     * @return array
     */
    public function sortRulesByPriority($rules): array
    {
        $col = array_column($rules, self::COLUMN_TO_SORT_BY);
        array_multisort($col, SORT_ASC, $rules);
        return $rules;
    }

    /**
     * Unserialize plans data
     *
     * @param $plans
     * @return array|bool|float|int|string|null
     */
    public function unserializePlans($plans)
    {
        return $this->serializer->unserialize($plans);
    }

    /**
     * Get card info by Id
     *
     * @param $cardId
     * @return array|null
     */
    public function getCardInfo($cardId)
    {
        return $this->cardCollectionFactory->create()->getItemById($cardId)->convertToArray();
    }

    /**
     * Get bank name by Id
     *
     * @param $bankId
     * @return mixed|null
     */
    public function getBankNameById($bankId)
    {
        return $this->bankCollectionFactory->create()->getItemById($bankId)->getDataByKey('bank_name');
    }

    /**
     * Get available planes for valid rules
     *
     * @param $rules
     * @return array
     */
    public function getAvailablePlans($rules)
    {
        $availablePlans = [];
        foreach ($rules as $rule) {
            $planArray = [];
            $cardInfo = $this->getCardInfo($rule[RuleInterface::CARDS_FIELD]);
            $plans = $this->unserializePlans($rule[RuleInterface::FEE_PLANS_FIELD]);
            foreach ($plans as $plan) {
                $planArray[] = [
                    'fee_period' => $plan['fee_period'],
                    'fee_to_send' => $plan['fee_to_send'],
                    'coefficient' => $plan['coefficient'],
                    'tea' => $plan['tea'],
                    'cft' => $plan['cft'],
                    'rule_id' => $rule['entity_id'],
                    'rule_name' => $rule['rule_name']
                ];
            }
            $column = array_column($planArray, "fee_period");
            array_multisort($column, SORT_ASC, $planArray);

            $availablePlans[$rule[RuleInterface::BANKS_FIELD]][$cardInfo['id_sps']] = $planArray;

        }

        return $availablePlans;
    }

    /**
     * Get available banks for valid rules
     *
     * @param $rules
     * @return array
     */
    public function getAvailableBanks($rules)
    {
        $banksArray = [];
        foreach ($rules as $rule) {
            $banksArray[$rule['bank_id']] = $this->getBankNameById($rule['bank_id']);
        }
        return $banksArray;
    }

    /**
     * Get available cards for valid rules
     *
     * @param $rules
     * @return array
     */
    public function getAvailableCards($rules)
    {
        $availableCards =[];
        foreach ($rules as $rule) {
            $cardInfo = $this->getCardInfo($rule['card_id']);
            $availableCards[$rule['bank_id']][$cardInfo['id_sps']] = $cardInfo['card_name'];
        }
        return $availableCards;
    }

    /**
     * @param string $ids
     * @return array|bool
     */
    public function getAppliedRule($ids)
    {
        /** @see view/frontend/web/js/view/payment/method-renderer/payway-promotions-method.js#  */
        if (!$ids || empty($ids)) {
            return false;
        }
        $planDetail = [];
        $idsArray = explode('-', $ids);

        $rule = $this->getRuleById((int) $idsArray[0])->getData();

        $plans = $this->unserializePlans($rule['fee_plans']);
        if (count($plans) >= 1) {
            foreach ($plans as $plan) {
                if ((int) $plan['fee_to_send'] == (int) $idsArray[2]) {
                    $planDetail = $plan;
                }
            }
        }
        unset($planDetail['record_id']);
        unset($planDetail['initialize']);
        $planDetail['rule_name'] = $rule['rule_name'];
        $planDetail['rule_id'] = $rule['entity_id'];
        return $planDetail;
    }
}
