<?php
 
namespace Customer\Support\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
 
class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
 
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
 
    public function execute()
    {
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('Customer_Support::support');
		$resultPage->getConfig()->getTitle()->prepend(__("Support Customer"));
		return $resultPage;
    }
}