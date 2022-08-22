<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model\Repositories;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Prisma\PaywayPromotions\Api\Data\RuleInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\Rule as ResourceRule;
use Prisma\PaywayPromotions\Model\ResourceModel\Rule\CollectionFactory;
use Prisma\PaywayPromotions\Api\Data\RuleSearchResultsInterfaceFactory;

class RuleRepository extends AbstractRepository implements \Prisma\PaywayPromotions\Api\RuleRepositoryInterface
{
    /**
     * @var RuleSearchResultsInterfaceFactory $searchResultsFactory
     */
    protected $searchResultsFactory;

    /**
     * BankRepository constructor.
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param RuleInterface $model
     * @param ResourceRule $resourceModel
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterGroup $filterGroup
     * @param Filter $filter
     * @param RuleSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RuleInterface $model,
        ResourceRule $resourceModel,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroup $filterGroup,
        Filter $filter,
        RuleSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->model = $model;
        $this->resourceModel = $resourceModel;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroup = $filterGroup;
        $this->filter = $filter;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(RuleInterface $rule)
    {
        $this->resourceModel->save($rule);
    }

    /**
     * @inheritDoc
     */
    public function delete(RuleInterface $rule)
    {
        $this->resourceModel->delete($rule);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return RuleSearchResultsInterface
     */
    public function getRuleList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
