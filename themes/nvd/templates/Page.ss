<!DOCTYPE html>
<!--[if !IE]><!-->
<html xmlns:fb="http://ogp.me/ns/fb#" lang="$ContentLocale">
<!--<![endif]-->
<!--[if IE 6 ]><html lang="$ContentLocale" class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html lang="$ContentLocale" class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="$ContentLocale" class="ie ie8"><![endif]-->
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400&amp;subset=latin,vietnamese' rel='stylesheet' type='text/css'>
	<script src="$ThemeDir/javascript/modernizr.js"></script>
	<% include GoogleAnalytics %>
	<%-- Fav and touch icons --%>
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="$ThemeDir/images/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="$ThemeDir/images/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="$ThemeDir/images/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="$ThemeDir/images/favicon.ico">
	<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />
</head>
<body>
	<div id="wrap">
		<% include TopPub %>
		<% include Navbar %>
		<div id="layout" class="container <% if ClassName != HomePage %>$ClassName<% else %><% if BannerHomeArticles %>$ClassName<% else %>SearchResult<% end_if %><% end_if %>">
			<div class="row">
				<% if ClassName = HomePage %><% include HomeBanner %><% end_if %>

				<div class="span8">
					$Breadcrumbs
					<div id="innerLayout" class="ninjawell">
						$Layout
					</div>
				</div>
				<div class="span4">
					<div id="selectionArticles" class="ninjawell">
						<% include HighlightArticles %>
					</div>
				</div>
			</div>
		</div>
		<div id="push"></div>
	</div>
	<% include Footer %>
	<% include SocialToolbox %>
</body>
<% include FBRoot %>
</html>
