<?php
namespace Customer\Support\Ui\DataProvider\Support\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    /**
     * Override _initSelect to add custom columns
     *
     * @return void
     */
    protected function _initSelect()
    {
        $this->addFilterToMap('support_id', 'main_table.support_id');
        $this->addFilterToMap('name', 'devgridname.value');
        parent::_initSelect();
    }
}
