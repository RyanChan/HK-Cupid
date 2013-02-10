<li class="span3">
    <a href="{geturl controller="dating" action="user"}/{$user->username|escape}" class="thumbnail" rel="tooltip" title="{$user->getNickName()|escape}">
        <img src="{imagefile id=$user->getProfileAlbum()->photos->last()->id w=200}" alt="" />
    </a>
</li>