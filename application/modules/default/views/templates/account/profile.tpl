{include file="header.tpl"}

<div class="container clearfix">
    <div class="recent-work gallery clearfix top">
        <div class="slidewrap">
            <div class="sixteen columns">
                <h2 class="title">
                    {translate name="Profile Pictures"}
                    <span class="line"></span>
                </h2>
            </div>

            <ul class="slidecontrols">
                <li>
                    <a href="#sliderName" class="next">{translate name="Next"}</a>
                </li>
                <li>
                    <a href="#sliderName" class="prev">{translate name="Prev"}</a>
                </li>
            </ul>

            <ul class="slider" id="sliderName">
                {for $i=1 to 10}
                <li class="slide">
                    {for $j=1 to 4}
                    {include file="user/profileimage.tpl"}
                    {/for}
                </li>
                {/for}
            </ul>
        </div>
    </div>

    <div class="eleven columns top bottom">
        <div class="bottom">
            <h2 class="title">
                {translate name="Profile"}
                <span class="line"></span>
            </h2>
            <div class="box">
                <p>
                <h2>{$identity->nickname|escape}</h2>
                </p>
            </div>
        </div>

        <!-- Hide if completed Start -->
        <div class="bottom">
            <h2 class="title">
                {translate name="Profile Completion"} (60%)
                <span class="line"></span>
            </h2>
            <div class="meter"><span style="width:60%;"></span></div>
        </div>
        <!-- Hide if completed End -->

        <!-- Show Matching girls if the user is enabled dating function -->

        <div class="bottom">
            <h2 class="title">
                {translate name="My Tags"}
                <span class="line"></span>
            </h2>
            <div class="box">
                <p>
                    {translate name="Add your tags"}
                </p>
            </div>
        </div>
    </div>

    {include file="user/navigation.tpl"}
</div>