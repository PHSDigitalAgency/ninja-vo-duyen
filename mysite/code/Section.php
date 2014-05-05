<?php
class Section extends Page{

	public static $db = array(
	);

	public static $has_one = array(
	);

	public static $allowed_children = array(
		'Article',
		'Section',
	);

}
class Section_Controller extends Page_Controller{

	private static $url_handlers = array(
		'hom-qua' => 'yesterday',
		'tuan-truoc' => 'lastWeek',
		'thang-truoc' => 'lastMonth',
	);

	private static $allowed_actions = array(
		'yesterday',
		'lastWeek',
		'lastMonth'
	);

	public function getArticlesByPeriod($period){
		return Article::get()->where('`ClassName` = \'Article\' AND `Created` >= DATE_SUB(CURDATE(), ' . $period . ')')->sort('Created DESC');
	}

	public function yesterday($request){
		// $result = $this->getArticlesByPeriod('INTERVAL 1 DAY');
		$result = $this->getArticlesByPeriod('INTERVAL 24 HOUR');

		return $this->customise(array(
							'Title' => 'H&ocirc;m qua',
							'MenuTitle' => 'H&ocirc;m qua',
							'URLSegment' => 'hom-qua',
							'Children' => new PaginatedList($result, $request)
						))
					->renderWith(array('Section', 'Page'));
	}

	public function lastWeek($request){
		$result = $this->getArticlesByPeriod('INTERVAL 1 WEEK');

		return $this->customise(array(
							'Title' => 'Tuần trước',
							'MenuTitle' => 'Tuần trước',
							'URLSegment' => 'tuan-truoc',
							'Children' => new PaginatedList($result, $request)
						))
					->renderWith(array('Section', 'Page'));
	}

	public function lastMonth($request){
		$result = $this->getArticlesByPeriod('INTERVAL 1 MONTH');

		$plist = new PaginatedList($result, $request);
		// $plist->setPageLength(5);
		return $this->customise(array(
							'Title' => 'Th&aacute;ng trước',
							'MenuTitle' => 'Th&aacute;ng trước',
							'URLSegment' => 'thang-truoc',
							'Children' => $plist
						))
					->renderWith(array('Section', 'Page'));
	}

	public function index($request){
		if($this->ClassName == "Page"){
			return $this->httpError(404);
		}else{
			$children = Article::get()->where('`ParentID` = ' . $this->ID . '')->sort('Enhance DESC, Created DESC');
			$plist = new PaginatedList($children, $request);
			// $plist->setPageLength(20);
			return $this->customise(array('Children' => $plist))->renderWith(array('Section', 'Page'));
		}
	}

	public function init(){
		parent::init();

	}
}