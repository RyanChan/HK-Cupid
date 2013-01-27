<li class="span3">
    <a href="{geturl controller="dating" action="user"}/{$user->username|escape}" class="thumbnail" rel="tooltip" title="{$user->getNickName()|escape}">
        <img src="{imagefile id=$user->getProfileAlbum()->photos->last()->id width=260}" alt="" />
    </a>
</li>