<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Api;

use Magento\Framework\Api\Filter;

/**
 * Interface AbstractRepositoryInterface
 *
 * @api
 * Provides common methods for all repositories in this package
 *
 * Futures repositories will implement this interface and his own specific interface
 */
interface AbstractRepositoryInterface
{
    /**
     * Returns a new clean model
     *
     * @return mixed
     */
    public function getNewItem();

    /**
     * Add a Filter that will be processed by the getList method
     *
     * @param $field
     * @param $value
     * @param $conditionType
     * @return mixed
     */
    public function addFilter($field, $value, $conditionType);
    /**
     * Returns an array of models data
     * If Filter is given, applies them to the Results,
     *
     * Returns All items if Filter is not provided
     * If you want to set more than one filter you need to use addFilter method
     */
    public function getList(Filter $filter = null);
    /**
     * Returns First model
     */
    public function getFirst(Filter $filter = null);
    /**
     * Delete all filters for current repository
     *
     * @return void
     */
    public function resetFilters();
    /**
     * Returns a model by entity_id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Deletes a model by entity_id
     *
     * @param $id
     * @return mixed
     */
    public function deleteById($id);
}
