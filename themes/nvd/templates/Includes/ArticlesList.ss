<article>
    <h2 class="funky-text<% if ClassName = HomePage %> hidden<% end_if %>">$Title</h2>
    <% if Children %>
        <ul class="unstyled articles">
        <% loop Children %>
            <li class="media clearfix">
                <% if Medias %>
                <a href="$Link" title="$MenuTitle.XML" class="pull-left thumbnail">
                    <img src="$Medias.First.Image.CroppedImage(200,120).URL" alt="$Medias.First.Image.Title.XML" class="media-object"/>
                </a>
                <% end_if %>
                <a href="$Link" title="$MenuTitle.XML" class="media-body">
                    <span class="muted pull-right">$Parent.Title</span>
                    <div class="created">
                        <span class="label label-inverse"><small>Được đăng </small></span><span class="label label-important"><small>$Created.Ago</small></span>
                    </div>
                
                    <h4 class="media-heading">$Title</h4>
                    <p>$StripHtmlContent(150)</p>
                    
                    <div class="pull-right">
                        <span class="badge badge-<% if Even %>inverse<% else %>important<% end_if %>"><small>Xem th&ecirc;m</small> <i class="icon-plus-sign icon-white"></i></span>
                    </div>
                </a>
            </li>
        <% end_loop %>
        </ul>
    <% else %>
        <div class="alert">Xin lỗi, kh&ocirc;ng c&oacute; b&agrave;i được hiển thị.</div>
    <% end_if %>

    <% if Children.MoreThanOnePage %>
    <div class="pagination pagination-centered">
        <ul>
        <% if Children.NotFirstPage %>
            <li><a href="$Children.PrevLink" title="Trang trước">&lt;&lt;</a></li>
        <% else %>
            <li class="disabled"><span>&lt;&lt;</span></li>
        <% end_if %>
                
        <% loop Children.Pages %>
            <% if $CurrentBool %>
                <li class="active"><span>$PageNum</span></li>
            <% else %>
                <li><a href="$Link" title="Chuyển đến trang $PageNum" >$PageNum</a></li>
            <% end_if %>
        <% end_loop %>

        <% if Children.NotLastPage %>
            <li><a href="$Children.NextLink" title="Trang sau">&gt;&gt;</a></li>
        <% else %>
            <li class="disabled"><span>&gt;&gt;</span></li>
        <% end_if %>
        </ul>
    </div>
    <% end_if %>

</article>