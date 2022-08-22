<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Model\Config\Source;

class TransactionOlderDays
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => '', 'label' => __('-- Please Select --')],
            ['value' => 10, 'label' => __('10 days')],
            ['value' => 30, 'label' => __('30 days')],
            ['value' => 60, 'label' => __('60 days')]
        ];
    }
}
