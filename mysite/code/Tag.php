<?php
class Tag extends DataObject{
	static $db = array(
		'Title' => 'Varchar(200)',
	);

	static $belongs_many_many = array(
		'Articles' => 'Article',
	);

	public static $create_table_options = array(
		'MySQLDatabase' => 'ENGINE=MyISAM'
	);
	
	public function URLEncode(){
		return urlencode($this->Title);
	}

/*	static $create_table_options = array(
		'MySQLDatabase' => 'ENGINE=MyISAM'
	);*/


}