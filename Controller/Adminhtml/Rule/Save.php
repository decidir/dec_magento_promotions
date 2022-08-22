<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Result\PageFactory;
use Prisma\PaywayPromotions\Api\Data\RuleInterface;
use Prisma\PaywayPromotions\Api\RuleRepositoryInterface;
use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\Rule\CollectionFactory;

class Save extends Action
{
    /** @var PageFactory  */
    protected $resultPageFactory;

    /** @var RuleRepositoryInterface  */
    protected $ruleRepository;

    /** @var TimezoneInterface  */
    protected $timezone;

    /**
     * @var SerializerInterface $serializer
     */
    protected $serializer;

    /**
     * @var CollectionFactory $collectionFactory
     */
    protected $collectionFactory;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param RuleRepositoryInterface $ruleRepository
     * @param TimezoneInterface $timezone
     * @param SerializerInterface $serializer
     * @param CollectionFactory $collectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        RuleRepositoryInterface $ruleRepository,
        TimezoneInterface $timezone,
        SerializerInterface $serializer,
        CollectionFactory $collectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->serializer = $serializer;
        $this->collectionFactory = $collectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $pageFactory, $ruleRepository, $timezone);
    }

    /**
     * Save the entity created in the database,
     * if any value is not provided, shows an error in the frontend and reloads de page
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultPage = false;
        $id = (int)$this->getRequest()->getParam('entity_id');
        if ($data) {
            try {
                if ($this->hasDynamicRows($data)) {
                    $rule = $this->ruleRepository->getNewItem();
                    if ($id) {
                        $rule = $this->ruleRepository->getById($id);
                        if ($id != $rule->getEntityId()) {
                            throw new LocalizedException(__('Wrong entity was specified.'));
                        }
                    } else {
                        unset($data['entity_id']);
                    }

                    // validate if rule for card/bank selected
                    // already exists before save

                    $criteria = $this->searchCriteriaBuilder
                        ->addFilter(RuleInterface::CARDS_FIELD, $data[RuleInterface::CARDS_FIELD])
                        ->addFilter(RuleInterface::BANKS_FIELD, $data[RuleInterface::BANKS_FIELD])
                        ->create();
                    $ruleItems = $this->ruleRepository->getRuleList($criteria);

                     if ($ruleItems->getTotalCount()) {
                         foreach ($ruleItems->getItems() as $item) {
                             if ((int) $item->getEntityId()
                                && (int) $item->getEntityId() !== $id) {
                                throw new LocalizedException(__('Rule for bank/card already exists.'));
                            }
                         }
                     }

                    $rule->setData($this->getFormattedData($data));
                    $this->_session->setPageData($rule->getData());
                    $this->ruleRepository->save($rule);

                    $this->messageManager->addSuccessMessage(__('You saved the Rule.'));

                    $this->_session->setPageData(false);

                    if ($this->getRequest()->getParam('back')) {
                        $resultPage = $this->_redirect('promotions/rule/edit', ['id' => $rule->getEntityId()]);
                    }
                    $resultPage = $this->_redirect('promotions/rule/index');
                } else {
                    $this->messageManager->addErrorMessage(__("The Rule needs at least 1 Fee Plan"));
                    $this->_redirect('promotions/rule/edit', ['id' => !empty($id)? $id : null]);
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_session->setPageData($data);
            } catch (Exception $e) {
                //TODO:  Implement log
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_session->setPageData($data);
            }
            if (!empty($id) && empty($resultPage)) {
                $this->_redirect('promotions/rule/edit', ['id' => $id]);
            } elseif (empty($resultPage)) {
                $this->_redirect('promotions/rule/new');
            }
        } else {
            $resultPage = $this->_redirect('promotions/rule/index');
        }

        return $resultPage;
    }

    /**
     * @param $data
     * @return bool true if the rule has dynamic rows
     */
    public function hasDynamicRows($data)
    {
        $hasDynamicRows = false;
        if (!empty($data['dynamic_rows'])) {
            $hasDynamicRows = true;
        }

        return $hasDynamicRows;
    }

    /**
     * Format data to save in the db
     *
     * @param $data
     * @return mixed
     */
    protected function getFormattedData($data)
    {
        $data['applicable_days'] = $this->getArrayAsString($data, 'applicable_days');
        $data['applicable_stores'] = $this->getArrayAsString($data, 'applicable_stores');
        $data['fee_plans'] = $this->serializer->serialize($data['dynamic_rows']);
        $data['from_date'] = $this->timezone->date($data['from_date'])
            ->format(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT);
        $data['to_date'] = $this->timezone->date($data['to_date'])
            ->format(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT);

        return $data;
    }

    /**
     * Convert an array to a string split by ','
     *
     * @param $data
     * @param $code
     * @return string
     */
    protected function getArrayAsString($data, $code)
    {
        return implode(',', $data[$code]);
    }
}
