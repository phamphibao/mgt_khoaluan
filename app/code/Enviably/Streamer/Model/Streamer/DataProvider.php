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
namespace Enviably\Streamer\Model\Streamer;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * Loaded data cache
     * 
     * @var array
     */
    protected $loadedData;

    /**
     * Data persistor
     * 
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     * 
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Enviably\Streamer\Model\Streamer $streamer */
        foreach ($items as $streamer) {
            $this->loadedData[$streamer->getId()] = $streamer->getData();

            if (isset($this->loadedData[$streamer->getId()]['avatar'])) {
                $avatar = [];
                $avatar[0]['name'] = $streamer->getAvatar();
                $avatar[0]['url'] = $streamer->getAvatarUrl();
                $this->loadedData[$streamer->getId()]['avatar'] = $avatar;
            }
        }
        $data = $this->dataPersistor->get('enviably_streamer_streamer');
        if (!empty($data)) {
            $streamer = $this->collection->getNewEmptyItem();
            $streamer->setData($data);
            $this->loadedData[$streamer->getId()] = $streamer->getData();
            $this->dataPersistor->clear('enviably_streamer_streamer');
        }
        return $this->loadedData;
    }
}
