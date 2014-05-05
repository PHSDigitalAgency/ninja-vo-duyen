<?php
class NinjaImage extends DataObject implements PermissionProvider{
	public static $db = array(
		'Title' => 'Varchar(100)',
		'Description' => 'HTMLText',
		'ShowImageTitle' => 'Boolean(0)',
		'Link' => 'Varchar',
	);

	public static $has_one = array(
		'Image' => 'Image',
	);

	public static $has_many = array(
	);

	public static $belongs_many_many = array(
		'Articles' => 'Article',
	);

	public static $summary_fields = array(
		'Thumbnail' => 'Image',
	);

	public $default = array(
		'ShowImageTitle' => '0',
	);

	public static $create_table_options = array(
		'MySQLDatabase' => 'ENGINE=MyISAM'
	);
	
	public static $api_access = true;

	public function canView($member = null) {
		return Permission::check('NINJA_IMAGE_VIEW');
	}
	public function canEdit($member = null) {
		return Permission::check('NINJA_IMAGE_EDIT');
	}
	public function canDelete($member = null) {
		return Permission::check('NINJA_IMAGE_DELETE');
	}
	public function canCreate($member = null) {
		return Permission::check('NINJA_IMAGE_CREATE');
	}
	public function providePermissions() {
		return array(
			'NINJA_IMAGE_VIEW' => 'Read an image object',
			'NINJA_IMAGE_EDIT' => 'Edit an image object',
			'NINJA_IMAGE_DELETE' => 'Delete an image object',
			'NINJA_IMAGE_CREATE' => 'Create an image object',
		);
	}

	public function getThumbnail(){
		if($this->Image()) return $this->Image()->CroppedImage(110,46);
	}

	public function getImageLink(){
		$link = '';
		if($this->Link){
			$link = $this->Link;

			if(strpos(strtolower($link), "http://") !== 0) {
				$link = "http://$link";
			}
		}
		return $link;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		$fields->removeByName('Articles');
		$fields->removeByName('Image');

		$fields->addFieldToTab('Root.Main', new OptionsetField('ShowImageTitle', 'Show Image Title ?', $source = array("1" => "Yes", "0" => "No")), 'Description');

		$fields->addFieldToTab('Root.Main', $uf = new UploadField('Image', 'Image'), 'Description');
		$uf->setFolderName('images');
		$uf->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));

		HtmlEditorConfig::get('cms')->removeButtons(
			'tablecontrols',
			'justifyleft',
			'justifycenter',
			'justifyright',
			'justifyfull',
			'formatselect'
			);

		$fields->addFieldToTab('Root.Main', $editor = new HTMLEditorField('Description', 'Description'));
		$editor->setRows(15);

		return $fields;
	}

	public function onBeforeDelete(){
		parent::onBeforeDelete();

		$image = $this->Image();
		if($image->ID){
			$image->delete();
		}
	}
}