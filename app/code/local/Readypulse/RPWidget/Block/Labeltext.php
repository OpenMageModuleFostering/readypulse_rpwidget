<?php

class Readypulse_RPWidget_Block_Labeltext extends Mage_Adminhtml_Block_Template {

    public function getSourceUrl() {
        return $this->_getData('source_url');
    }

    public function getElement() {
        return $this->_getData('element');
    }

    public function getUniqId() {
        return $this->_getData('uniq_id');
    }

    public function getFieldsetId() {
        return $this->_getData('fieldset_id');
    }

    public function getHiddenEnabled() {
        return $this->hasData('hidden_enabled') ? (bool) $this->_getData('hidden_enabled') : true;
    }

    protected function _toHtml() {
        $instance_id = Mage::app()->getRequest()->getParam('instance_id');
        $widgetId = Mage::app()->getRequest()->getParam('widget');
        
        if ($instance_id != '' || $widgetId != '') {
            $clearCacheOption = Mage::getStoreConfig('rpwidget/general/clearcache');
            $element = $this->getElement();
            $fieldset = $element->getForm()->getElement($this->getFieldsetId());
            $labelId = $this->getUniqId();

            $hiddenHtml = '';
            if ($this->getHiddenEnabled()) {
                $hidden = new Varien_Data_Form_Element_Hidden($element->getData());
                $hidden->setId("{$chooserId}value")->setForm($element->getForm());
                if ($element->getRequired()) {
                    $hidden->addClass('required-entry');
                }
                $hiddenHtml = $hidden->getElementHtml();
                $element->setValue('');
            }
            if ($clearCacheOption == 'true')
                return '
            <label class="widget-option-label" style="font-size:14px" id="' . $labelId . 'label">'
                        . ($this->getLabel() ? $this->getLabel() : Mage::helper('widget')->__('Warning: Magento cache for all widgets will be automatically refreshed when you save the changes to this ReadyPulse widget')) . '</label>';
            else
                return '
            <label class="widget-option-label" style="font-size:14px" id="' . $labelId . 'label">'
                        . ($this->getLabel() ? $this->getLabel() : Mage::helper('widget')->__('Reminder: Please refresh the magento cache under \'System / Cache Management\' for the changes to take effect')) . '</label>';
        }
        else
            return '';
    }

}

?>
