{include file="header.tpl" title="Home"}

<div class="container clearfix">

    <div id="welcome">
        <div class="sixteen columns">
            <div class="welcome">
                <p>
                    歡迎來到 <span class="color">浦點</span>，你將會享受到不一樣的上網樂趣。
                </p>
            </div>
        </div>
    </div><!-- End Welcome -->

    <div class="services clearfix">

        <div class="sixteen columns"> <h2 class="title">浦點服務 <span class="line"></span></h2> </div>

        <ul id="sti-menu" class="sti-menu">

            <!-- item 1 -->
            <li class="four columns">
                <a href="{geturl controller="dating"}">
                    <span data-type="icon" class="sti-icon sti-item color-5"></span>
                    <h2 data-type="mText" class="sti-item">互動交友</h2>
                    <p data-type="sText" class="sti-item"> 認識更多朋友，擴闊社交圈子，開展你的精彩人生。 </p>
                </a>
            </li>
            <!-- End -->

            <!-- item 2 -->
            <li class="four columns">
                <a href="#">
                    <span data-type="icon" class="sti-icon sti-item color-8"></span>
                    <h2 data-type="mText" class="sti-item">交易專區</h2>
                    <p data-type="sText" class="sti-item"> 尋找你所需的貨品，應有盡有，購買你心頭好。 </p>
                </a>
            </li>
            <!-- End -->

            <!-- item 3 -->
            <li class="four columns">
                <a href="#">
                    <span data-type="icon" class="sti-icon sti-item color-7"></span>
                    <h2 data-type="mText" class="sti-item">遊戲人生</h2>
                    <p data-type="sText" class="sti-item"> 將你最喜愛的遊戲，公誅同好，尋找更多玩友，一起遊戲人生。 </p>
                </a>
            </li>
            <!-- End -->

            <!-- item 4 -->
            <li class="four columns">
                <a href="{geturl controller="account"}">
                    <span data-type="icon" class="sti-icon sti-item color-3"></span>
                    <h2 data-type="mText" class="sti-item">個人中心</h2>
                    <p data-type="sText" class="sti-item"> 設置你的個人信息，讓更多人認識你。 </p>
                </a>
            </li>
            <!-- End -->

        </ul>

    </div><!-- End Services -->

    <div class="recent-work gallery clearfix">

        <div class="slidewrap" >

            <div class="sixteen columns"> <h2 class="title">精選會員 <span class="line"></span></h2> </div>

            <ul class="slidecontrols">
                <li><a href="#sliderName" class="next">下一貢</a></li><li><a href="#sliderName" class="prev">上一頁</a></li>
            </ul>

            <ul class="slider" id="sliderName">

                <li class="slide">

                    <!-- item 1 -->
                    <div class="four columns item">
                        <div class="caption">
                            <a href="/images/img/thumbs/thumb-1.jpg" rel="prettyPhoto[gallery1]">
                                <img src="/images/img/thumbs/thumb-1.jpg" alt="" class="pic" />
                                <span class="hover-effect zoom"></span></a>
                        </div><!-- hover effect -->
                        <h4><a href="#">RyanChan</a></h4>
                        <p>男，22歲，巨蟹座</p>
                    </div>
                    <!-- End -->

                    <!-- item 2 -->
                    <div class="four columns item">
                        <div class="caption">
                            <a href="/images/img/thumbs/thumb-2.jpg" rel="prettyPhoto[gallery1]">
                                <img src="/images/img/thumbs/thumb-2.jpg" alt="" class="pic" />
                                <span class="hover-effect zoom"></span></a>
                        </div><!-- hover effect -->
                        <h4><a href="#">阿豪</a></h4>
                        <p>男，22歲，雙子座</p>
                    </div>
                    <!-- End -->

                    <!-- item 3 -->
                    <div class="four columns item">
                        <div class="caption">
                            <a href="/images/img/thumbs/thumb-3.jpg" rel="prettyPhoto[gallery1]">
                                <img src="/images/img/thumbs/thumb-3.jpg" alt="" class="pic" />
                                <span class="hover-effect zoom"></span></a>
                        </div><!-- hover effect -->
                        <h4><a href="#">波仔</a></h4>
                        <p>男，不詳，金牛座</p>
                    </div>
                    <!-- End -->

                    <!-- item 4 -->
                    <div class="four columns item">
                        <div class="caption">
                            <a href="/images/img/thumbs/thumb-4.jpg" rel="prettyPhoto[gallery1]">
                                <img src="/images/img/thumbs/thumb-4.jpg" alt="" class="pic" />
                                <span class="hover-effect zoom"></span></a>
                        </div><!-- hover effect -->
                        <h4><a href="#">老薇</a></h4>
                        <p>女，26歲，不詳</p>
                    </div>
                    <!-- End -->

                </li><!-- End slide -->

            </ul>

        </div><!-- End slidewrap -->

    </div><!-- End recent-work -->

</div><!-- <<< End Container >>> -->


{include file="footer.tpl"}