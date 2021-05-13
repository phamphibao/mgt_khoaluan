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
namespace Enviably\Streamer\Model;

/**
 * @method \Enviably\Streamer\Model\ResourceModel\Streamer _getResource()
 * @method \Enviably\Streamer\Model\ResourceModel\Streamer getResource()
 */
class Streamer extends \Magento\Framework\Model\AbstractModel implements \Enviably\Streamer\Api\Data\StreamerInterface
{
    /**
     * Cache tag
     * 
     * @var string
     */
    const CACHE_TAG = 'enviably_streamer_streamer';

    /**
     * Cache tag
     * 
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'enviably_streamer_streamer';

    /**
     * Event object
     * 
     * @var string
     */
    protected $_eventObject = 'streamer';

    /**
     * Uploader pool
     * 
     * @var \Enviably\Streamer\Model\UploaderPool
     */
    protected $uploaderPool;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Enviably\Streamer\Model\UploaderPool $uploaderPool
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Enviably\Streamer\Model\UploaderPool $uploaderPool,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->uploaderPool = $uploaderPool;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Enviably\Streamer\Model\ResourceModel\Streamer::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Streamer id
     *
     * @return array
     */
    public function getStreamerId()
    {
        return $this->getData(\Enviably\Streamer\Api\Data\StreamerInterface::STREAMER_ID);
    }

    /**
     * set Streamer id
     *
     * @param int $streamerId
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     */
    public function setStreamerId($streamerId)
    {
        return $this->setData(\Enviably\Streamer\Api\Data\StreamerInterface::STREAMER_ID, $streamerId);
    }

    /**
     * set Name
     *
     * @param mixed $name
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     */
    public function setName($name)
    {
        return $this->setData(\Enviably\Streamer\Api\Data\StreamerInterface::NAME, $name);
    }

    /**
     * get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(\Enviably\Streamer\Api\Data\StreamerInterface::NAME);
    }

    /**
     * set Avatar
     *
     * @param mixed $avatar
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     */
    public function setAvatar($avatar)
    {
        return $this->setData(\Enviably\Streamer\Api\Data\StreamerInterface::AVATAR, $avatar);
    }

    /**
     * get Avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->getData(\Enviably\Streamer\Api\Data\StreamerInterface::AVATAR);
    }

    /**
     * set Status
     *
     * @param mixed $status
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     */
    public function setStatus($status)
    {
        return $this->setData(\Enviably\Streamer\Api\Data\StreamerInterface::STATUS, $status);
    }

    /**
     * get Status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(\Enviably\Streamer\Api\Data\StreamerInterface::STATUS);
    }

    /**
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAvatarUrl()
    {
        $url = false;
        $avatar = $this->getAvatar();
        if ($avatar) {
            if (is_string($avatar)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$avatar;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the Avatar url.')
                );
            }
        }
        return $url;
    }
}
