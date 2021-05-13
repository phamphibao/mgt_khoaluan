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
namespace Enviably\Streamer\Api;

/**
 * @api
 */
interface StreamerRepositoryInterface
{
    /**
     * Save Streamer.
     *
     * @param \Enviably\Streamer\Api\Data\StreamerInterface $streamer
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Enviably\Streamer\Api\Data\StreamerInterface $streamer);

    /**
     * Retrieve Streamer
     *
     * @param int $streamerId
     * @return \Enviably\Streamer\Api\Data\StreamerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($streamerId);

    /**
     * Retrieve Streamers matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Enviably\Streamer\Api\Data\StreamerSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Streamer.
     *
     * @param \Enviably\Streamer\Api\Data\StreamerInterface $streamer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Enviably\Streamer\Api\Data\StreamerInterface $streamer);

    /**
     * Delete Streamer by ID.
     *
     * @param int $streamerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($streamerId);
}
