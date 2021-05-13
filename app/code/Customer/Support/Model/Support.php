<?php
namespace Customer\Support\Model;
class Support extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'customer_support_customer';

	protected $_cacheTag = 'customer_support_customer';

	protected $_eventPrefix = 'customer_support_customer';

	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;

	protected function _construct()
	{
		$this->_init('Customer\Support\Model\ResourceModel\Support');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}