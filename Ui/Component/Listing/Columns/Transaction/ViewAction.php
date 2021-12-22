<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Ui\Component\Listing\Columns\Transaction;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Action
 *
 * Generic Class for action button in ui component grid
 * the edit url attribute is set by virtualType
 */
class ViewAction extends Column
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
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name]['view'] = [
                        'href' => $this->urlBuilder->getUrl(
                            $this->viewUrl,
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('View'),
                    ];
                }
            }
        }

        return $dataSource;
    }
}
