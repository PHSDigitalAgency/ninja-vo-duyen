<?php

global $project;
$project = 'mysite';

global $database;
$database = '';

require_once('conf/ConfigureFromEnv.php');

// Set the site locale
i18n::set_locale('vi_VN');

FulltextSearchable::enable();

// Object::add_extension('Article', "FulltextSearchable('Tags')");
Object::add_extension('Tag', "FulltextSearchable('Title')");

// Object::add_extension('Article', "FulltextSearchable('Medias')");
Object::add_extension('NinjaImage', "FulltextSearchable('Title,Description')");


LeftAndMain::require_css('mysite/css/leftandmain.css');

GDBackend::set_default_quality(95);

// DashboardGoogleAnalyticsPanel::set_account("yvestrublin@gmail.com", "19foumoila76", "73245992");



// OpenGraphObjectExtension::$default_image = 'mysite/images/PHS-logo.png';