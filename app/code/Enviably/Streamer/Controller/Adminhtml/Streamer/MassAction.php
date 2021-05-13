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

abstract class MassAction extends \Magento\Backend\App\Action
{
    /**
     * Streamer repository
     * 
     * @var \Enviably\Streamer\Api\StreamerRepositoryInterface
     */
    protected $streamerRepository;

    /**
     * Mass Action filter
     * 
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * Streamer collection factory
     * 
     * @var \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Action success message
     * 
     * @var string
     */
    protected $successMessage;

    /**
     * Action error message
     * 
     * @var string
     */
    protected $errorMessage;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory $collectionFactory
     * @param string $successMessage
     * @param string $errorMessage
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory $collectionFactory,
        $successMessage,
        $errorMessage
    ) {
        $this->streamerRepository = $streamerRepository;
        $this->filter             = $filter;
        $this->collectionFactory  = $collectionFactory;
        $this->successMessage     = $successMessage;
        $this->errorMessage       = $errorMessage;
        parent::__construct($context);
    }

    /**
     * @param \Enviably\Streamer\Api\Data\StreamerInterface $streamer
     * @return mixed
     */
    abstract protected function massAction(\Enviably\Streamer\Api\Data\StreamerInterface $streamer);

    /**
     * execute action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $streamer) {
                $this->massAction($streamer);
            }
            $this->messageManager->addSuccessMessage(__($this->successMessage, $collectionSize));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, $this->errorMessage);
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('enviably_streamer/*/index');
        return $redirectResult;
    }
}
