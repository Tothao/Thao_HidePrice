<?php

namespace Thao\Blog\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;
use Thao\Blog\Helper\Data as Helper;

class Topmenu implements ObserverInterface
{

    protected $urlBuilder;

    protected $helper;
    public function __construct(
        UrlInterface $urlBuilder,
        Helper $helper
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;
    }

    public function execute(EventObserver $observer)
    {
        $isEnable = $this->helper->isEnableBlog();

        if (!$isEnable) {
            return;
        }

        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $existingMenuItems = $menu->getChildren();
        $url = $this->urlBuilder->getUrl('', ['_direct' => 'blog']); // Example URL
        foreach ($existingMenuItems as $existingItem) {
            if ($existingItem->getUrl() == $url) {
                return $this; // Do not add a duplicate menu item
            }
        }
        $data = [
            'name'      => __('Blog'),
            'id'        => 'some-unique-id-here', // Unique ID for the new menu item
            'url'       => $url, // URL generated dynamically
            'is_active' => false, // Adjust this condition to dynamically determine if the item is active
        ];
        $node = new Node($data, 'id', $tree, $menu);

        // Add the new menu item to the top menu
        $menu->addChild($node);

        return $this;
    }




}
