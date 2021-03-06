<?php
class Srka_Flickrgallery_Model_Photosets extends Mage_Eav_Model_Entity_Attribute_Source_Abstract{
	protected $_options;

    public function toOptionArray(){
		if (! isset($this->_options)){
			$raw_xml = file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=' . Mage::getStoreConfig('flickrgalleryconfig/general/apikey') . '&user_id=' . Mage::getStoreConfig('flickrgalleryconfig/general/user') . '&format=rest');
			$xml = new SimpleXMLElement($raw_xml);
			$options = array();
			if($xml['stat'] == 'ok'){
				$options[] = array('label' => '', 'value' => '');
				foreach($xml->photosets->photoset as $photoset){
					$options[] = array('label' => Mage::helper('flickrgallery')->__($photoset->title), 'value' => $photoset['id']);
				}
			}
			$this->_options = $options;
		}
		return $this->_options;
    }

    public function getAllOptions(){
    	return $this->toOptionArray();
    }
	
}