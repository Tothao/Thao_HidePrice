<?php

namespace Thao\HidePrice\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

class CustomerGroup extends AbstractSource
{
    /**
     * @var CollectionFactory
     */
    protected $customerGroupCollectionFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $customerGroupCollectionFactory
     */
    public function __construct(CollectionFactory $customerGroupCollectionFactory)
    {
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
    }

    /**
     * Get All Options for customer groups
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [];
            $groups = $this->customerGroupCollectionFactory->create();
            foreach ($groups as $group) {
                $this->_options[] = [
                    'label' => $group->getCustomerGroupCode(),
                    'value' => $group->getId(),
                ];
            }
        }
        return $this->_options;
    }
}
