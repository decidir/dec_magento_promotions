<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Ui\Component\Listing\Columns\Transaction;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Prisma\Payway\Api\Data\Validator\Cybersource\CybersourceValidatorInterface;
use Prisma\PaywayPromotions\Api\Data\TransactionInterface;

/**
 * Class Action
 *
 * Generic Class for action button in ui component grid
 * the edit url attribute is set by virtualType
 */
class CsDecision extends Column
{
    /** @var UrlInterface  */
    protected $urlBuilder;

    /** @var string  */
    protected $viewUrl;

    /**
     * Action constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $viewUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        string $viewUrl = ''
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->viewUrl = $viewUrl;
    }

    /**
     * Prepare the edit action button using the EDIT_URL path defined by the child classes
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[TransactionInterface::TRANSACTION_CS_DECISION] .=
                    " ".
                    $this->getDecisionColor( $item[TransactionInterface::TRANSACTION_CS_DECISION]);
            }
        }

        return $dataSource;
    }

    /**
     * @param $decision
     * @return string
     */
    protected function getDecisionColor($decision)
    {
        $decisionArray = $this->getCsDecisionArray();
        if (in_array($decision, $decisionArray)) {
            return '<svg width="20" height="20">
                        <rect width="20" height="20" style="fill:'. $decision .';stroke-width:0;" />
                    </svg>'
                    ;
        }
    }

    /**
     * @return array
     */
    protected function getCsDecisionArray()
    {
          return [
              CybersourceValidatorInterface::DECISION_BLACK,
              CybersourceValidatorInterface::DECISION_BLUE,
              CybersourceValidatorInterface::DECISION_YELLOW,
              CybersourceValidatorInterface::DECISION_RED,
              CybersourceValidatorInterface::DECISION_GREEN
        ];

    }
}
