<?php
namespace Customer\Support\Block;


class Index extends \Magento\Framework\View\Element\Template
{
    protected $collectionFactory;
    public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Customer\Support\Model\ResourceModel\Support\CollectionFactory $collectionFactory
		
		)
	{
		$this->collectionFactory = $collectionFactory;
		return parent::__construct($context);
	}

    public function getSupportCollection()
    {
        return $this->collectionFactory->create();
    }
}