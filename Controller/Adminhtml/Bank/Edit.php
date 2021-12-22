<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Controller\Adminhtml\Bank;

class Edit extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $bank = $this->bankRepository->getNewItem();

        if ($id) {
            $bank = $this->bankRepository->getById($id);
        }

        $data = $this->_session->getPageData(true);
        if (!empty($data)) {
            $bank->addData($data);
        }
        $resultPage = parent::execute();

        $resultPage->getConfig()->getTitle()->prepend(__('Bank Form'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Bank') : __('New Bank'));
        $this->_view->renderLayout();
    }
}
