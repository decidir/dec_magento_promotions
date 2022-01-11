<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Controller\Adminhtml\Card;

class Edit extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $card = $this->ccRepository->getNewItem();

        if ($id) {
            $card = $this->ccRepository->getById($id);
        }

        $data = $this->_session->getPageData(true);
        if (!empty($data)) {
            $card->addData($data);
        }
        $resultPage = parent::execute();

        $resultPage->getConfig()->getTitle()->prepend(__('Credit Card Form'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Card') : __('New Card'));
        $this->_view->renderLayout();
    }
}
