<?php
class SiteConfigExtras extends DataExtension{
	public static $has_one = array(
		'Logo' => 'Image',
	);

	public static $has_many = array(
	);

	public function updateCMSFields(FieldList $fields){

		$uf = new UploadField('Logo', 'Logo Site');
		$uf->setFolderName('images');
		$uf->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));

		$fields->addFieldToTab('Root.Main', $uf);

	}

}