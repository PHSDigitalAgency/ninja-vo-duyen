<?php
class Article extends Page{

	public static $db = array(
		'Tags' => 'Text',
		'Enhance' => 'Boolean(0)',
		'Footer' => 'HTMLText'
	);

	public static $has_one = array(
	);

	public static $many_many = array(
		'Medias' => 'NinjaImage',
		'Tags' => 'Tag',
	);

	public static $many_many_extraFields = array(
		'Medias' => array(
			'SortOrder'=>'Int'
		),
	);

	static $default_sort = 'Enhance DESC,Created DESC';

	public static $allowed_children = array(
	);

	public static $can_be_root = false;

/*	static $create_table_options = array(
		'MySQLDatabase' => 'ENGINE=MyISAM'
	);*/

    public function Medias() {
        return $this->getManyManyComponents('Medias')->sort('SortOrder');
    }

	public function getCMSFields(){
		$fields = parent::getCMSFields();


		HtmlEditorConfig::get('cms')->removeButtons(
			'tablecontrols',
			'justifyleft',
			'justifycenter',
			'justifyright',
			'justifyfull',
			'formatselect'
			);

		$fields->addFieldToTab('Root.Main', $editor = new HTMLEditorField('Footer', 'Footer'));

		// enhance
		// $fields->addFieldToTab('Root.Main', new CheckBoxField('Enhance', 'Enhance article visibility ?'), 'Content');
		$fields->addFieldToTab('Root.Main', new OptionsetField('Enhance', 'Enhance article visibility ?', $source = array("0" => "No", "1" => "Yes")), 'Content');
		
		// tags
		$fields->addFieldToTab('Root.Main', $tf = new TagField('Tags', 'Tags', null, 'Article'), 'Content');
		$tf->setSeparator(',');

		// created
		$fields->addFieldToTab('Root.Main', new DatetimeField('Created', 'Created'), 'Content');

		//
		if($this->ID){
			$config = GridFieldConfig_RelationEditor::create(50)
				->removeComponentsByType('GridFieldAddNewButton')
				
				// ->addComponent(new GridFieldBulkImageUpload('ImageID', array('Title')))
				->addComponent(new GridFieldBulkImageUpload())
				->addComponent(new GridFieldBulkManager(array('Title', 'Description', 'ShowImageTitle')))

				->addComponent(new GridFieldAddNewMultiClass())
				->addComponent(new GridFieldAddExistingSearchButton())
		        ->addComponent(new GridFieldOrderableRows('SortOrder'))
		        ->addComponent(new GridFieldEditableColumns(), 'GridFieldEditButton')
		        ->addComponent(new GridFieldDeleteAction());

		    $config->getComponentByType('GridFieldBulkImageUpload')->setConfig('folderName', 'images');

			$config->getComponentByType('GridFieldEditableColumns')->setDisplayFields(array(
				'Title' => 'Title',
				'VideoID' => function($record){
					if($record->ClassName == 'NinjaImage'){
						return new HiddenField('VideoID','Video ID');
					}else{
						return new TextField('VideoID','Video ID');
					}
				},
				'Width' => function($record){
					if($record->ClassName == 'NinjaImage'){
						return new HiddenField('Width','Width');
					}else{
						return new TextField('Width','Width');
					}
				},
				'Height' => function($record){
					if($record->ClassName == 'NinjaImage'){
						return new HiddenField('Height','Height');
					}else{
						return new TextField('Height','Height');
					}
				},
			));

			$config->getComponentByType('GridFieldAddNewMultiClass')->setClasses(array(
					'NinjaImage',
					'NinjaVideo',
				));

			$f = new GridField('Medias', 'Medias', $this->Medias(), $config);

			$fields->addFieldToTab("Root.Medias", $f);
		}

		return $fields;
	}


}
class Article_Controller extends Page_Controller{
	private static $url_handlers = array(
		'$Tag' => 'articlesTag',
		'' => 'index'
	);
	
	private static $allowed_actions = array(
		'articlesTag',
	);

	public function getArticlesByTag($tag){
		
		$tagObj = Tag::get()->where('`Title` = \'' . $tag . '\'')->First();
		
		if($tagObj){
			$tagID = $tagObj->ID;

			Member::get()->leftJoin("Group_Members", "\"Group_Members\".\"MemberID\" = \"Member\".\"ID\"");

			$articles = Article::get()->innerJoin('Article_Tags', '`Article_Tags`.`TagID` = \'' . $tagID . '\' AND `Article_Tags`.`ArticleID` = `Article`.`ID`')->sort('Enhance DESC, Created DESC');

			return $articles;
		}		
	}

	public function articlesTag($request){
		$tag = $request->param('Tag');

		if($tag){
			$result = $this->getArticlesByTag($tag);
			
			return $this->customise(array(
				'Title' => 'Articles by Tag: «' . $tag . '»',
				'MenuTitle' => 'Tag: «' . $tag . '»',
				'URLSegment' => $tag,
				'Children' => new PaginatedList($result, $request)
			))->renderWith(array('Section', 'Page'));

		}else if($this->ClassName == "Article"){
			return $this->renderWith(array('Article','Page'));
			
		}else{
			return $this->httpError(404);
		}
	}
}