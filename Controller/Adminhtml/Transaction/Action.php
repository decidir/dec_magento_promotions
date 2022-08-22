<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Controller\Adminhtml\Transaction;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Result\PageFactory;
use Prisma\PaywayPromotions\Api\TransactionRepositoryInterface;

class Action extends \Magento\Backend\App\Action
{
    /** @var PageFactory  */
    protected $resultPageFactory;

    /** @var TransactionRepositoryInterface  */
    protected $TransactionRepository;

    /** @var TimezoneInterface  */
    protected $timezone;

    /**
     * Action constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param TransactionRepositoryInterface $TransactionRepository
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        TransactionRepositoryInterface $TransactionRepository,
        TimezoneInterface $timezone
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $pageFactory;
        $this->TransactionRepository = $TransactionRepository;
        $this->timezone = $timezone;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
