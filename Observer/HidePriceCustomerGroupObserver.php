<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Thao\HidePrice\Observer;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\CatalogInventory\Model\Stock\Item;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

class HidePriceCustomerGroupObserver implements ObserverInterface
{
    /**
     * Process stock item data
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $hidePriceCustomerGroup = $product->getHidePriceCustomerGroup();
        if (is_array($hidePriceCustomerGroup)) {
            $product->setHidePriceCustomerGroup(implode(',',$hidePriceCustomerGroup));
        }
    }
}
