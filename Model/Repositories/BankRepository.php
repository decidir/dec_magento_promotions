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
use Prisma\PaywayPromotions\Api\BankRepositoryInterface;
use Prisma\PaywayPromotions\Api\Data\BankInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\Bank as ResourceBank;
use Prisma\PaywayPromotions\Model\ResourceModel\Bank\CollectionFactory;

/**
 * Class BankRepository
 *
 * You should @avoid to inject this class directly, please use the BankRepositoryInterface
 */
class BankRepository extends AbstractRepository implements BankRepositoryInterface
{
    /**
     * BankRepository constructor.
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param BankInterface $model
     * @param ResourceBank $resourceModel
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterGroup $filterGroup
     * @param Filter $filter
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        BankInterface $model,
        ResourceBank $resourceModel,
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

    /**
     * @inheritDoc
     */
    public function save(BankInterface $bank)
    {
        $this->resourceModel->save($bank);
    }
    /**
     * @inheritDoc
     */
    public function delete(BankInterface $bank)
    {
        $this->resourceModel->delete($bank);
    }
}
