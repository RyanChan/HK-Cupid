<li class="span3">
    <a href="/{$user->getProfile('nickname')|escape}/albums/{$album->id}/photos" class="thumbnail">
        <img src="{imagefile id=$album->photos->get(0)->id w=270}" alt="" />
    </a>
</li>