<?php
namespace Customer\Support\Model\ResourceModel\Support;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'support_id';
	protected $_eventPrefix = 'customer_support_support_collection';
	protected $_eventObject = 'support_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Customer\Support\Model\Support', 'Customer\Support\Model\ResourceModel\Support');
	}

}

