<li class="span3">
    <a href="{geturl controller="dating" action="user"}/{$user->getProfile('nickname')|escape}" class="thumbnail">
        <img {if $user->getProfileAlbum()->photos->count() != 0} src="{imagefile id=$user->getProfileAlbum()->photos->last()->id width=260}" {else} data-src="holder.js/260x180" {/if} alt="" />
    </a>
</li>