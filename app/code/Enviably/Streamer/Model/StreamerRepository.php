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

class StreamerRepository implements \Enviably\Streamer\Api\StreamerRepositoryInterface
{
    /**
     * Cached instances
     * 
     * @var array
     */
    protected $instances = [];

    /**
     * Streamer resource model
     * 
     * @var \Enviably\Streamer\Model\ResourceModel\Streamer
     */
    protected $resource;

    /**
     * Streamer collection factory
     * 
     * @var \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory
     */
    protected $streamerCollectionFactory;

    /**
     * Streamer interface factory
     * 
     * @var \Enviably\Streamer\Api\Data\StreamerInterfaceFactory
     */
    protected $streamerInterfaceFactory;

    /**
     * Data Object Helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     * 
     * @var \Enviably\Streamer\Api\Data\StreamerSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * constructor
     * 
     * @param \Enviably\Streamer\Model\ResourceModel\Streamer $resource
     * @param \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory $streamerCollectionFactory
     * @param \Enviably\Streamer\Api\Data\StreamerInterfaceFactory $streamerInterfaceFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Enviably\Streamer\Api\Data\StreamerSearchResultInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Enviably\Streamer\Model\ResourceModel\Streamer $resource,
        \Enviably\Streamer\Model\ResourceModel\Streamer\CollectionFactory $streamerCollectionFactory,
        \Enviably\Streamer\Api\Data\StreamerInterfaceFactory $streamerInterfaceFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Enviably\Streamer\Api\Data\StreamerSearchResultInterfaceFactory $searchResultsFactory
    ) {
        $this->resource                  = $resource;
        $this->streamerCollectionFactory = $streamerCollectionFactory;
        $this->streamerInterfaceFactory  = $streamerInterfaceFactory;
        $this->dataObjectHelper          = $dataObjectHelper;
        $this->searchResultsFactory      = $searchResultsFactory;
    }

    /**
     * Save Streamer.
     *
     * @param \Enviably\Streamer\Api\Data\StreamerInterface $streamer
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Enviably\Streamer\Api\Data\StreamerInterface $streamer)
    {
        /** @var \Enviably\Streamer\Api\Data\StreamerInterface|\Magento\Framework\Model\AbstractModel $streamer */
        try {
            $this->resource->save($streamer);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(
                'Could not save the Streamer: %1',
                $exception->getMessage()
            ));
        }
        return $streamer;
    }

    /**
     * Retrieve Streamer.
     *
     * @param int $streamerId
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($streamerId)
    {
        if (!isset($this->instances[$streamerId])) {
            /** @var \Enviably\Streamer\Api\Data\StreamerInterface|\Magento\Framework\Model\AbstractModel $streamer */
            $streamer = $this->streamerInterfaceFactory->create();
            $this->resource->load($streamer, $streamerId);
            if (!$streamer->getId()) {
                throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested Streamer doesn\'t exist'));
            }
            $this->instances[$streamerId] = $streamer;
        }
        return $this->instances[$streamerId];
    }

    /**
     * Retrieve Streamers matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Enviably\Streamer\Api\Data\StreamerSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Enviably\Streamer\Api\Data\StreamerSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Enviably\Streamer\Model\ResourceModel\Streamer\Collection $collection */
        $collection = $this->streamerCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var \Magento\Framework\Api\Search\FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var \Magento\Framework\Api\SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = 'streamer_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var \Enviably\Streamer\Api\Data\StreamerInterface[] $streamers */
        $streamers = [];
        /** @var \Enviably\Streamer\Model\Streamer $streamer */
        foreach ($collection as $streamer) {
            /** @var \Enviably\Streamer\Api\Data\StreamerInterface $streamerDataObject */
            $streamerDataObject = $this->streamerInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $streamerDataObject,
                $streamer->getData(),
                \Enviably\Streamer\Api\Data\StreamerInterface::class
            );
            $streamers[] = $streamerDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($streamers);
    }

    /**
     * Delete Streamer.
     *
     * @param \Enviably\Streamer\Api\Data\StreamerInterface $streamer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Enviably\Streamer\Api\Data\StreamerInterface $streamer)
    {
        /** @var \Enviably\Streamer\Api\Data\StreamerInterface|\Magento\Framework\Model\AbstractModel $streamer */
        $id = $streamer->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($streamer);
        } catch (\Magento\Framework\Exception\ValidatorException $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Unable to remove Streamer %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * Delete Streamer by ID.
     *
     * @param int $streamerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($streamerId)
    {
        $streamer = $this->getById($streamerId);
        return $this->delete($streamer);
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param \Enviably\Streamer\Model\ResourceModel\Streamer\Collection $collection
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Enviably\Streamer\Model\ResourceModel\Streamer\Collection $collection
    ) {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
        return $this;
    }
}
