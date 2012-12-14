{include file="header.tpl" title="Profile"}

<div class="container clearfix">
    <div class="recent-work gallery clearfix">
        <div class="slidewrap">
            <div class="sixteen columns">
                <h2 class="title">
                    {translate name="Profile Pictures"}
                    <span class="line"></span>
                </h2>
            </div>

            <ul class="slidecontrols">
                <li>
                    <a href="#next" class="next">{translate name="Next"}</a>
                </li>
                <li>
                    <a href="#prev" class="prev">{translate name="Prev"}</a>
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
</div>

{include file="footer.tpl"}