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
interface StreamerInterface
{
    /**
     * ID
     * 
     * @var string
     */
    const STREAMER_ID = 'streamer_id';

    /**
     * Name attribute constant
     * 
     * @var string
     */
    const NAME = 'name';

    /**
     * Avatar attribute constant
     * 
     * @var string
     */
    const AVATAR = 'avatar';

    /**
     * Status attribute constant
     * 
     * @var string
     */
    const STATUS = 'status';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getStreamerId();

    /**
     * Set ID
     *
     * @param int $streamerId
     * @return StreamerInterface
     */
    public function setStreamerId($streamerId);

    /**
     * Get Name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Set Name
     *
     * @param mixed $name
     * @return StreamerInterface
     */
    public function setName($name);

    /**
     * Get Avatar
     *
     * @return mixed
     */
    public function getAvatar();

    /**
     * Set Avatar
     *
     * @param mixed $avatar
     * @return StreamerInterface
     */
    public function setAvatar($avatar);

    /**
     * Get Status
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param mixed $status
     * @return StreamerInterface
     */
    public function setStatus($status);

    /**
     * Get Avatar URL
     *
     * @return string
     */
    public function getAvatarUrl();
}
