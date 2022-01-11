<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Model\Management;

use Prisma\Decidir\Gateway\Response\Cybersource\CybersourceHandler;
use Prisma\DecidirPromotions\Api\Data\TransactionInterface;
use Prisma\DecidirPromotions\Api\TransactionManagementInterface;
use Prisma\DecidirPromotions\Model\Transaction;
use Prisma\DecidirPromotions\Model\ResourceModel\Transaction\CollectionFactory;
use Prisma\DecidirPromotions\Model\Repositories\TransactionRepository;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Config\ScopeConfigInterface;

class TransactionLogManagement implements TransactionManagementInterface
{
    const XPATH_TRANSACTION_SAVE_ACTIVE = 'payment/decidir/transaction_save_log_active';

    /**
     * @var Transaction $transactionModel
     */
    private $transactionModel;

    /**
     * @var CollectionFactory $collectionFactory
     */
    private $collectionFactory;

    /**
     * @var TransactionRepository $transactionRepository
     */
    private $transactionRepository;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * @var DateTime $date
     */
    private $date;

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    private $scopeConfig;

    /**
     * TransactionLogManagement constructor.
     * @param Transaction $transactionModel
     * @param CollectionFactory $collectionFactory
     * @param TransactionRepository $transactionRepository
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     * @param DateTime $date
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Transaction $transactionModel,
        CollectionFactory $collectionFactory,
        TransactionRepository $transactionRepository,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        DateTime $date,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->transactionModel = $transactionModel;
        $this->collectionFactory = $collectionFactory;
        $this->transactionRepository = $transactionRepository;
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->date = $date;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $response
     * @throws \Exception
     */
    public function saveTransactionLog($response)
    {
        if (!$this->isActive()) {
            return;
        }
        $status = $response[TransactionInterface::TRANSACTION_STATUS];
        $csDecision =
            $response[CybersourceHandler::CS_FRAUD_DETECTION][CybersourceHandler::STATUS][CybersourceHandler::CS_DECISION]
            ?? 'Not informed by Decidir CS';
        $transactionId = (int) $response[TransactionInterface::RESPONSE_TRX_ID];
        $responsePayload = $this->serializer->serialize($response);
        $createdAt = $this->date->gmtDate();

        try {
            $transaction = $this->transactionModel
                ->setTransactionId($transactionId)
                ->setStatus($status)
                ->setCsDecision($csDecision)
                ->setResponsePayload($responsePayload)
                ->setCreatedAt($createdAt);

            $this->transactionRepository->save($transaction);

        } catch (LocalizedException $exception) {
            $this->logger->debug($exception->getMessage());
        }
    }

    /**
     * @inheridoc
     */
    public function getTransactions()
    {
        return $this->collectionFactory->create();
    }

    /**
     * @inheridoc
     */
    public function getTransactionById(int $transactionId)
    {
        if (is_null($transactionId)) {
            return TransactionInterface::NOT_TRX_FOUND_MESSAGE;
        }
        $transaction = $this->getTransactions()->addFilter(TransactionInterface::ENTITY_ID, $transactionId)->getFirstItem();
        return $transaction->getId()
            ? $transaction
            : TransactionInterface::NOT_TRX_FOUND_MESSAGE;
    }

    /**
     * @param $id
     * @return string
     */
    public function getTransactionResponsePayload($id)
    {
        $transactionData = $this->getTransactionById($id);
        if ($transactionData instanceof TransactionInterface) {
            $transactionData = $transactionData->getData();
            $transactionData = json_encode($this->serializer->unserialize($transactionData[TransactionInterface::RESPONSE_PAYLOAD]), JSON_PRETTY_PRINT);
        }
        return $transactionData;

    }

    /**
     * @param $id
     * @return int
     */
    public function getTransactionId($id)
    {
        return is_string($this->getTransactionById($id))
            ? $id
            : $this->getTransactionById($id)->getTransactionId();
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->scopeConfig->isSetFlag(
            self::XPATH_TRANSACTION_SAVE_ACTIVE
        );
    }
}
