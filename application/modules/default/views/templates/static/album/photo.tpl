<div class="four columns item element-4" data-categories="">
    <div class="caption">
        <a href="{imagefile id=$photo->id}" {if $action == 'zoom'} rel="prettyPhoto[gallery1]" {/if}>
            <img src="{imagefile id=$photo->id h=161}" alt="" class="pic-fixed-size-161" />
            <span class="hover-effect {$action|escape}"></span>
        </a>
    </div>
    <p style="word-wrap:break-word;word-break:break-all;">{$photo->description|escape|truncate:50:"..."}</p>
</div>