<?php
class Readypulse_RPWidget_Block_Label extends Mage_Adminhtml_Block_Widget_Grid
{
   public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
       
        $uniqId = Mage::helper('core')->uniqHash($element->getId());

        $label = $this->getLayout()->createBlock('rpwidget/labeltext')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setUniqId($uniqId);

        $element->setData('after_element_html', $label->toHtml());
        return $element;
    }
 
} 
?>
