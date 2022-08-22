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
use Prisma\PaywayPromotions\Api\Data\TransactionInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\Transaction as ResourceTransaction;
use Prisma\PaywayPromotions\Model\ResourceModel\Transaction\CollectionFactory;
use Prisma\PaywayPromotions\Api\Data\TransactionSearchResultsInterfaceFactory;
use Prisma\PaywayPromotions\Api\TransactionRepositoryInterface;

class TransactionRepository extends AbstractRepository implements TransactionRepositoryInterface
{
    /**
     * @var TransactionSearchResultsInterfaceFactory $searchResultsFactory
     */
    protected $searchResultsFactory;

    /**
     * TransactionRepository constructor.
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param TransactionInterface $model
     * @param ResourceTransaction $resourceModel
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterGroup $filterGroup
     * @param Filter $filter
     * @param TransactionSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        TransactionInterface $model,
        ResourceTransaction $resourceModel,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroup $filterGroup,
        Filter $filter,
        TransactionSearchResultsInterfaceFactory $searchResultsFactory
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
    public function save(TransactionInterface $Transaction)
    {
        $this->resourceModel->save($Transaction);
    }

    /**
     * @inheritDoc
     */
    public function delete(TransactionInterface $transaction)
    {
        $this->resourceModel->delete($transaction);
    }
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TransactionSearchResultsInterface
     */
    public function getTransactionList(SearchCriteriaInterface $searchCriteria)
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
