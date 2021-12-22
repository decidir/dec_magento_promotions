<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Model\ResourceModel\CreditCard;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Prisma\DecidirPromotions\Model\CreditCard as Model;
use Prisma\DecidirPromotions\Model\ResourceModel\CreditCard as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'prisma_decidir_promotions_card_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
