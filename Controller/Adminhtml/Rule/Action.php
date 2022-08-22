<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Result\PageFactory;
use Prisma\PaywayPromotions\Api\RuleRepositoryInterface;

class Action extends \Magento\Backend\App\Action
{
    /** @var PageFactory  */
    protected $resultPageFactory;

    /** @var RuleRepositoryInterface  */
    protected $ruleRepository;

    /** @var TimezoneInterface  */
    protected $timezone;

    /**
     * Action constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param RuleRepositoryInterface $ruleRepository
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        RuleRepositoryInterface $ruleRepository,
        TimezoneInterface $timezone
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $pageFactory;
        $this->ruleRepository = $ruleRepository;
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
