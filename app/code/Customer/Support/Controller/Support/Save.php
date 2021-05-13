<?php
namespace Customer\Support\Controller\Support;

class Save extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_supportFactory;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Customer\Support\Model\SupportFactory $supportFactory
		)
	{
		
		$this->_supportFactory = $supportFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
			$data = $this->getRequest()->getPostValue();
			$support = $this->_supportFactory->create();
			$support->addData([
				'name' => $data['name_customer'],
				'phone' => $data['phone_customer'],
				'email' => $data['email_customer'],
				'address' =>$data['address_customer'],
				'description' =>$data['description'],
			])->save();

				// for ($i=0; $i < 100 ; $i++) { 
				// 	$support = $this->_supportFactory->create();
				// 	$support->addData([
				// 		'name' => 'user'.$i,
				// 		'phone' => '+84-222-'.$i.'444',
				// 		'email' => 'email'.$i.'@gmail.com',
				// 		'address' =>'Hue',
				// 		'description' =>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
				// 	])->save();
				// }

			$this->messageManager->addSuccess(__('Support has been sent'));
			
			$resultRedirect = $this->resultRedirectFactory->create();
			$resultRedirect->setRefererUrl();
			return $resultRedirect;
		
        
	}
}