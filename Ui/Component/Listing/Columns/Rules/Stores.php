<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Ui\Component\Listing\Columns\Rules;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class Stores extends \Magento\Ui\Component\Listing\Columns\Column
{
    /** @var \Magento\Cms\Ui\Component\Listing\Column\Cms\Options  */
    protected $storesOptions;

    /**
     * Stores constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Cms\Ui\Component\Listing\Column\Cms\Options $storesOptions
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Cms\Ui\Component\Listing\Column\Cms\Options $storesOptions,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storesOptions = $storesOptions;
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $ids = explode(',', $item['applicable_stores']);
                $options = $this->storesOptions->toOptionArray();
                $stores = '';
                foreach ($ids as $id) {
                    if (!$id) {
                        $stores = 'All Websites';
                        break;
                    } else {
                        $stores .= $options[$id]['value'][0]['value'][0]['label']. " ";
                    }
                }
                $item['applicable_stores'] = $stores;
            }
        }

        return $dataSource;
    }
}
