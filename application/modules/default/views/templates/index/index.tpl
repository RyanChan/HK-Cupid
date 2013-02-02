<div id="notice" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="noticeLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="noticeLabel">{translate name="注意"}</h3>
    </div>
    <div class="modal-body">
        <p>正在測試階段，網站可能間中暫停。</p>
        <p>
            正局部開放網站功能
        </p>
        <p><a href="{geturl controller="dating"}" class="btn btn-primary">交友&nbsp;<i class="iconic-o-check"></i></a></p>
        <p><a href="{geturl controller="album"}" class="btn btn-primary">相簿&nbsp;<i class="iconic-o-check"></i></a></p>
        <p><a href="#" class="btn btn-danger">買賣&nbsp;<i class="iconic-o-x"></i></a></p>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
<div class="container">
    <div id="myCarousel" class="carousel slide">
        <div class="carousel-inner">
            <div class="item active">
                <img src="http://twitter.github.com/bootstrap/assets/img/examples/slide-01.jpg" alt="">
                <div class="carousel-caption">
                    <h4>First Thumbnail label</h4>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
            </div>
            <div class="item">
                <img src="http://twitter.github.com/bootstrap/assets/img/examples/slide-02.jpg" alt="">
                <div class="carousel-caption">
                    <h4>Second Thumbnail label</h4>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
            </div>
            <div class="item">
                <img src="http://twitter.github.com/bootstrap/assets/img/examples/slide-03.jpg" alt="">
                <div class="carousel-caption">
                    <h4>Third Thumbnail label</h4>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>

    <div class="row-fluid">
        <h2>{translate name="Components"}</h2>
        <hr />
        <ul class="thumbnails">
            <li class="span3">
                <div class="thumbnail">
                    <img data-src="holder.js/300x200" alt="" />
                    <div class="caption">
                        <h3>{translate name="Dating"}</h3>
                        <p>{translate name="Dateting with your target where you find on our website"}</p>
                        <p><a href="{geturl controller="dating"}" class="btn btn-primary">{translate name="Enter"}</a></p>
                    </div>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail">
                    <img data-src="holder.js/300x200" alt="" />
                    <div class="caption">
                        <h3>{translate name="Albums"}</h3>
                        <p>{translate name="Explode other people's album, just have fun with it."}</p>
                        <p><a href="{geturl controller="album"}" class="btn btn-primary">{translate name="Enter"}</a></p>
                    </div>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail">
                    <img data-src="holder.js/300x200" alt="" />
                    <div class="caption">
                        <h3>{translate name="Deals"}</h3>
                        <p>{translate name="Find out your favorite products on our markets"}</p>
                        <p><a href="#" class="btn btn-primary">{translate name="Enter"}</a></p>
                    </div>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail">
                    <img data-src="holder.js/300x200" alt="" />
                    <div class="caption">
                        <h3>{translate name="Account"}</h3>
                        <p>{translate name="Sign up or Login to our website. Get start your life"}</p>
                        <p><a href="{geturl controller="account"}" class="btn btn-primary">{translate name="Enter"}</a></p>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <h2>{translate name="Featured Members"}</h2>
            <hr />
            <ul class="thumbnails">
                {foreach from=$users item=user}
                    {include file="index/member.tpl" user=$user}
                {/foreach}
            </ul>
        </div>
        <div class="span6">
            <h2>{translate name="Featured Albums"}</h2>
            <hr />
            <ul class="thumbnails">
                {foreach from=$albums item=album}
                    {include file="index/album.tpl" album=$album}
                {/foreach}
            </ul>
        </div>
    </div>

    <div class="row-fluid">
        <h2>{translate name="Recent Uploads"}</h2>
        <hr />
        <ul class="thumbnails">
            {foreach from=$photos item=photo}
                <li class="span2">
                    <a href="/{$photo->user->username|escape}/albums/{$photo->album->id|escape}/photos" class="thumbnail" rel="tooltip" title="{$photo->album->title|escape}">
                        <img src="{imagefile id=$photo->id w=200}" alt="" />
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
</div>