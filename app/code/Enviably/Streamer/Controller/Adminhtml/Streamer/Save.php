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

class Save extends \Enviably\Streamer\Controller\Adminhtml\Streamer
{
    /**
     * Streamer factory
     * 
     * @var \Enviably\Streamer\Api\Data\StreamerInterfaceFactory
     */
    protected $streamerFactory;

    /**
     * Data Object Processor
     * 
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data Object Helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Uploader pool
     * 
     * @var \Enviably\Streamer\Model\UploaderPool
     */
    protected $uploaderPool;

    /**
     * Data Persistor
     * 
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Enviably\Streamer\Api\Data\StreamerInterfaceFactory $streamerFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Enviably\Streamer\Model\UploaderPool $uploaderPool
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Enviably\Streamer\Api\Data\StreamerInterfaceFactory $streamerFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Enviably\Streamer\Model\UploaderPool $uploaderPool,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->streamerFactory     = $streamerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper    = $dataObjectHelper;
        $this->uploaderPool        = $uploaderPool;
        $this->dataPersistor       = $dataPersistor;
        parent::__construct($context, $coreRegistry, $streamerRepository, $resultPageFactory);
    }

    /**
     * run the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Enviably\Streamer\Api\Data\StreamerInterface $streamer */
        $streamer = null;
        $postData = $this->getRequest()->getPostValue();
        $data = $postData;
        $id = !empty($data['streamer_id']) ? $data['streamer_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $streamer = $this->streamerRepository->getById((int)$id);
            } else {
                unset($data['streamer_id']);
                $streamer = $this->streamerFactory->create();
            }
            $avatar = $this->getUploader('image')->uploadFileAndGetName('avatar', $data);
            $data['avatar'] = $avatar;
            $this->dataObjectHelper->populateWithArray($streamer, $data, \Enviably\Streamer\Api\Data\StreamerInterface::class);
            $this->streamerRepository->save($streamer);
            $this->messageManager->addSuccessMessage(__('You saved the Streamer'));
            $this->dataPersistor->clear('enviably_streamer_streamer');
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('enviably_streamer/streamer/edit', ['streamer_id' => $streamer->getId()]);
            } else {
                $resultRedirect->setPath('enviably_streamer/streamer');
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('enviably_streamer_streamer', $postData);
            $resultRedirect->setPath('enviably_streamer/streamer/edit', ['streamer_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the Streamer'));
            $this->dataPersistor->set('enviably_streamer_streamer', $postData);
            $resultRedirect->setPath('enviably_streamer/streamer/edit', ['streamer_id' => $id]);
        }
        return $resultRedirect;
    }

    /**
     * @param string $type
     * @return \Enviably\Streamer\Model\Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}
