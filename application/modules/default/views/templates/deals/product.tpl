<style>
    .product-info {
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
</style>

<div class="container">
    <div class="row-fluid">
        <h2 class="page-title">
            {$product->user->getProfile('nickname')|escape} / <a href="/{$product->user->getProfile('nickname')|escape}/products">{translate name="Products"}</a> / {$product->title|escape}
        </h2>
        <hr />
    </div>

    <div class="row-fluid">
        <div class="span9">
            <div id="product-display" class="carousel slide">
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
                <a class="left carousel-control" href="#product-display" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#product-display" data-slide="next">&rsaquo;</a>
            </div>

            <hr />
        </div>

        <div class="span3 product-info">
            <h4>{translate name="Seller Info"}</h4>
            <hr />
            <dl>
                <dt>{translate name="Seller"}</dt>
                <dd>{$product->user->getProfile('nickname')|escape}</dd>
                <dt>{translate name="Rating"}</dt>
                <dd>
                    <i class="icon-thumbs-up"></i>&nbsp;<span class="badge badge-success">1000</span>
                    {nbsp nbsp=19}
                    <i class="icon-thumbs-down"></i>&nbsp;<span class="badge badge-important">20</span>
                </dd>
                <dt>{translate name="Products"}</dt>
                <dd>{$product->user->products->count()|escape}</dd>
            </dl>
            {if $isOwner}
                <hr />
                <a href="/{$product->user->getProfile('nickname')|escape}/products/edit/{$product->id}" class="btn btn-primary pull-left">{translate name="Edit"}</a>
                <a href="/{$product->user->getProfile('nickname')|escape}/products/delete/{$product->id}" class="btn btn-danger pull-right">{translate name="Delete"}</a>
            {/if}
        </div>
    </div>
</div>