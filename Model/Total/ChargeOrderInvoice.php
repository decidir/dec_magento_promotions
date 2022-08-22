<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */

namespace Prisma\PaywayPromotions\Model\Total;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;
use Prisma\Payway\Model\Ui\ConfigProvider;
use Prisma\PaywayPromotions\Api\Data\RuleInterface;
use Prisma\PaywayPromotions\Model\Management\RuleManagement;
use Magento\Framework\Serialize\SerializerInterface;

class ChargeOrderInvoice extends AbstractTotal
{
    /**
     * @var RuleManagement $ruleManagement
     */
    protected $ruleManagement;

    /**
     * @var SerializerInterface $serializer
     */
    protected $serializer;

    /**
     * Charges constructor.
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
     * Collect invoice subtotal
     *
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $subtotal = 0;
        $baseSubtotal = 0;
        $subtotalInclTax = 0;
        $baseSubtotalInclTax = 0;

        $order = $invoice->getOrder();
        $info = $order->getPayment()->getAdditionalInformation();

        if (!$info || $order->getPayment()->getMethod() !== ConfigProvider::CODE) {
            return $this;
        }
        // retrieve plan info to calc charge
        $ruleDetail = $this->serializer->unserialize($info['rule_detail']);
        $coefficient = $ruleDetail['coefficient'];

        $newTotal = $order->getBaseGrandTotal() * $coefficient;
        $charge = $newTotal - $order->getBaseGrandTotal();



        $order->setBaseSubTotal($newTotal);
        $order->setSubtotal($newTotal);
        $order->setBaseGrandTotal($newTotal);
        $order->setGrandTotal($newTotal);

        $invoice->setSubtotal($newTotal);
        $invoice->setBaseSubtotal($baseSubtotal);
        $invoice->setSubtotalInclTax($subtotalInclTax);
        $invoice->setBaseSubtotalInclTax($baseSubtotalInclTax);

        $invoice->setGrandTotal($newTotal);
        $invoice->setBaseGrandTotal($newTotal);

        // save charge info into additional info
        $info[RuleInterface::PLAN_CHARGES_FIELD] = $charge;
        $order->getPayment()->setAdditionalInformation($info);
        return $this;
    }
}
