<?php
namespace Thao\HidePrice\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Boolean as BaseBoolean;

class Boolean extends BaseBoolean
{
    /**
     * Retrieve option array with labels
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('No'), 'value' => 0],
                ['label' => __('Yes'), 'value' => 1]
            ];
        }
        return $this->_options;
    }

    /**
     * Get option text by value
     *
     * @param string|int $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
