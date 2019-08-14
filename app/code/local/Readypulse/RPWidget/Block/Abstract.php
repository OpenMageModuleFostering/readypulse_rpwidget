<?php

$RPSDKpath = Mage::getModuleDir('', 'Readypulse_RPWidget') . DS . 'RPWidgetSDK';
require_once ($RPSDKpath . DS . 'iRPWidgetSettings.php');
require_once ($RPSDKpath . DS . 'RPWidget.php');

abstract class Readypulse_RPWidget_Block_Abstract extends Mage_Core_Block_Template implements iRPWidgetSettings {

    /**
     * The constructor
     * 
     * @return Readypulse_RPWidget_Block_Abstract
     * 
     * 
     */
    public $_settings = array();
    private $_product_id;
    private $_categoryList = array();

    public function __construct() {
        parent::__construct();
        // set up the cache
        
        $cacheTime = Mage::getStoreConfig('rpwidget/general/cachetime');
        if ($cacheTime == '')
            $cacheTime = 60;
        $cacheTimeSecond = ($cacheTime * 60);
        $this->setCacheLifetime($cacheTimeSecond);
    }

    function getWidgetUrl() {
        return 'http://www.readypulse.com/curations/';
    }

    /**
     * function useNativeLook
     * return boolean
     */
    function useNativeLook() {
        return ($this->getData('nativelook') == 'true') ? true : false;
    }

    /**
     * function getWidgetType
     * returns string ('feed', 'album', 'gallery')
     */
    function getWidgetType() {
        $type = $this->getData('type');
        $widgetType = end(explode('/', $type));

        return $widgetType;
    }

    /**
     * function getWidgetWidth
     * returns string (width of widget)
     */
    function getWidgetWidth() {
            return $this->getData('width');
    }

    /**
     * function getWidgetHeight
     * returns string (height of widget)
     */
    function getWidgetHeight() {
       return $this->getData('height');
    }

    /**
     * function getWidgetScope
     * returns string (scope of widget)
     */
    function getWidgetScope() {

        if ($this->getData('scope') == '') {
            $currentproduct = Mage::registry('current_product');

            $currentCategory = Mage::registry('current_category');

            if ($currentCategory) {
                $catId = $currentCategory->getId();
                $product_cats = $this->getParentCategories($catId);
                $scope = 'product_categories:' . $product_cats;
            }

            if ($currentproduct) {
                $this->_product_id = $currentproduct->getId();
                $product_cats = $this->getProductCategories();
                $scope = 'product_categories:' . $product_cats;
                $scope .= '|product_id:' . $this->_product_id;
            }
        } else {
            $scope = $this->getData('scope');
            $scope_value = $this->getData('scopevalue');
            if ($scope == 'product_category')
                $scope = 'product_categories:' . $scope_value;
            else if ($scope == 'product_id')
                $scope = 'product_id:' . $scope_value;
            else if ($scope == 'keyword')
                $scope = 'keyword:' . $scope_value;
        }

        return $scope;
    }

    /**
     * function showWidgetHeader
     * return boolean
     */
    function showWidgetHeader() {
        return ($this->getData('show-header') == 'true') ? true : false;
    }

    /**
     * function showWidgetFooter
     * return boolean
     */
    function showWidgetFooter() {
        return ($this->getData('show-footer') == 'true') ? true : false;
    }

    function getWidgetId() {

        return $this->getData('id');
    }

    function getThemeId() {
        return $this->getData('theme');
    }

    /**
     * function getGetAgent
     * return string
     */
    function getAgent() {
        return 'magento-extension';
    }

    /**
     * function getGetAgent
     * return string
     */
    function getRef() {
        $currentUrl = $this->helper('core/url')->getCurrentUrl();
        return $currentUrl;
    }

    /**
     * Returns the feed items
     * 
     * @return array
     */
    public function getItems() {
        $this->_settings['nativelook'] = $this->useNativeLook();
        $this->_settings['widgeturl'] = $this->getWidgetUrl();
        $this->_settings['height'] = $this->getWidgetHeight();
        $this->_settings['scope'] = $this->getWidgetScope();
        $this->_settings['type'] = $this->getWidgetType();
        $this->_settings['width'] = $this->getWidgetWidth();
        $this->_settings['id'] = $this->getWidgetId();
        $this->_settings['theme'] = $this->getThemeId();
        $this->_settings['showheader'] = $this->showWidgetHeader();
        $this->_settings['showfooter'] = $this->showWidgetFooter();
        $this->_settings['plugintype'] = 'magento';
        $this->_settings['agent'] = $this->getAgent();
        $this->_settings['ref'] = $this->getRef();

        $rpwidget = new RPWidget($this->_settings);

        $html = $rpwidget->getXTemplate();

        return $html;
    }

    private function getProductCategories() {
        $product_model = Mage::getModel('catalog/product');

        $all_cats = array();

        $product_model->reset();

        $_product = $product_model->load($this->_product_id);

        $all_cats = $product_model->getCategoryIds($_product);

        foreach ($all_cats as $cat) {
            $categoryList[] = $this->getParentCategories($cat);
        }
        return implode(",", $categoryList);
    }

    private function getParentCategories($category_id) {
        $categoryModel = Mage::getModel('catalog/category');
        $catPaths = explode('/', $categoryModel->load($category_id)->getPath());
        foreach ($catPaths as $catPath) {
            $catId = $categoryModel->load($catPath);
            if ($catId->getLevel() > 1 && $catId != $category_id) {
                $categoryList[] = $catId->getName();
            }
        }

        return implode(",", $categoryList);
    }

}

