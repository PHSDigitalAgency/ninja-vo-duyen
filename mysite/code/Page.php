<?php
class Page extends SiteTree {

	private static $db = array(
	);

	private static $has_one = array(
	);

	private static $allowed_children = array(
	);

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

		$fields->addFieldToTab('Root.Main', $editor = new HTMLEditorField('Content', 'Content'));

		return $fields;
	}

	public function stripHtmlTags($str){
		return trim(preg_replace('/\s+/', ' ', strip_tags($str)));
	}

	public function StripHtmlContent($num){
		$strip = $this->stripHtmlTags($this->Content);

		if(mb_strlen($strip) > $num){
			$strip = mb_substr($strip, 0, $num) . "...";
		}
		return $strip;
	}

	public function onBeforeWrite(){
		if(!$this->MetaDescription){
			if($this->Content){
				$this->MetaDescription = $this->stripHtmlTags($this->Content);
			}
		}
		parent::onBeforeWrite();
	}

	public function getOGImage(){
		if($this->ClassName == "Article"){
			$media = $this->Medias()->First();
			if($media){
				return $media->Image()->AbsoluteURL;
			}
		}else return Director::absoluteURL(SiteConfig::get()->First()->Logo()->AbsoluteURL);
	}

	public function NewsletterForm(){

		// block prototype validation
		//Validator::set_javascript_validation_handler('none');
		Requirements::css('newsletter/css/SubscriptionPage.css');
		// load the jquery
		// Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery-validate/jquery.validate.min.js');

		if($this->URLParams['Action'] === 'completed' || $this->URLParams['Action'] == 'submitted') return;
		$dataFields = singleton('Recipient')->getFrontEndFields()->dataFields();
		
		if($this->CustomLabel) $customLabel = Convert::json2array($this->CustomLabel);

		$fields = array();
		if($this->Fields){
			$fields = explode(",",$this->Fields);
		}

		$recipientInfoSection = new CompositeField();

		$requiredFields = Convert::json2array($this->Required);
		if(!empty($fields)){
			foreach($fields as $field){
				if(isset($dataFields[$field]) && $dataFields[$field]){
					if(is_a($dataFields[$field], "ImageField")){
						if(isset($requiredFields[$field])) {
							$title = $dataFields[$field]->Title()." * ";
						}else{
							$title = $dataFields[$field]->Title();
						}
						$dataFields[$field] = new SimpleImageField(
							$dataFields[$field]->Name(), $title
						);
					}else{
						if(isset($requiredFields[$field])) {
							if(isset($customLabel[$field])){
								$title = $customLabel[$field]." * ";
							} else {
								$title = $dataFields[$field]->Title(). " * ";
							}
						}else{
							if(isset($customLabel[$field])){
								$title = $customLabel[$field];
							} else {
								$title = $dataFields[$field]->Title();
							}
						}
						$dataFields[$field]->setTitle($title);
					}
					$recipientInfoSection->push($dataFields[$field]);
				}
			}
		}
		$formFields = new FieldList(
			$recipientInfoSection
		);
		$recipientInfoSection->setID("MemberInfoSection");

		if($this->MailingLists){
			$mailinglists = DataObject::get("MailingList", "ID IN (".$this->MailingLists.")");
		}
		
		if(isset($mailinglists) && $mailinglists && $mailinglists->count()>1){
			$newsletterSection = new CompositeField(
				new LabelField("Newsletters", _t("SubscriptionPage.To", "Subscribe to:"), 3),
				new CheckboxSetField("NewsletterSelection","", $mailinglists, $mailinglists->getIDList())
			);
			$formFields->push($newsletterSection);
		}
		
		$buttonTitle = $this->SubmissionButtonText;
		$actions = new FieldList(
			new FormAction('doSubscribe', $buttonTitle)
		);
		
		if(!empty($requiredFields)) $required = new RequiredFields($requiredFields);
		else $required = null;
		$form = new Form($this, "Form", $formFields, $actions, $required);
		
		// using jQuery to customise the validation of the form
		$FormName = $form->FormName();
		$validationMessage = Convert::json2array($this->ValidationMessage);

		if(!empty($requiredFields)){
			$jsonRuleArray = array();
			$jsonMessageArray = array();
			foreach($requiredFields as $field => $true){
				if($true){
					if(isset($validationMessage[$field]) && $validationMessage[$field]) {
						$error = $validationMessage[$field];
					}else{
						$label=isset($customLabel[$field])?$customLabel[$field]:$dataFields[$field]->Title();
						$error = sprintf(
							_t('Newsletter.PleaseEnter', "Please enter your %s field"),
							$label
						);
					}
					
					if($field === 'Email') {
						$jsonRuleArray[] = $field.":{required: true, email: true}";
						$message = <<<JSON
{
required: "<span class='exclamation'></span><span class='validation-bubble alert alert-error'>
$error<span></span></span>",
email: "<span class='exclamation'></span><span class='validation-bubble alert alert-error'>
Please enter a valid email address<span></span></span>"
}
JSON;
						$jsonMessageArray[] = $field.":$message";
					} else {
						$jsonRuleArray[] = $field.":{required: true}";
						$message = <<<HTML
<span class='exclamation'></span><span class='validation-bubble alert alert-error'>$error<span></span></span>
HTML;
						$jsonMessageArray[] = $field.":\"$message\"";
					}
				}
			}
			$rules = "{".implode(", ", $jsonRuleArray)."}";
			$messages = "{".implode(",", $jsonMessageArray)."}";
		}else{
			$rules = "{Email:{required: true, email: true}}";
			$emailAddrMsg = _t('Newsletter.ValidEmail', 'Please enter your email address');
			$messages = <<<JS
{Email: {
required: "<span class='exclamation'></span><span class='validation-bubble alert alert-error'>
$emailAddrMsg<span></span></span>",
email: "<span class='exclamation'></span><span class='validation-bubble alert alert-error'>
$emailAddrMsg<span></span></span>"
}}
JS;
		}

		// set the custom script for this form
		Requirements::customScript(<<<JS
(function($) {
	jQuery(document).ready(function() {
		$("#$FormName").validate({
			errorPlacement: function(error, element){
				error.insertAfter(element);
			},
			focusCleanup: true,
			messages: $messages,
			rules: $rules
		});
		$("#$FormName input[name=Email]").attr('placeholder', 'Email');
		$("#$FormName #Email label").css('display', 'none');
	});
})(jQuery);
JS
		);
		$form->addExtraClass("form-inline");
		return $form;
	}
}
class Page_Controller extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array(
		'rss'
	);

	public function init() {
		parent::init();

		Requirements::clear();
		Requirements::set_write_js_to_body(false);
		/*Requirements::themedCSS('bootstrap.min');
		Requirements::themedCSS('bootstrap-responsive.min');
		Requirements::themedCSS('main');
		Requirements::themedCSS('main-responsive');*/

		
		Requirements::combine_files(
			'styles.css',
			array(
				'themes/nvd/css/bootstrap.min.css',
				'themes/nvd/css/bootstrap-responsive.min.css',
				'themes/nvd/css/main.css',
				'themes/nvd/css/main-responsive.css',
			)
		);

		// Requirements::javascript('themes/nvd/javascript/jquery-1.9.1.min.js');
		/*Requirements::javascript('themes/nvd/javascript/jquery-2.0.2.min.js');
		Requirements::javascript('themes/nvd/javascript/bootstrap.min.js');
		Requirements::javascript('themes/nvd/javascript/twitter-bootstrap-hover-dropdown.min.js');
		Requirements::javascript('themes/nvd/javascript/jquery.fitvids.js');
		Requirements::javascript('themes/nvd/javascript/jquery.hammer.min.js');
		Requirements::javascript('themes/nvd/javascript/scripts.js');*/
		
		Requirements::combine_files(
			'scripts.js',
			array(
				// 'themes/nvd/javascript/jquery-1.9.1.min.js',
				'themes/nvd/javascript/jquery-2.0.2.min.js',
				'themes/nvd/javascript/bootstrap.min.js',
				'themes/nvd/javascript/twitter-bootstrap-hover-dropdown.min.js',
				'themes/nvd/javascript/jquery.fitvids.js',
				'themes/nvd/javascript/jquery.hammer.min.js',
				'themes/nvd/javascript/scripts.js'
			)
		);


		RSSFeed::linkToFeed($this->Link() . "rss", "20 Most Recent Articles");
	}

	public function getHighlightArticles(){
		if($this->ClassName != 'HomePage'){
			$id = $this->ID;

			$articles = Article::get()->exclude('ID',"$id")->sort('Enhance DESC, Created DESC')->limit(6);
			if($articles) return $articles;
			else return null;
		}else{
			$articles = Article::get()->sort('Enhance DESC, Created DESC')->limit(6, 5); // do not include banner home articles
			if($articles) return $articles;
			else return null;
		}
	}

	public function rss() {
		
		if($this->ClassName == 'Section'){
			$list = Article::get()->where('`ParentID` = ' . $this->ID)->limit(20)->sort('Created DESC');
			$title = SiteConfig::get()->First()->Title . " Feed of " . $this->Title . " section";
			$description = $title;
		}else if($this->ClassName == 'Article'){
			$list = Article::get()->where('`ParentID` = ' . $this->ParentID)->limit(20)->sort('Created DESC');
			$title = SiteConfig::get()->First()->Title . " Feed of " . $this->Parent()->Title . " section";
			$description = $title;

		}else{
			$list = Article::get()->limit(20)->sort('Created DESC');
			$title = SiteConfig::get()->First()->Title . " Feed";
			$description = $title;
		}

		$rss = new RSSFeed($list, $link = $this->Link("rss"), $title, $description = $title);
		
		return $rss->outputToBrowser();
	}


	public function getRssFeed(){
		return $this->rss();
	}
}
