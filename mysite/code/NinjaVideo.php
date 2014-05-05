<?php
class NinjaVideo extends NinjaImage{
	public static $db = array(
		'VideoID' => 'Varchar(150)',
		'TypeVideo' => 'Enum("YouTube,Vimeo,DailyMotion", "YouTube")',
		'Width' => 'Int',
		'Height' => 'Int',
	);

	public static $has_one = array(
	);

	public static $has_many = array(
	);

	public static $defaults = array(
		'TypeVideo' => 'YouTube',
		'Width' => '480',
		'Height' => '360',
	);

	public static $create_table_options = array(
		'MySQLDatabase' => 'ENGINE=MyISAM'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', new TextField('VideoID', 'VideoID'), 'Image');
		$fields->addFieldToTab('Root.Main', new NumericField('Width', 'Width'), 'Image');
		$fields->addFieldToTab('Root.Main', new NumericField('Height', 'Height'), 'Image');

		$fields->addFieldToTab('Root.Main', new OptionsetField('TypeVideo', 'Type Video', $source = array(
				"YouTube" => "You Tube",
				"Vimeo" => "Vimeo",
				"DailyMotion" => "Daily Motion",
			)
		), 'Width');

		return $fields;
	}

}