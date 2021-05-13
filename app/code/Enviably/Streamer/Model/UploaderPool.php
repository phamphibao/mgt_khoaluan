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

class UploaderPool
{
    /**
     * Available Uploaders
     * 
     * @var array
     */
    protected $uploaders = [];

    /**
     * constructor
     * 
     * @param array $uploaders
     */
    public function __construct(
        array $uploaders = []
    ) {
        $this->uploaders = $uploaders;
    }

    /**
     * @param string $type
     * @return \Enviably\Streamer\Model\Uploader
     * @throws \Exception
     */
    public function getUploader($type)
    {
        if (!isset($this->uploaders[$type])) {
            throw new \Exception("Uploader not found for type: ".$type);
        }
        $uploader = $this->uploaders[$type];
        if (!($uploader instanceof \Enviably\Streamer\Model\Uploader)) {
            throw new \Exception("Uploader for type {$type} not instance of ". \Enviably\Streamer\Model\Uploader::class);
        }
        return $uploader;
    }
}
