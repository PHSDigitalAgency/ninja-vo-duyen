<div class="fb-like" data-href="$AbsoluteLink" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div>
<article>
	<div class="created<% if Tags %> pull-left<% end_if %>"><span class="label label-inverse"><small>Được đăng </small></span><span class="label label-important"><small>$Created.Ago</small></span></div>

	<% if Tags %>
	<div class="pull-right tags">
		<span class="muted">Tags:</span>
		<% loop Tags %>
		<a href="{$BaseHref}tag/$URLEncode" title="View all articles tagged with &lsquo;$Title.XML&rsquo;" data-toggle="tooltip" data-trigger="hover"><span class="badge badge-<% if Even %>inverse<% else %>important<% end_if %>"><i class="icon-tag icon-white"></i> <small>$Title</small></span></a>
		<% end_loop %>
	</div>
	<div class="clearfix"></div>
	<% end_if %>

	<h2 class="funky-text">$Title</h2>

	<% if Content %>
		<div class="lead">$Content</div>
	<% end_if %>

	<% if Medias %>
		<% loop Medias %>
			<% if Title %><h4>$Title</h4><% end_if %>
			$Description
			<% if ClassName = NinjaImage %>
				<% if Link %>
				<a href="$ImageLink" target="_blank"<% if Title %> title="$Title.XML"<% end_if %>>
				<% end_if %>
					<figure>
						<% if ShowImageTitle %><figcaption><h5 class="text-center">$Image.Title</h5></figcaption><% end_if %>
						<img src="<% if Image.Width > 768 %>$Image.SetWidth(768).URL<% else %>$Image.URL<% end_if %>" alt="$Image.Title.XML" class="img-polaroid"/>
					</figure>
				<% if Link %>
				</a>
				<% end_if %>
			<% else %>
				<div class="video">
					<figure>
					<% if ShowImageTitle %><figcaption><h5 class="text-center">$Image.Title</h5></figcaption><% end_if %>
					<% if TypeVideo = YouTube %>
						<iframe class="img-polaroid" width="$Width" height="$Height" src="http://www.youtube.com/embed/{$VideoID}?wmode=transparent" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					<% end_if %>
					<% if TypeVideo = Vimeo %>
						<iframe class="img-polaroid" src="http://player.vimeo.com/video/{$VideoID}" width="$Width" height="$Height" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					<% end_if %>
					<% if TypeVideo = DailyMotion %>
						<iframe class="img-polaroid" frameborder="0" width="$Width" height="$Height" src="http://www.dailymotion.com/embed/video/{$VideoID}?highlight=%23B71E25" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					<% end_if %>
					</figure>
				</div>
			<% end_if %>
		<% end_loop %>
	<% end_if %>

	<% if Footer %>
		<div class="footer">$Footer</div>
	<% end_if %>

	<div class="fb-comments" data-href="$AbsoluteLink" data-width="750" data-num-posts="20"></div>
</article>