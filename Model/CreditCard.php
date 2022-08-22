<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Prisma\PaywayPromotions\Api\Data\CreditCardInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\CreditCard as ResourceModel;

class CreditCard extends AbstractModel implements CreditCardInterface, IdentityInterface
{
    const CC_NAME_FIELD = 'card_name';
    const ID_SPS_FIELD = 'id_sps';
    const ID_NPS_FIELD = 'id_nps';
    const IS_ACTIVE_FIELD = 'is_active';
    const THUMBNAIL_LOGO_PATH = 'logo_path';
    const CACHE_TAG = 'prisma_payway_promotions_card';
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getCardName()
    {
        return $this->getData(self::CC_NAME_FIELD);
    }

    public function setCardName($name)
    {
        $this->setData(self::CC_NAME_FIELD, $name);
    }

    public function getIdSps()
    {
        return $this->getData(self::ID_SPS_FIELD);
    }

    public function setIdSps($id)
    {
        $this->setData(self::ID_SPS_FIELD, $id);
    }

    public function getIdNps()
    {
        return $this->getData(self::ID_NPS_FIELD);
    }

    public function setIdNps($id)
    {
        $this->setData(self::ID_NPS_FIELD, $id);
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
