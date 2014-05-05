<?php
class DashboardEnhancedArticlesPanel extends DashboardPanel{

  
  static $db = array (
    'Count' => 'Int'
  );



  static $defaults = array (
    'Count' => 10
  );

  static $icon = "mysite/img/icons/highlighter.png";
  
  static $priority = 10;

  public function getLabel(){
    return _t('Mysite.ENHANCEDARTICLES','Enhanced articles');
  }

  public function getDescription(){
    return _t('Mysite.ENHANCEDARTICLESDESCRIPTION','Shows enhanced articles.');
  }

  public function getConfiguration() {
    $fields = parent::getConfiguration();
    $fields->push(TextField::create("Count",_t('Mysite.COUNT','Number of pages to display')));
    return $fields;
  }

  public function EnhancedArticles() {
    $records = Article::get()->where("Enhance = 1")->sort("Created DESC")->limit($this->Count);

    $set = ArrayList::create(array());
    foreach($records as $r) {
      $set->push(ArrayData::create(array(
        'EditLink' => Injector::inst()->get("CMSPagesController")->Link("edit/show/{$r->ID}"),
        'Title' => $r->Title
      )));
    }
    return $set;
  }
}