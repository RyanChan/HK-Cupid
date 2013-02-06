<li class="span3">
    <div class="thumbnail">
        <img src="{imagefile id=$user->getProfileAlbum()->photos->last()->id h=200}" alt="" />
        <div class="caption">
            <h3>
                {if $user->getProfile('nickname')}
                    {$user->getProfile('nickname')|escape|truncate:10:"..."}
                {else}
                    {$user->getProfile('first_name')|escape} , {$user->getProfile('last_name')|escape}
                {/if}
            </h3>
            <p>
                <a href="{geturl action="user"}/{$user->username|escape}" class="btn btn-primary">{translate name="View"}</a>
            </p>
        </div>
    </div>
</li>