<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Model\Repositories;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Prisma\DecidirPromotions\Api\Data\CreditCardInterface;
use Prisma\DecidirPromotions\Api\CreditCardRepositoryInterface;
use Prisma\DecidirPromotions\Model\ResourceModel\CreditCard\CollectionFactory;

class CreditCardRepository extends AbstractRepository implements CreditCardRepositoryInterface
{
    /**
     * CreditCardRepository constructor.
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CreditCardInterface $model
     * @param \Prisma\DecidirPromotions\Model\ResourceModel\CreditCard $resourceModel
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterGroup $filterGroup
     * @param Filter $filter
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        CreditCardInterface $model,
        \Prisma\DecidirPromotions\Model\ResourceModel\CreditCard $resourceModel,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroup $filterGroup,
        Filter $filter
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->model = $model;
        $this->resourceModel = $resourceModel;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroup = $filterGroup;
        $this->filter = $filter;
    }
    public function save(CreditCardInterface $creditCard)
    {
        $this->resourceModel->save($creditCard);
    }

    public function delete(CreditCardInterface $creditCard)
    {
        $this->resourceModel->delete($creditCard);
    }
}
