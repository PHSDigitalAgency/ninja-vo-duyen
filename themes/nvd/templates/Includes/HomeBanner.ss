<% if BannerHomeArticles %>
<div id="myCarousel" class="carousel slide span8">
    <ol class="carousel-indicators">
    <% loop BannerHomeArticles.limit(3) %>
        <li data-target="#myCarousel" data-slide-to="$Pos(0)"<% if First %> class="active"<% end_if %>></li>
    <% end_loop %>
    </ol>
    <!-- Carousel items -->
    <div class="carousel-inner highlight">
    <% loop BannerHomeArticles.limit(3) %>
        <div class="<% if First %>active <% end_if %>item">
            <a href="$Link">
                $Medias.First.Image.CroppedImage(770,320)
                <div>
                    <span class="muted"><small>Được đăng: $Created.Ago</small></span>
                    <h4>$Title</h4>
                    <span class="category">$Parent.Title</span>
                </div>
            </a>
        </div>
    <% end_loop %>
    </div>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>

<div id="encartBanner" class="span4 highlight">
    <% loop BannerHomeArticles.limit(2,3) %>
        <div>
            <a href="$Link">
                $Medias.First.Image.CroppedImage(370,160)
                <div>
                    <span class="muted"><small>Được đăng: $Created.Ago</small></span>
                    <h4>$Title</h4>
                    <span class="category">$Parent.Title</span>
                </div>
            </a>
        </div>
    <% end_loop %>
</div>
<% end_if %>