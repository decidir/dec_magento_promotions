<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Ui\Component\Listing\Columns\Bank;

use Prisma\PaywayPromotions\Api\BankRepositoryInterface;

class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /** @var BankRepositoryInterface  */
    protected $bankRepository;

    /**
     * Options constructor.
     * @param BankRepositoryInterface $bankRepository
     */
    public function __construct(
        BankRepositoryInterface $bankRepository
    ) {
        $this->bankRepository = $bankRepository;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = [];
        $banks = $this->bankRepository->getList();
        foreach ($banks as $bank) {
            $options[$bank->getEntityId()] = [
                "label" => $bank->getBankName(),
                "value" => $bank->getEntityId()
            ];
        }

        return $options;
    }
}
