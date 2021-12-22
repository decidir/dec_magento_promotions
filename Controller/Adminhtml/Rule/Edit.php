<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\DecidirPromotions\Controller\Adminhtml\Rule;

class Edit extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $rule = $this->ruleRepository->getNewItem();

        if ($id) {
            $rule = $this->ruleRepository->getById($id);
        }

        $data = $this->_session->getPageData(true);
        if (!empty($data)) {
            $rule->addData($data);
        }
        $resultPage = parent::execute();

        $resultPage->getConfig()->getTitle()->prepend(__('Promotion Rule Form'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Rule') : __('New Rule'));
        $this->_view->renderLayout();
    }
}
