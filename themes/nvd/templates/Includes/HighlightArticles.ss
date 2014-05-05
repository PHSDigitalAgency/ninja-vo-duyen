<h3 class="funky-text discreet">Chọn</h3>
<ul class="unstyled highlight">
	<% loop HighlightArticles %>
		<li>
			<a href="$Link">
				$Medias.First.Image.CroppedImage(370,210)
				<div>
					<h4>$Title</h4>
					<span class="category">$Parent.Title</span>
				</div>
			</a>
		</li>
	<% end_loop %>
</ul>