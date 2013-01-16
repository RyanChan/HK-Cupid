<li class="span3">
    <div class="thumbnail">
        <img data-src="holder.js/300x200" alt="" />
        <div class="caption">
            <h3>
                {if $user->getProfile('nickname')}
                    {$user->getProfile('nickname')|escape}
                {else}
                    {$user->getProfile('first_name')|escape} , {$user->getProfile('last_name')|escape}
                {/if}
            </h3>
            <p>
                {if $user->getProfile('intro')}
                    {$user->getProfile('intro')|truncate:150}
                {else}
                    {translate name="No intro"}
                {/if}
            </p>
            <p><a href="{geturl action="user"}/{$user->getProfile('nickname')|escape}" class="btn btn-primary">{translate name="View"}</a></p>
        </div>
    </div>
</li>