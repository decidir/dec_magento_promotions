<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Cron;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Prisma\PaywayPromotions\Api\Data\TransactionInterface;
use Prisma\PaywayPromotions\Model\Repositories\TransactionRepository;
use Prisma\PaywayPromotions\Model\ResourceModel\Transaction\CollectionFactory;
use Prisma\PaywayPromotions\Model\Config\CronConfig;
use Psr\Log\LoggerInterface;

class CleanupTransactionLogTable
{
    /**
     * @var DateTime $date
     */
    private $date;

    /**
     * @var TransactionRepository $transactionRepository
     */
    private $transactionRepository;

    /**
     * @var CollectionFactory $collectionFactory
     */
    private $collectionFactory;

    /**
     * @var CronConfig $cronConfig
     */
    private $cronConfig;

    /**
     * @var  LoggerInterface $logger
     */
    private $logger;

    /**
     * CleanupTransactionLogTable constructor.
     * @param DateTime $date
     * @param TransactionRepository $transactionRepository
     * @param CollectionFactory $collectionFactory
     * @param CronConfig $cronConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        DateTime $date,
        TransactionRepository $transactionRepository,
        CollectionFactory $collectionFactory,
        CronConfig $cronConfig,
        LoggerInterface $logger
    ) {
        $this->date = $date;
        $this->transactionRepository = $transactionRepository;
        $this->collectionFactory = $collectionFactory;
        $this->cronConfig = $cronConfig;
        $this->logger = $logger;
    }

    /**
     * @return \Prisma\PaywayPromotions\Model\ResourceModel\Transaction\Collection
     */
    protected function getTransactionsOlder()
    {
        $currentDate = $this->date->gmtDate();
        $olderDays = $this->cronConfig->getTransactionOlderDays();
        $olderDate = $this->date->gmtDate(null, strtotime($currentDate . "-" . $olderDays . " days"));

        return $this->collectionFactory->create()
            ->addFieldToFilter(TransactionInterface::CREATED_AT, ['lteq' => $olderDate])
            ->setPageSize(CronConfig::PAGE_SIZE);
    }

    /**
     * @return $this
     */
    public function execute()
    {
        if (!$this->cronConfig->isActive()) {
            $this->logger->debug('Payway CleanUp Transaction log not active.');
            return $this;
        }
        $transactions = $this->getTransactionsOlder();
        $collectionSize = $transactions->getSize();

        if ($collectionSize < 1) {
            $this->logger->debug('No records to log.');
            return $this;
        }
        foreach ($transactions as $transaction) {
            try {
                $this->transactionRepository->delete($transaction);
            } catch (\Exception $exception) {
                $this->logger->debug($exception->getMessage());
            }

        }
        $this->logger->debug(sprintf('Deleted %s records.', $collectionSize));
        return $this;
    }
}
