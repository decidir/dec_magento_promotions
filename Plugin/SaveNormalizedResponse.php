<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types = 1);

namespace Prisma\DecidirPromotions\Plugin;

use Prisma\Decidir\Model\ResultProvider;
use Prisma\DecidirPromotions\Model\Management\TransactionLogManagement;

/**
 * Class SaveNormalizedResponse
 *
 * Save response into transaction logs table
 */
class SaveNormalizedResponse
{
    /**
     * @var TransactionLogManagement $transactionLogManagement
     */
    private $transactionLogManagement;

    /**
     * SaveNormalizedResponse constructor.
     * @param TransactionLogManagement $transactionLogManagement
     */
    public function __construct(TransactionLogManagement $transactionLogManagement)
    {
        $this->transactionLogManagement = $transactionLogManagement;
    }

    /**
     * @param ResultProvider $subject
     * @param $result
     * @return mixed
     */
    public function afterNormalizeResponse(ResultProvider $subject, $result)
    {
        $this->transactionLogManagement->saveTransactionLog($result);
        return $result;
    }
}
