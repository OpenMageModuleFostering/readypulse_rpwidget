<?php

class Readypulse_RPWidget_Model_Catalogapi extends Mage_Core_Model_Config_Data {

    protected function _afterSave() {
        $postedValue = Mage::app()->getRequest()->getPost();
        $uToken = $postedValue['groups']['general']['fields']['utoken']['value'];
        $apiKey = $postedValue['groups']['general']['fields']['catalogapiuid']['value'];
        $apiSecret = $postedValue['groups']['general']['fields']['catalogapikey']['value'];

        $site_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

        $url = 'http://www.readypulse.com/catalogs/upload/magento/'.$uToken;
        $apiData = array();
       
        $apiData['api_key'] = $apiKey;
        $apiData['api_secret'] = $apiSecret;
        $apiData['site_url'] = $site_url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $apiData);
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode != 200) {
            $output = '';
        }
    }

}