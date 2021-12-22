<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Ui\Component\Listing\Columns\Card;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Prisma\DecidirPromotions\Api\CreditCardRepositoryInterface;

class Labels extends \Magento\Ui\Component\Listing\Columns\Column
{
    /** @var CreditCardRepositoryInterface  */
    protected $cardRepository;

    /**
     * Labels constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CreditCardRepositoryInterface $ccRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CreditCardRepositoryInterface $ccRepository,
        array $components = [],
        array $data = []
    ) {
        $this->cardRepository = $ccRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source to show card label
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $card = $this->cardRepository->getFirst(
                    $this->cardRepository->addFilter(
                        'entity_id',
                        $item['card_id'],
                        'eq'
                    )
                );
                if (!empty($card)) {
                    $item['card_id'] = $card->getCardName();
                }
            }
        }

        return $dataSource;
    }
}
