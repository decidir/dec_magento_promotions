<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Model\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Prisma\DecidirPromotions\Model\ResourceModel\CreditCard\CollectionFactory;

class Card extends AbstractDataProvider
{
    /**
     * Card constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Prepares the db data to be showed in the card form
     * @return array
     */
    public function getData()
    {
        $data = parent::getData();
        $formattedData = array_pop($data);
        if ($formattedData) {
            $item = array_pop($formattedData);
            if (!empty($item['entity_id'])) {
                unset($item['logo_path']);
                $data[$item['entity_id']] = $item;
            }
        }

        return $data;
    }
}
