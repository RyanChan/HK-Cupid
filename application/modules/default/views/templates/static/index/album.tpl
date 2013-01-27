<li class="span3">
    <a href="/{$user->username|escape}/albums/{$album->id}/photos" class="thumbnail" rel="tooltip" title="{$album->title|escape}">
        <img {if $album->photos->count() != 0} src="{imagefile id=$album->photos->last()->id w=270}"{else} data-src="holder.js/320x270" {/if} alt="" />
    </a>
</li>