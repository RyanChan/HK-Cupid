<li class="span3">
    <div class="thumbnail">
        <img src="holder.js/300x200" alt="" />
        <div class="caption">
            <h3>
                {$product->title|escape}
            </h3>
            <p><a href="/{$product->user->getProfile('nickname')|escape}/products/{$product->id|escape}" class="btn btn-primary">{translate name="View"}</a></p>
        </div>
    </div>
</li>