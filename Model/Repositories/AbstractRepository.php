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
use Prisma\DecidirPromotions\Api\AbstractRepositoryInterface;

/**
 * Class BankRepository
 * @package Prisma\DecidirPromotions\Model\Repositories
 *
 * Implements all methods of the Repositories and represent the db interaction layer
 */
abstract class AbstractRepository implements AbstractRepositoryInterface
{
    /** Defined by child classes */
    protected $collectionFactory;

    /** @var CollectionProcessorInterface  */
    protected $collectionProcessor;

    /** Defined by child classes */
    protected $model;

    /** Defined by child classes */
    protected $resourceModel;

    /** @var SearchCriteriaBuilder  */
    protected $searchCriteriaBuilder;

    /** @var FilterGroup  */
    protected $filterGroup;

    /** @var Filter  */
    protected $filter;

    /**
     * @inheritDoc
     */
    public function getNewItem()
    {
        return  $this->collectionFactory->create()->getNewEmptyItem();
    }

    /**
     * @inheritDoc
     */
    public function addFilter($field, $value, $conditionType)
    {
        $filters = $this->filterGroup->getFilters();
        array_push($filters, $this->filter->setField($field)->setValue($value)->setConditionType($conditionType));
        $this->filterGroup->setFilters($filters);
    }

    /**
     * Generates a new Collection instance,
     * set all defined filters  and returns it
     *
     * @param Filter|null $filter
     * @return mixed, collection that depends of the current instance
     */
    private function getCollection(Filter $filter = null)
    {
        $collection = $this->collectionFactory->create();
        if (!empty($filter)) {
            $this->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
        }
        $this->searchCriteriaBuilder->addFilters($this->filterGroup->getFilters());
        $this->collectionProcessor->process($this->searchCriteriaBuilder->create(), $collection);

        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function getList(Filter $filter = null)
    {
        $collection = $this->getCollection($filter);
        return $collection->getItems();
    }

    /**
     * @inheritDoc
     */
    public function getFirst(Filter $filter = null)
    {
        $collection = $this->getCollection($filter);

        return $collection->getFirstItem();
    }

    /**
     * @inheritDoc
     */
    public function resetFilters()
    {
        $this->filterGroup->setFilters();
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $this->resourceModel->load($this->model, $id);
        return $this->model;
    }

    /**F
     * @inheritDoc
     */
    public function deleteById($id)
    {
        $model = $this->getById($id);
        $this->resourceModel->delete($model);
    }
}
