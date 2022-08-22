<?php
/**
 * Copyright © IURCO and PRISMA. All rights reserved.
 */
declare(strict_types=1);

namespace Prisma\PaywayPromotions\Controller\Adminhtml\Card;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Prisma\PaywayPromotions\Api\CreditCardRepositoryInterface;
use Prisma\PaywayPromotions\Model\ImageUploader;

class Save extends Action
{
    /** @var ImageUploader  */
    protected $imageUploader;

    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param CreditCardRepositoryInterface $creditCardRepository
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CreditCardRepositoryInterface $creditCardRepository,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context, $pageFactory, $creditCardRepository);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Save the entity created in the database,
     * if any value is not provided, shows an error in the frontend and reloads de page
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultPage = false;
        $id = (int)$this->getRequest()->getParam('entity_id');
        if ($data) {
            try {
                $card = $this->ccRepository->getNewItem();
                if ($id) {
                    $card = $this->ccRepository->getById($id);
                    if ($id != $card->getEntityId()) {
                        throw new LocalizedException(__('Wrong entity was specified.'));
                    }
                } else {
                    unset($data['entity_id']);
                }
                $data = $this->prepareImageForSave($data);
                $card->setData($data);

                $this->_session->setPageData($card->getData());
                $this->ccRepository->save($card);

                $this->messageManager->addSuccessMessage(__('You saved the card.'));

                $this->_session->setPageData(false);

                if ($this->getRequest()->getParam('back')) {
                    $resultPage = $this->_redirect('promotions/card/edit', ['id' => $card->getEntityId()]);
                }
                $resultPage = $this->_redirect('promotions/card/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_session->setPageData($data);
            } catch (Exception $e) {
                //TODO:  Implement log
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_session->setPageData($data);
            }
            if (!empty($id) && empty($resultPage)) {
                $this->_redirect('promotions/card/edit', ['id' => $id]);
            } elseif (empty($resultPage)) {
                $this->_redirect('promotions/card/new');
            }
        } else {
            $resultPage = $this->_redirect('promotions/card/index');
        }

        return $resultPage;
    }

    /**
     * @param $data
     * @return mixed
     * @throws LocalizedException
     */
    protected function prepareImageForSave($data)
    {
        if (isset($data['logo_path'][0]['name']) && isset($data['logo_path'][0]['tmp_name'])) {
            $this->imageUploader->moveFileFromTmp($data['logo_path'][0]['name']);
            $this->setImagePath($data);
        } elseif (isset($data['logo_path'][0]['image']) && !isset($data['logo_path'][0]['tmp_name'])) {
            $this->setImagePath($data);
        } else {
            $data['logo_path'] = null;
        }

        return $data;
    }

    /**
     * @param $data
     */
    protected function setImagePath(&$data)
    {
        $data['logo_path'] = $this->imageUploader->getFilePath(
            $this->imageUploader->getBasePath(),
            $data['logo_path'][0]['name']
        );
    }
}
