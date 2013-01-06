<div class="four columns item element-4" data-categories="">
    <div class="caption">
        <a href="/images/img/thumbs/thumb-1.jpg" rel="prettyPhoto[gallery1]">
            <img src="/images/img/thumbs/thumb-1.jpg" alt="" class="pic" />
            <span class="hover-effect {$action|escape}"></span>
        </a>
    </div>
    <h4>
        <a href="{geturl action="user"}/{$user->getProfile('nickname')|escape}">
            {if $user->getProfile('nickname')}
                {$user->getProfile('nickname')|escape}
            {else}
                {$user->getProfile('first_name')|escape} , {$user->getProfile('last_name')|escape}
            {/if}
        </a>
    </h4>
    <p>{$user->getProfile('intro')}</p>
</div>