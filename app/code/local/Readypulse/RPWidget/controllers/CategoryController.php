<?php

class Readypulse_RPWidget_CategoryController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

        $productId = $this->getRequest()->getParam('id');
        
        $product_model = Mage::getModel('catalog/product'); //get product model             

        $all_cats = array();

        $product_model->reset();

        $xml = '';

        $_product = $product_model->load($productId);

        $all_cats = $product_model->getCategoryIds($_product);

        $xml .= '<?xml version="1.0" encoding="UTF-8"?><magento_api><data_item>';

        $noofcat = 1;
        foreach ($all_cats as $cat) {

            $catName = Mage::getModel('catalog/category')->load($cat)->getName();

            $xml .= '<catname' . $noofcat . '>' . $catName . '</catname' . $noofcat . '>';

            $noofcat++;
        }

        $xml .= '</data_item></magento_api>';
        echo $xml;
    }

}
