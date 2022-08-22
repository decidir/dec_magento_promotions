<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Prisma\PaywayPromotions\Api\Data\BankInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\Bank as ResourceModel;

class Bank extends AbstractModel implements BankInterface, IdentityInterface
{
    const BANK_NAME_FIELD = 'bank_name';
    const IS_ACTIVE_FIELD = 'is_active';
    const THUMBNAIL_LOGO_PATH = 'logo_path';
    const CACHE_TAG = 'prisma_payway_promotions_bank';
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getBankName()
    {
        return $this->getData(self::BANK_NAME_FIELD);
    }

    public function setBankName($name)
    {
        $this->setData(self::BANK_NAME_FIELD, $name);
    }

    public function getThumbnail()
    {
        return $this->getData(self::THUMBNAIL_LOGO_PATH);
    }

    public function setThumbnail($path)
    {
        $this->setData(self::THUMBNAIL_LOGO_PATH, $path);
    }

    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE_FIELD);
    }

    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE_FIELD, $isActive);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }
}
