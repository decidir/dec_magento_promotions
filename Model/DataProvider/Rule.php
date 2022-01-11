<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Model\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Prisma\DecidirPromotions\Model\ResourceModel\Rule\CollectionFactory;
use Magento\Framework\Serialize\SerializerInterface;

class Rule extends AbstractDataProvider
{
    /**
     * @var SerializerInterface $serializer
     */
    protected $serializer;

    /**
     * Rule constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param SerializerInterface $serializer
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        SerializerInterface $serializer,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->serializer = $serializer;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Prepares the db data to be showed in the rule form
     * @return array
     */
    public function getData()
    {
        $data = parent::getData();
        $formattedData = array_pop($data);
        if ($formattedData) {
            $item = array_pop($formattedData);
            if (!empty($item['entity_id'])) {
                $fees = $this->serializer->unserialize($item['fee_plans']);
                $i = 0;
                foreach ($fees as $fee) {
                    $this->setFee($item, $fee, $i);
                    $i++;
                }
                $data[$item['entity_id']] = $item;
            }
        }
        return $data;
    }

    /**
     * Prepare the info of previously loaded fee plan
     *
     * @param $item
     * @param $fee
     * @param $i
     */
    public function setFee(&$item, $fee, $i)
    {
        $item['dynamic_rows'][$i] = [
                //"entity_id" => $fee['entity_id'],
                "fee_period" => $fee['fee_period'],
                "coefficient" => $fee['coefficient'],
                "tea" => $fee['tea'],
                "cft" => $fee['cft'],
                "fee_to_send" => $fee['fee_to_send']
        ];
    }
}
