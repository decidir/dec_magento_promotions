<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Controller\Adminhtml\Transaction;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Prisma\DecidirPromotions\Api\Data\TransactionInterface;

class View extends Action
{

    /**
     * @var PageFactory $pageFactory
     */
    protected $pageFactory;

    /**
     * View constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page|string
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id') ?? null;
        if (is_null($id)) return TransactionInterface::NOT_TRX_FOUND_MESSAGE;
        $resultPage = $this->pageFactory->create();
        $resultPage->getLayout()->getBlock('prisma.decidirpromotions.transaction.view')->setData('id', $id);
        return $resultPage;
    }
}
