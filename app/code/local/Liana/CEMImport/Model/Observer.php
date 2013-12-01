<?php
class Liana_CEMImport_Model_Observer
{
    public $restClient;
    
    public function __contruct(){
		$api_user 		= Mage::getStoreConfig('cemimport/settings/api_user');
    	$api_key 		= Mage::getStoreConfig('cemimport/settings/api_key');
    	$api_url 		= Mage::getStoreConfig('cemimport/settings/api_url');
    	$api_version 	= Mage::getStoreConfig('cemimport/settings/api_version');

    	$this->restClient = new Liana_CEMImport_Model_RestClient(
    		$api_user, $api_key, $api_url, $api_version
    	);
	}

    //This method is called by cronjob 
    public function exportOrders(){
        try{
    	    $model = new Liana_CEMImport_Model_Order();
            $orderList = $model->getOrderList();
            if(!empty($orderList)){
                $this->restClient->call('import', $orderList);
                Mage::Log("Import order to CEM");
            }
        } catch(Exception $ex){
            Mage::Log("magento-cemimport:".$ex->getMessages());
        }
    }
}