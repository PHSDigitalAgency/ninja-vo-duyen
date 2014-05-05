<!-- Fixed navbar -->
<div id="menu">
    <div class="container">
        <div class="navbar">
            <div class="navbar-inner">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <%-- Begin Logo NVD --%>
                <a class="brand" href="$BaseUrl" title="Trang Chủ - $SiteConfig.Title.XML"><img src="$SiteConfig.Logo.SetWidth(260).URL" class="logo" alt="$SiteConfig.Title.XML" width="$SiteConfig.Logo.SetWidth(260).Width" height="$SiteConfig.Logo.SetWidth(260).Height"/><h1 class="hhidden">$SiteConfig.Title</h1></a><%-- End Logo NVD --%>
                <%-- Begin Menu Section --%>
                <div class="nav-collapse collapse">
                    <ul class="nav">
                      <% loop Menu(1) %>
                        <% if Children %>
                          <li class="dropdown <% if LinkingMode = current || LinkingMode = section %> active<% end_if %>">
                            <a href="$Link" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="300" data-close-others="true">$MenuTitle</a>
                            <ul class="dropdown-menu">
                              <% loop Children.Sort(Sort).Reverse %>
                                <%-- <li class="pull-left<% if LinkingMode = current %> active<% end_if %>">
                                  <a href="$Link" title="$MenuTitle.XML" data-toggle="tooltip" data-trigger="hover" data-placement="bottom">$Medias.First.Image.CroppedImage(91,52)<span class="hide">$MenuTitle</span></a> --%>
                                  <% if Children %>
                                  <li class="pull-left">
                                    <a href="$Link" title="$MenuTitle.XML" class="sub-section">$MenuTitle.XML</a>
                                  </li>
                                      <% loop Children %>
                                        <li class="pull-left<% if LinkingMode = current %> active<% end_if %>">
                                          <a href="$Link" title="$Parent.MenuTitle.XML - $MenuTitle.XML" data-toggle="tooltip" data-trigger="hover" data-placement="bottom">
                                            $Medias.First.Image.CroppedImage(89,45)
                                            <span class="hide">$MenuTitle</span>
                                          </a>
                                        </li>
                                      <% end_loop %>
                                  </li>
                                  <% else %>
                                    <% if ClassName = Article %>
                                    <li class="pull-left<% if LinkingMode = current %> active<% end_if %>">
                                      <a href="$Link" title="$MenuTitle.XML" data-toggle="tooltip" data-trigger="hover" data-placement="bottom">
                                        $Medias.First.Image.CroppedImage(89,45)
                                        <span class="hide">$MenuTitle</span></a>
                                    </li>
                                    <% end_if %>
                                  <% end_if %>
                              <% end_loop %>
                            </ul>
                            <div class="clearfix"></div>
                          </li>
                          <% else %>
                          <li<% if LinkingMode = current %> class="active"<% end_if %>><a href="$Link" title="$MenuTitle.XML">$MenuTitle</a></li>
                        <% end_if %>            
                      <% end_loop %>
                    </ul>
                </div><%-- End Menu Section --%>
            </div><%-- .navbar-inner --%>
        </div><%-- .navbar --%>
        <div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <ul id="navextras" class="nav pull-right">
                    <li<% if Top.URLSegment = yesterday %> class="active"<% end_if %>><a href="{$BaseHref}thoi-gian/hom-qua">H&ocirc;m qua</a></li>
                    <li<% if Top.URLSegment = last-week %> class="active"<% end_if %>><a href="{$BaseHref}thoi-gian/tuan-truoc">Tuần trước</a></li>
                    <li<% if Top.URLSegment = last-month %> class="active"<% end_if %>><a href="{$BaseHref}thoi-gian/thang-truoc">Th&aacute;ng trước</a></li>
                    <% if $SearchForm %><li class="search">$SearchForm</li><% end_if %>
                </ul>
               
                <% if BaseHref != http://localhost/nvd/ %>
                <div class="follow-social pull-right">
                  <div class="fb-like" data-href="http://www.facebook.com/NinjaVoDuyen" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-colorscheme="light"></div>
                  <a href="https://twitter.com/ninjavoduyen" class="twitter-follow-button" data-show-count="false">Follow @ninjavoduyen</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </div>
                <% end_if %>


                <div class="clearfix"></div>
            </div><%-- .navbar-inner --%>
        </div><%-- .navbar --%>
    </div>
</div>