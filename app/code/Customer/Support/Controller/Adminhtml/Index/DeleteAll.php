<?php

namespace Customer\Support\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Customer\Support\Model\ResourceModel\Support\CollectionFactory as SupportCollectionFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class DeleteAll extends Action
{
    /**
     * @var SupportCollectionFactory
     */
    private $supportCollectionFactory;

    /**
     * @var RedirectFactory
     */
    private $resultRedirect;

    /**
     * DeleteAll construct
     * @param  Action\Context $context
     * @param  SupportCollectionFactory $collectionFactory
     * @param  RedirectFactory $redirectFactory
     * 
     */
    public function __construct(
        Action\Context $context,
        SupportCollectionFactory $supportCollectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->supportCollectionFactory = $supportCollectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->supportCollectionFactory->create();
        foreach ($data as $value) {
            $value->delete();
        }

        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('/admin/support_customer/Index/index/');
    
        return $redirect;
    }
}
