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

class Edit extends \Enviably\Streamer\Controller\Adminhtml\Streamer
{
    /**
     * Initialize current Streamer and set it in the registry.
     *
     * @return int
     */
    protected function initStreamer()
    {
        $streamerId = $this->getRequest()->getParam('streamer_id');
        $this->coreRegistry->register(\Enviably\Streamer\Controller\RegistryConstants::CURRENT_STREAMER_ID, $streamerId);

        return $streamerId;
    }

    /**
     * Edit or create Streamer
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $streamerId = $this->initStreamer();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Enviably_Streamer::streamer_streamer');
        $resultPage->getConfig()->getTitle()->prepend(__('Streamers'));
        $resultPage->addBreadcrumb(__('Streamer'), __('Streamer'));
        $resultPage->addBreadcrumb(__('Streamers'), __('Streamers'), $this->getUrl('enviably_streamer/streamer'));

        if ($streamerId === null) {
            $resultPage->addBreadcrumb(__('New Streamer'), __('New Streamer'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Streamer'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Streamer'), __('Edit Streamer'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->streamerRepository->getById($streamerId)->getName()
            );
        }
        return $resultPage;
    }
}
