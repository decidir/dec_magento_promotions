<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Ui\Component\Listing\Columns\Bank;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Prisma\PaywayPromotions\Api\BankRepositoryInterface;

class Labels extends \Magento\Ui\Component\Listing\Columns\Column
{
    /** @var BankRepositoryInterface  */
    protected $bankRepository;

    /**
     * Labels constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param BankRepositoryInterface $bankRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        BankRepositoryInterface $bankRepository,
        array $components = [],
        array $data = []
    ) {
        $this->bankRepository = $bankRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source to show bank label
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $bank = $this->bankRepository->getFirst(
                    $this->bankRepository->addFilter(
                        'entity_id',
                        $item['bank_id'],
                        'eq'
                    )
                );
                if (!empty($bank)) {
                    $item['bank_id'] = $bank->getBankName();
                }
            }
        }

        return $dataSource;
    }
}
