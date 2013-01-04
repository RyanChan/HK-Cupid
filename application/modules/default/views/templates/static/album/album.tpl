<div class="four columns item element-4" data-categories="">
    <div class="caption">
        <a href="/images/img/thumbs/thumb-1.jpg" {if $action == 'zoom'} rel="prettyPhoto[gallery1]" {/if}>
            <img src="/images/img/thumbs/thumb-1.jpg" alt="" class="pic-fixed-size-161" />
            <span class="hover-effect {$action|escape}"></span>
        </a>
    </div>
    <h4><a href="/{$album->user->getProfile('nickname')|escape}/albums/{$album->id|escape}/photos">{$album->title|escape}</a></h4>
    <p style="word-wrap:break-word;word-break:break-all;">{$album->getProfile('description')|escape|truncate:50:"..."}</p>
</div>