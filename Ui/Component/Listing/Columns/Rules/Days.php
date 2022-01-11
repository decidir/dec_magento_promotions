<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Ui\Component\Listing\Columns\Rules;

use Magento\Config\Model\Config\Source\Locale\Weekdays;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class Days extends \Magento\Ui\Component\Listing\Columns\Column
{
    /** @var Weekdays  */
    protected $weekDays;

    /**
     * Days constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Weekdays $weekDays
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Weekdays $weekDays,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->weekDays = $weekDays;
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $ids = explode(',', $item['applicable_days']);
                $labelDays = $this->weekDays->toOptionArray();
                $days = '';
                foreach ($ids as $id) {
                    $days .= __($labelDays[$id]['label'])." ";
                }
                $item['applicable_days'] = $days;
            }
        }

        return $dataSource;
    }
}
