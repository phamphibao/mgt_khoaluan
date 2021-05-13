<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Customer\Support\Source;

/**
 * Source model for element with enable and disable variants.
 * @api
 * @since 100.0.2
 */
class Enabledisable implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Value which equal Enable for Enabledisable dropdown.
     */
    const ENABLE_VALUE = 1;

    /**
     * Value which equal Disable for Enabledisable dropdown.
     */
    const DISABLE_VALUE = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::ENABLE_VALUE, 'label' => __('Waiting for support')],
            ['value' => self::DISABLE_VALUE, 'label' => __('Done')],
        ];
    }
}
