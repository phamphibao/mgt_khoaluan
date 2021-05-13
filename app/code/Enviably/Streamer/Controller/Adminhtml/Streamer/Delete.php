<?php
/**
 * Enviably_Streamer extension
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category  Enviably
 * @package   Enviably_Streamer
 * @copyright Copyright (c) 2020
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 */
namespace Enviably\Streamer\Controller\Adminhtml\Streamer;

class Delete extends \Enviably\Streamer\Controller\Adminhtml\Streamer
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('streamer_id');
        if ($id) {
            try {
                $this->streamerRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The Streamer has been deleted.'));
                $resultRedirect->setPath('enviably_streamer/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The Streamer no longer exists.'));
                return $resultRedirect->setPath('enviably_streamer/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('enviably_streamer/streamer/edit', ['streamer_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the Streamer'));
                return $resultRedirect->setPath('enviably_streamer/streamer/edit', ['streamer_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a Streamer to delete.'));
        $resultRedirect->setPath('enviably_streamer/*/');
        return $resultRedirect;
    }
}
