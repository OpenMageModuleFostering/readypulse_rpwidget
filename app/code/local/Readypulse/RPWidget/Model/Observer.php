<?php

class Readypulse_RPWidget_Model_Observer {

    public function __construct() {
        
    }

    public function widgetWidgetInstanceSaveAfter(Varien_Event_Observer $observer) {
        
        $clearCacheOption = Mage::getStoreConfig('rpwidget/general/clearcache');

        /** @var $widget Mage_Widget_Model_Widget_Instance */
        if ($clearCacheOption == 'true') {
            $invalidatedType = Mage::getModel('core/cache')->getInvalidatedTypes();
            $clearCache = 0;

            if (is_array($invalidatedType)) {
                foreach ($invalidatedType as $type) {
                    if ($type->id == 'block_html' || $type->id == 'layout')
                        $clearCache = 1;
                }
            }

            if ($clearCache == 1) {

                $allTypes = Mage::app()->useCache();

                if (!empty($allTypes['block_html']) || !empty($allTypes['layout'])) {
                    $allTypes['block_html'] = 0;
                    $allTypes['layout'] = 0;
                }
                $tags = Mage::app()->getCacheInstance()->cleanType('block_html');
                $tags = Mage::app()->getCacheInstance()->cleanType('layout');
            }
        }
    }

}

