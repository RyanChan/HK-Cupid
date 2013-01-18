<li class="span3">
    <div class="thumbnail">
        <img data-src="holder.js/300x200" alt="" />
        <div class="caption">
            <h3>
                {$album->title|escape}
            </h3>
            <p><a href="/{$album->user->getProfile('nickname')|escape}/albums/{$album->id|escape}/photos" class="btn btn-primary">{translate name="View"}</a></p>
        </div>
    </div>
</li>