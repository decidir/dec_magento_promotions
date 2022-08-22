<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Controller\Adminhtml\Card;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /**
     * Get a Collection with selected records and delete them
     *
     * @return ResponseInterface|ResultInterface|Page
     * @throws Exception if not ids to delete given
     */
    public function execute()
    {
        $recordDeleted = 0;
        $selected = $this->getRequest()->getParam(Filter::SELECTED_PARAM);
        if (!empty($selected)) {
            foreach ($selected as $id) {
                $this->ccRepository->deleteById($id);
                $recordDeleted++;
            }
        } else {
            foreach ($this->ccRepository->getList() as $card) {
                $this->ccRepository->delete($card);
                $recordDeleted++;
            }
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $recordDeleted));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
