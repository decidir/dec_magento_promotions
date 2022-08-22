<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Controller\Adminhtml\Bank;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Prisma\PaywayPromotions\Api\BankRepositoryInterface;

class Action extends \Magento\Backend\App\Action
{
    /** @var PageFactory  */
    protected $resultPageFactory;
    /** @var BankRepositoryInterface  */
    protected $bankRepository;

    /**
     * Action constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param BankRepositoryInterface $bankRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        BankRepositoryInterface $bankRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $pageFactory;
        $this->bankRepository = $bankRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
