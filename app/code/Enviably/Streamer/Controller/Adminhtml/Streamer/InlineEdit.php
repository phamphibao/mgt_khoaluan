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

class InlineEdit extends \Enviably\Streamer\Controller\Adminhtml\Streamer
{
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Streamer repository
     * 
     * @var \Enviably\Streamer\Api\StreamerRepositoryInterface
     */
    protected $streamerRepository;

    /**
     * Page factory
     * 
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Data object processor
     * 
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data object helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * JSON Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * Streamer resource model
     * 
     * @var \Enviably\Streamer\Model\ResourceModel\Streamer
     */
    protected $streamerResourceModel;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Enviably\Streamer\Model\ResourceModel\Streamer $streamerResourceModel
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Enviably\Streamer\Model\ResourceModel\Streamer $streamerResourceModel
    ) {
        $this->dataObjectProcessor   = $dataObjectProcessor;
        $this->dataObjectHelper      = $dataObjectHelper;
        $this->jsonFactory           = $jsonFactory;
        $this->streamerResourceModel = $streamerResourceModel;
        parent::__construct($context, $coreRegistry, $streamerRepository, $resultPageFactory);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $streamerId) {
            /** @var \Enviably\Streamer\Model\Streamer|\Enviably\Streamer\Api\Data\StreamerInterface $streamer */
            $streamer = $this->streamerRepository->getById((int)$streamerId);
            try {
                $streamerData = $postItems[$streamerId];
                $this->dataObjectHelper->populateWithArray($streamer, $streamerData, \Enviably\Streamer\Api\Data\StreamerInterface::class);
                $this->streamerResourceModel->saveAttribute($streamer, array_keys($streamerData));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithStreamerId($streamer, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithStreamerId($streamer, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithStreamerId(
                    $streamer,
                    __('Something went wrong while saving the Streamer.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Streamer id to error message
     *
     * @param \Enviably\Streamer\Api\Data\StreamerInterface $streamer
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithStreamerId(\Enviably\Streamer\Api\Data\StreamerInterface $streamer, $errorText)
    {
        return '[Streamer ID: ' . $streamer->getId() . '] ' . $errorText;
    }
}
