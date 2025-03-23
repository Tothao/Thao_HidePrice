<?php
namespace Thao\HidePrice\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class HidePriceViewModel implements ArgumentInterface
{
    protected $customerSession;
    public function __construct(
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    public function isHidePrice($product)
    {
        if (!$product->getIsHidePrice()) {
            return false;
        }

        $hidePriceCustomerGroup = $product->getData('hide_price_customer_group');

        if (!$hidePriceCustomerGroup) {
            return true;
        }

        $hidePriceCustomerGroup = explode(',', $hidePriceCustomerGroup);

        $currentCustomerGroup = $this->customerSession->getCustomer()->getGroupId();

        return in_array($currentCustomerGroup, $hidePriceCustomerGroup);

    }
}
