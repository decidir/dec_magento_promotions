<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model\ResourceModel\Bank;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Prisma\PaywayPromotions\Model\Bank as Model;
use Prisma\PaywayPromotions\Model\ResourceModel\Bank as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'prisma_payway_promotions_bank_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
