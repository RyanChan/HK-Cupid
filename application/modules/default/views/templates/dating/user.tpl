{include file="header.tpl" title="User"}

<div class="container gallery clearfix">
    <div class="sixteen columns">
        <h1 class="page-title">{translate name="Dating"} /
            <span class="gray2">{$user->getProfile('nickname')|escape}</span>
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns top-2">
        <h2 class="title">{$user->getProfile('first_name')|escape}, {$user->getProfile('last_name')|escape}</h2>
    </div>

    <div class="twelve columns top bottom">
        <div class="slider-project">
            <div class="flex-container">
                <div class="flexslider2">
                    <ul class="slides">
                        <li>
                            <div class="caption">
                                <a href="/images/img/portfolio/photo-1-1.jpg" rel="prettyPhoto[gallery1]">
                                    <img src="/images/img/portfolio/photo-1-1.jpg">
                                    <span class="hover-effect big zoom"></span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="caption">
                                <a href="/images/img/portfolio/photo-1-2.jpg" rel="prettyPhoto[gallery1]">
                                    <img src="/images/img/portfolio/photo-1-2.jpg">
                                    <span class="hover-effect big zoom"></span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="four columns bottom">
        <h2 class="title top-5 bottom-2">
            {translate name="About Member"}
            <span class="line"></span>
        </h2>
        <div class="about-project bottom">
            {$user->getProfile('intro')|escape}
        </div>
        <div class="clearfix"></div>

    </div>
</div>

{include file="footer.tpl"}