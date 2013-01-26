<li class="span3">
    <div class="thumbnail">
        <img data-src="holder.js/300x200" src="{imagefile id=$album->photos->get(0)->id w=270}" alt="" />
        <div class="caption">
            <h3>
                {$album->title|escape}
            </h3>
            <p>
                <a href="/{$album->user->getProfile('nickname')|escape}/albums/{$album->id|escape}/photos" class="btn btn-primary">{translate name="View"}</a>
                {if $isOwner and !$album->isProfileAlbum}
                    <a href="/{$album->user->getProfile('nickname')|escape}/albums/delete/{$album->id|escape}" class="btn btn-danger">{translate name="Delete"}</a>
                {/if}
            </p>
        </div>
    </div>
</li>