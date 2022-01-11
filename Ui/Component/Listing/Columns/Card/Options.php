<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Ui\Component\Listing\Columns\Card;

use Prisma\DecidirPromotions\Api\CreditCardRepositoryInterface;

class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /** @var CreditCardRepositoryInterface  */
    protected $cardRepository;

    /**
     * Options constructor.
     * @param CreditCardRepositoryInterface $ccRepository
     */
    public function __construct(
        CreditCardRepositoryInterface $ccRepository
    ) {
        $this->cardRepository = $ccRepository;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = [];
        $cards = $this->cardRepository->getList();
        foreach ($cards as $card) {
            $options[$card->getEntityId()] = [
                "label" => $card->getCardName(),
                "value" => $card->getEntityId()
            ];
        }

        return $options;
    }
}
