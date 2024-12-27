<?php
namespace Thao\HidePrice\Block\Wishlist;

use Magento\Framework\View\Element\Template;
use Magento\Wishlist\Model\Item;
use Magento\Wishlist\Model\WishlistFactory;
use Magento\Customer\Model\Session;

class HidePrice extends Template
{
    protected $wishlistFactory;
    protected $customerSession;

    public function __construct(
        Template\Context $context,
        WishlistFactory $wishlistFactory,
        Session $customerSession,
        array $data = []
    ) {
        $this->wishlistFactory = $wishlistFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * Lấy wishlist item từ đối tượng wishlist hiện tại
     */
    public function getWishlistItem()
    {
        $customerId = $this->customerSession->getCustomerId();
        $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId);
        $items = $wishlist->getItemCollection();

        // Trả về wishlist item đầu tiên hoặc có thể sửa lại nếu cần lấy item khác
        return $items->getFirstItem();
    }

    /**
     * Kiểm tra sản phẩm có giá bị ẩn hay không
     */
    public function isHidePrice($product)
    {
        return $product && $product->getIsHidePrice();
    }

    /**
     * Xử lý Allowed Quantity ViewModel
     */
    public function getAllowedQuantity($item)
    {
        $viewModel = $this->getData('allowedQuantityViewModel');
        if ($viewModel) {
            return $viewModel->setItem($item)->getMinMaxQty();
        } else {
            // Xử lý nếu viewModel không có giá trị
            return ['minAllowed' => 1, 'maxAllowed' => 10]; // Default hoặc xử lý khác
        }
    }
}
