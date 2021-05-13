<?php

namespace Customer\Support\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Customer\Support\Model\ResourceModel\Support\CollectionFactory;
use Customer\Support\Model\SupportFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class MassDelete extends Action
{
    private $SupportFactory;
    private $filter;
    private $CollectionFactory;
    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        SupportFactory $SupportFactory,
        Filter $filter,
        CollectionFactory $CollectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->SupportFactory = $SupportFactory;
        $this->filter = $filter;
        $this->CollectionFactory = $CollectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->CollectionFactory->create());
        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deletePost = $this->SupportFactory->create()->load($item->getData('support_id'));
            try {
                $deletePost->delete();
                $total++;
            } catch (LocalizedException $exception) {
                $err++;
            }
        }

        if ($total) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $total)
            );
        }

        if ($err) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $err
                )
            );
        }
        return $this->resultRedirect->create()->setPath('support_customer/Index/index');
    }
}
