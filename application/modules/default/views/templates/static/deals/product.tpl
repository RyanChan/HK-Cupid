<div class="one-third column item element-3" data-categories="">
    <div class="caption">
        <a href="/images/img/thumbs/thumb-1.jpg" {if $action == 'zoom'} rel="prettyPhoto[gallery1]" {/if}>
            <img src="/images/img/thumbs/thumb-1.jpg" alt="" class="pic-fixed-size-219" />
            <span class="hover-effect {$action|escape}"></span>
        </a>
    </div>
    <h4><a href="/{$identity->nickname|escape}/product/{$product->id|escape}">{$product->title|escape}</a></h4>
</div>