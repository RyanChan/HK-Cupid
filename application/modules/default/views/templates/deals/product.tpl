{include file="header.tpl" title="Product"}

<div class="container gallery clearfix">

    <div class="sixteen columns">
        <h1 class="page-title">
            User / <span class="gray2">{translate name="Products"}</span>
            <span class="line"></span>
        </h1>
    </div><!-- Page Title -->

    <div class="sixteen columns top-2">
        <h2 class="title">
            MonsterUp
            <a href="#" data="{translate name="Next Project"}" class="next-project"></a>
            <a href="#" data="{translate name="Previous Project"}" class="prev-project disabled"></a>
        </h2>
    </div><!-- Project Title -->

    <!-- Start Project Slider -->
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
                            </div><!-- hover effect -->
                        </li>
                        <li>
                            <div class="caption">
                                <a href="/images/img/portfolio/photo-1-2.jpg" rel="prettyPhoto[gallery1]">
                                    <img src="/images/img/portfolio/photo-1-2.jpg">
                                    <span class="hover-effect big zoom"></span>
                                </a>
                            </div><!-- hover effect -->
                        </li>
                    </ul>
                </div>
            </div>

        </div><!-- End slider-project -->

    </div>
    <!-- End -->

    <!-- Start Project Details -->
    <div class="four columns  bottom">

        <h2 class="title top-5  bottom-2">
            {translate name="About Project"}
            <span class="line"></span>
        </h2>

        <div class="about-project bottom">
            <p>
                Donec seid odio dui. Nullalit libero, alea pharetra augue. Nullam id dolor ideacto vehicula SockMonkee lorem dolor. <br /><br />
                Donec seid odio dui. Nullalit libero, alea pharetra augue. Nullam id dolor ideacto vehicula SockMonkee lorem dolor.
            </p>
        </div>

        <div class="clearfix"></div>

        <h2 class="title bottom-2">Job Description <span class="line"></span></h2>

        <ul class="square-list job bottom-2">
            <li><a href="#">HTML/CSS</a></li>
            <li><a href="#">Logo Design</a></li>
            <li><a href="#">User Interface Design</a></li>
        </ul><!-- End square-list -->


        <a href="#" class="button medium color">Launch Project</a>

    </div>
    <!-- End Project Details -->

    <div class="clearfix"></div>

</div>
{include file="footer.tpl"}