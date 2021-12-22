<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Api\Data;

use tests\verification\Tests\DataActionsTest;

/**
 * Class TransactionInterface
 * @api
 */
interface TransactionInterface
{
    const ENTITY_ID = "entity_id";
    const TRANSACTION_ID = "transaction_id";
    const RESPONSE_PAYLOAD = "response_payload";
    const TRANSACTION_STATUS = 'status';
    const TRANSACTION_CS_DECISION = 'cs_decision';
    const RESPONSE_TRX_ID = 'id';
    const CREATED_AT = 'created_at';
    const NOT_TRX_FOUND_MESSAGE = 'No TRX details found';
    /**
     * Get Transaction entity id
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Get Decidir Transaction ID
     * @return int
     */
    public function getTransactionId(): int;

    /**
     * Set Decidir Transaction Id
     * @param int $transactionId
     * @return mixed
     */
    public function setTransactionId(int $transactionId);

    /**
     * Get Decidir Transaction Status
     * @return string
     */
    public function getStatus(): string;

    /**
     * Set Decidir Transaction Status
     * @param string $status
     * @return mixed
     */
    public function setStatus(string $status);

    /**
     * Get Decidir Transaction CS Decision
     * @return string
     */
    public function getCsDecision(): string;

    /**
     * Get Decidir Transaction CS Decision
     * @param string $decision
     * @return mixed
     */
    public function setCsDecision(string $decision);

    /**
     * Get Decidir Transaction Response Payload
     * @return string
     */
    public function getResponsePayload(): string;

    /**
     * Set Decidir Transaction Response Payload
     * @param string $responsePayload
     * @return mixed
     */
    public function setResponsePayload(string $responsePayload);

    /**
     * Get record created at
     * @return
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     * @return mixed
     */
    public function setCreatedAt($createdAt);
}
