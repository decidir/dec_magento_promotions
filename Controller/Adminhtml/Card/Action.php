<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Controller\Adminhtml\Card;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Prisma\PaywayPromotions\Api\CreditCardRepositoryInterface;

class Action extends \Magento\Backend\App\Action
{
    /** @var PageFactory  */
    protected $resultPageFactory;
    /** @var CreditCardRepositoryInterface  */
    protected $ccRepository;

    /**
     * Action constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param CreditCardRepositoryInterface $creditCardRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CreditCardRepositoryInterface $creditCardRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $pageFactory;
        $this->ccRepository = $creditCardRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
