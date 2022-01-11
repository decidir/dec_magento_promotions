<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Block\Adminhtml\Transaction;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Prisma\DecidirPromotions\Model\Management\TransactionLogManagement;

/**
 * Class View
 *
 */
class View extends Template
{
    /**
     * @var string
     */
    //public $_template = 'Prisma_DecidirPromotions::transaction/view.phtml';

    /**
     * @var TransactionLogManagement $transactionLogManagement
     */
    private $transactionLogManagement;

    /**
     * View constructor.
     * @param Context $context
     * @param TransactionLogManagement $transactionLogManagement
     * @param array $data
     */
    public function __construct(
        Context $context,
        TransactionLogManagement $transactionLogManagement,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->transactionLogManagement = $transactionLogManagement;
    }

    /**
     * @param $id
     * @return false|string
     */
    public function getTransactionResponsePayload($id)
    {
        return $this->transactionLogManagement->getTransactionResponsePayload($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function getTransactionId($id): int
    {
        return $this->transactionLogManagement->getTransactionId($id);
    }
}
