<div id="footer">
	<div class="container-fluid">

		<div class="row-fluid">
			<div class="span3">
				<ul class="unstyled sections clearfix">
				<% loop Menu(1) %>
					<li class="pull-left">
						<a href="$Link"><span>$Title.XML</span></a><%-- <% if Pos != TotalItems %> |<% end_if %> --%>
					</li>
				<% end_loop %>
				</ul>
			</div>

			<% if BaseHref != http://localhost/nvd/ %>
			<div class="span3">
				<ul class="unstyled social clearfix">
					<li class="pull-left"><a class="facebook addthis_button_facebook_follow" title="Theo ch&uacute;ng t&ocirc;i tr&ecirc;n Facebook" addthis:userid="NinjaVoDuyen"></a></li>

					<li class="pull-left"><a class="twitter addthis_button_twitter_follow" title="Theo ch&uacute;ng t&ocirc;i tr&ecirc;n Twitter" addthis:userid="ninjavoduyen"></a></li>
					<%-- <li class="pull-left"><a href="#linkedin" class="linkedin" title="Linkedin"></a></li>
					<li class="pull-left"><a href="#youtube" class="youtube" title="Youtube"></a></li> --%>
					<li class="pull-left"><a addthis:userid="{$BaseHref}home/rss" class="rss addthis_button_rss_follow" title="Đăng k&yacute; RSS"></a></li>
				</ul>
			</div>
			<% end_if %>

			<%-- <div class="span3">
				
			</div> --%>

			<div class="span3 pull-right">
				
				<%-- <% if $SearchForm %><div class="search pull-left">$SearchForm</div><% end_if %> --%>
				<%-- <% if $URLSegment != newsletter %>
					<% with Page(newsletter) %>
						<div class="pull-left">
							<h5>$Title</h5>
							$NewsletterForm
						</div>
					<% end_with %>
				<% end_if %> --%>



				<div class="pull-right"><a href="#" title="Quay lại đầu" class="scrollTop">Quay lại đầu</a></div>
				
				<div class="clearfix"></div>

			</div>

		</div>


		<div class="row-fluid">
			<div class="span12">
				<p class="muted credit"><small>&copy; 2013 $SiteConfig.Title, tất cả c&aacute;c quyền.</small></p>
			</div>
		</div>


	</div>
</div>