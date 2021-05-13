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
namespace Enviably\Streamer\Api\Data;

/**
 * @api
 */
interface StreamerSearchResultInterface
{
    /**
     * Get Streamers list.
     *
     * @return \Enviably\Streamer\Api\Data\StreamerInterface[]
     */
    public function getItems();

    /**
     * Set Streamers list.
     *
     * @param \Enviably\Streamer\Api\Data\StreamerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
