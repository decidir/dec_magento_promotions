<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Block\Adminhtml;

use Magento\Payment\Block\Info\Cc;
use Magento\Framework\App\State;
use Magento\Framework\Serialize\SerializerInterface;
use Prisma\PaywayPromotions\Api\Data\RuleInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Class Info
 *
 * Provides info about payment
 */
class Info extends Cc
{
    /**
     * @var string
     */
    const AREA_CODE_ADMIN = 'adminhtml';

    /**
     * Payment config model
     *
     * @var \Magento\Payment\Model\Config
     */
    protected $_paymentConfig;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $_state;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /** @var PriceCurrencyInterface $priceCurrency */
    protected $priceCurrency;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Payment\Model\Config $paymentConfig
     * @param \Magento\Framework\App\State $state
     * @param SerializerInterface $serializer
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Payment\Model\Config $paymentConfig,
        State $state,
        SerializerInterface $serializer,
        PriceCurrencyInterface $priceCurrency,
        array $data = []
    ) {
        parent::__construct($context, $paymentConfig, $data);
        $this->_paymentConfig = $paymentConfig;
        $this->_state = $state;
        $this->serializer = $serializer;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * Retrieve credit card type name
     *
     * @return string
     */
    public function getCcTypeName()
    {
        $types = $this->_paymentConfig->getCcTypes();
        $ccType = $this->getInfo()->getCcType();
        if (isset($types[$ccType])) {
            return $types[$ccType];
        }
        return empty($ccType) ? __('N/A') : $ccType;
    }

    /**
     * Whether current payment method has credit card expiration info
     *
     * @return int
     */
    public function hasCcExpDate()
    {
        return (int)$this->getInfo()->getCcExpMonth() || (int)$this->getInfo()->getCcExpYear();
    }

    /**
     * Retrieve CC expiration month
     *
     * @return string
     */
    public function getCcExpMonth()
    {
        $month = $this->getInfo()->getCcExpMonth();
        if ($month < 10) {
            $month = '0' . $month;
        }
        return $month;
    }

    /**
     * Retrieve CC expiration date
     *
     * @return \DateTime
     */
    public function getCcExpDate()
    {
        $date = new \DateTime('now', new \DateTimeZone($this->_localeDate->getConfigTimezone()));
        $date->setDate(
            $this->getInfo()->getCcExpYear(),
            $this->getInfo()->getCcExpMonth() + 1,
            0
        );
        return $date;
    }

    /**
     * Prepare credit card related payment info
     *
     * @param \Magento\Framework\DataObject|array $transport
     * @return \Magento\Framework\DataObject
     */
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation) {
            return $this->_paymentSpecificInformation;
        }
        if ($ruleDetail = $this->getInfo()->getAdditionalInformation('rule_detail')) {
            $ruleDetail = $this->serializer->unserialize($ruleDetail);
            $installmentsGateway =  $ruleDetail['fee_to_send'];
            $installmentsFrontend = $ruleDetail['fee_period'];
            $ruleInfo = $ruleDetail['rule_name'] . ' - ID #' . $ruleDetail['rule_id'];

        }
        $transport = parent::_prepareSpecificInformation($transport);
        $data = [];

        if ($ccType = $this->getCcTypeName()) {
            $data[(string)__('Credit Card Type')] = $ccType;
        }
        if ($this->getInfo()->getCcLast4()) {
            $data[(string)__('Credit Card Number')] = sprintf('xxxx-%s', $this->getInfo()->getCcLast4());
        }
        if (isset($installmentsFrontend)) {
            $data[(string)__('Installments')] = $installmentsFrontend;
        }
        $planCharge = $this->getInfo()->getAdditionalInformation(RuleInterface::PLAN_CHARGES_FIELD);

        if ($planCharge !== null && $planCharge > 0) {
            $data[(string)__('Plan Charge')] = $this->priceCurrency->convertAndFormat($planCharge, false);
        }

        if ($this->_state->getAreaCode() == self::AREA_CODE_ADMIN) {
            if (isset($installmentsGateway)) {
                $data[(string)__('Installments for Gateway')] = $installmentsGateway;
            }
            if ($ccStatus = $this->getInfo()->getCcStatus()) {
                $data[(string)__('Status')] = sprintf('%s', $ccStatus);
                if ($ccStatusDescription = $this->getInfo()->getCcStatusDescription()) {
                    $data[(string)__('Status')] .= sprintf('%s', ' - ('. $ccStatusDescription .')');
                }
            }
            if ($this->getCcExpMonth()) {
                $data[(string)__('Cc Expiration Month')] = sprintf('%s', $this->getCcExpMonth());
            }
            if ($this->getInfo()->getAdditionalInformation('cc_exp_year')) {
                $data[(string)__('Cc Expiration Year')] = $this->getInfo()->getAdditionalInformation('cc_exp_year');
            }
            if ($this->getInfo()->getAddressStatus()) {
                $data[(string)__('Address Status Code')] = $this->getInfo()->getAddressStatus();
            }
            if ($ccTicket = $this->getInfo()->getAdditionalInformation('ticket')) {
                $data[(string)__('Ticket')] = $ccTicket;
            }
            if ($ccAuthCode = $this->getInfo()->getAdditionalInformation('card_authorization_code')) {
                $data[(string)__('Cc Auth Code')] = $ccAuthCode;
            }
            if ($ccSecureVerify = $this->getInfo()->getCcSecureVerify()) {
                $data[(string)__('CS Decision')] = strtoupper($ccSecureVerify);
            }
            if (isset($ruleInfo)) {
                $data[(string)__('Rule Applied')] = $ruleInfo;
            }

        }

        return $transport->setData(array_merge($data, $transport->getData()));
    }

    /**
     * Format year/month on the credit card
     *
     * @param string $year
     * @param string $month
     * @return string
     */
    protected function _formatCardDate($year, $month)
    {
        return sprintf('%s/%s', sprintf('%02d', $month), $year);
    }
}
