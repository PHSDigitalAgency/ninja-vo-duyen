<% if Pages %>
<ol class="breadcrumb">
	<% if $Pages.First.URLSegment != home %>
		<li><a href="$BaseHref">Trang Chủ</a></li>
		<% if $Pages.First.URLSegment = Section_Controller %>
			<li class="active">Ph&acirc;n loại theo thời gian</li>
		<% else_if $Pages.First.URLSegment = Article_Controller %>
			<li class="active">Ph&acirc;n loại theo tag</li>
		<% end_if %>
	<% end_if %>
	<% loop Pages %>
		<% if Last %><li class="active">$MenuTitle.XML</li><% else %><li><a href="$Link">$MenuTitle.XML</a></li><% end_if %>
	<% end_loop %>
</ol>
<% end_if %>