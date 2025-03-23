<?php
namespace Thao\HidePrice\Block\View;

use Magento\Catalog\Block\Product\View;

class Contact extends View
{
    protected function _prepareLayout()
    {
        $layout = $this->getLayout();
        if ($this->isHidePrice()) {
            $layout->unsetElement('product.info.addtocart');
            $layout->unsetElement('product.price.final');
        }
    }
    public function isHidePrice()
    {
        $product = $this->getProduct();
        return $product->getIsHidePrice();
    }
}
