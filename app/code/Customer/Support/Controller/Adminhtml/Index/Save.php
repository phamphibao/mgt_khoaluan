<?php
 
namespace Customer\Support\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action;
use Customer\Support\Model\SupportFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
 
class Save extends Action
{
    private $resultRedirect;
    private $supportFactory;
 
    public function __construct(
        Action\Context $context,
        supportFactory $supportFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->supportFactory = $supportFactory;
        $this->resultRedirect = $redirectFactory;
    }
 
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['support_id']) ? $data['support_id'] : null;
 
      
        $newData = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'],
            'description' => $data['description'],
            'status' => $data['status'],
        ];
 
        $post = $this->supportFactory->create();
        if ($id) {
            $post->load($id);
            $this->getMessageManager()->addSuccessMessage(__('Successful editing'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save successfully.'));
        }
        try{
            $post->addData($newData);
            $post->save();
            return $this->resultRedirect->create()->setPath('support_customer/Index/');
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save failed.'));
        }
    }
}