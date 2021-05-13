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

class Index extends \Enviably\Streamer\Controller\Adminhtml\Streamer
{
    /**
     * Streamers list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Enviably_Streamer::streamer');
        $resultPage->getConfig()->getTitle()->prepend(__('Streamers'));
        $resultPage->addBreadcrumb(__('Streamer'), __('Streamer'));
        $resultPage->addBreadcrumb(__('Streamers'), __('Streamers'));
        return $resultPage;
    }
}
