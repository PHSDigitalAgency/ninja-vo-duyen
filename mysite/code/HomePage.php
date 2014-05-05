<?php
class HomePage extends Page{

	public static $db = array(
	);

	public static $has_one = array(
	);

	public static $allowed_children = array(
	);
	
}
class HomePage_Controller extends Page_Controller{
	private static $allowed_actions = array (
	);

	public function index($request){
		if($this->ClassName == "Page"){
			return $this->httpError(404);
		}else{
			$numArticles = Article::get()->count();
			$numArticlesBanner = 5;
			
			if($numArticles > $numArticlesBanner){
				$limit = $numArticles - $numArticlesBanner;

				$articles = Article::get()->sort('Enhance DESC, Created DESC');

				$articlesList = $articles->sort('Created DESC')/*->limit($limit,$numArticlesBanner-1)*/; // do not include banner home articles
																				// limit do not work as expected, still looking to debug that

				$children = new PaginatedList($articlesList, $request);
				// $plist->setPageLength(20);
				
				$banner = $articles->limit($numArticlesBanner);

				return $this->customise(array(
					'Children' => $children,
					'BannerHomeArticles' => $banner
					)
				)->renderWith(array('HomePage', 'Page'));

			}else{
				return $this->customise(array('Children' => array()))->renderWith(array('HomePage', 'Page'));
			}
		}
	}

	/*public function getBannerHomeArticles(){
		$articles = Article::get()->sort('Enhance DESC, Created DESC')->limit(4);
		if($articles) return $articles;
		else return null;
	}*/
}