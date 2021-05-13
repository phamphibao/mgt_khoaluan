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
namespace Enviably\Streamer\Block\Adminhtml\Streamer\Edit\Buttons;

class Generic
{
    /**
     * Widget Context
     * 
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;

    /**
     * Streamer Repository
     * 
     * @var \Enviably\Streamer\Api\StreamerRepositoryInterface
     */
    protected $streamerRepository;

    /**
     * constructor
     * 
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Enviably\Streamer\Api\StreamerRepositoryInterface $streamerRepository
    ) {
        $this->context            = $context;
        $this->streamerRepository = $streamerRepository;
    }

    /**
     * Return Streamer ID
     *
     * @return int|null
     */
    public function getStreamerId()
    {
        try {
            return $this->streamerRepository->getById(
                $this->context->getRequest()->getParam('streamer_id')
            )->getId();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
