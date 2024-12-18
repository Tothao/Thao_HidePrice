<?php

namespace Thao\HidePrice\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class CustomLink extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = '<a href="your_custom_link">Custom Link</a>';
                }
            }
        }
        return $dataSource;
    }
}
