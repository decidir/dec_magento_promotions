<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Prisma\PaywayPromotions\Api\Data\TransactionInterface;
use Prisma\PaywayPromotions\Model\ResourceModel\Transaction as ResourceModel;

class Transaction extends AbstractModel implements TransactionInterface, IdentityInterface
{
    const CACHE_TAG = 'prisma_payway_promotions_transaction';

    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = self::CACHE_TAG;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    /**
     * @inheritdoc
     */
    public function getEntityId(): int
    {
        return $this->getData(TransactionInterface::ENTITY_ID);
    }

    /**
     * @inheritdoc
     */
    public function getTransactionId(): int
    {
        return (int) $this->getData(TransactionInterface::TRANSACTION_ID);
    }

    /**
     * @inheritdoc
     */
    public function setTransactionId(int $transactionId)
    {
        return $this->setData(TransactionInterface::TRANSACTION_ID, $transactionId);
    }

    /**
     * @inheritdoc
     */
    public function getStatus() :string
    {
        return $this->getData(TransactionInterface::TRANSACTION_STATUS);
    }

    /**
     * @inheritdoc
     */
    public function setStatus(string $status)
    {
        return $this->setData(TransactionInterface::TRANSACTION_STATUS, $status);
    }

    /**
     * @inheritdoc
     */
    public function getCsDecision(): string
    {
        return $this->getData(TransactionInterface::TRANSACTION_CS_DECISION);
    }

    /**
     * @inheritdoc
     */
    public function setCsDecision(string $decision)
    {
        return $this->setData(TransactionInterface::TRANSACTION_CS_DECISION, $decision);
    }

    /**
     * @inheritdoc
     */
    public function getResponsePayload(): string
    {
        return $this->getData(TransactionInterface::RESPONSE_PAYLOAD);
    }

    /**
     * @inheritdoc
     */
    public function setResponsePayload(string $responsePayload)
    {
        return $this->setData(TransactionInterface::RESPONSE_PAYLOAD, $responsePayload);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(TransactionInterface::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(TransactionInterface::CREATED_AT, $createdAt);
    }
}
