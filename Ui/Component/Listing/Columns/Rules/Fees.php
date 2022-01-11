<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Ui\Component\Listing\Columns\Rules;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\Serialize\SerializerInterface;

class Fees extends \Magento\Ui\Component\Listing\Columns\Column
{

    /**
     * @var SerializerInterface $serializer
     */
    protected $serializer;

    /**
     * Fees constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SerializerInterface $serializer
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SerializerInterface $serializer,
        array $components = [],
        array $data = []
    ) {
        $this->serializer = $serializer;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $fees = $this->serializer->unserialize($item['fee_plans']);
                $feePeriod = [];
                foreach ($fees as $fee) {
                    $feePeriod[] = $fee['fee_period'];
                }
                $item['fee_plans'] = implode(',', $feePeriod);
            }
        }
        return $dataSource;
    }
}
