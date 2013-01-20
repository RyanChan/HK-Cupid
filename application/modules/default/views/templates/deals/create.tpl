<style>
    .form-create-product {
        max-width: 700px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .form-create-product .form-create-product-heading,
    .form-create-product .checkbox {
        margin-bottom: 10px;
    }
    .form-create-product input[type="text"],
    .form-create-product input[type="password"] {
        /*font-size: 16px;*/
        height: auto;
        width:310px;
        margin-bottom: 15px;
        /*padding: 7px 9px;*/
    }
</style>

<div class="container">
    <form class="form-create-product" action="{geturl action="create"}" method="POST">
        {formhash hash=$hash}
        <fieldset>
            <legend>{translate name="Create Product"}</legend>

            <label for="product_title">{translate name="Product Name"}</label>
            <input type="text" name="product_title" id="product_title" value="{$form->product_title|escape}" placeholder="Product Name" />

            <label for="product_status">{translate name="Status"}</label>
            {product_status default=$form->product_status}

            <label for="product_price">{translate name="Price"}</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input class="span2 product-price" name="product_price" id="product_price" type="text" value="{$form->product_price|escape}" placeholder="Product Price" />
                <span class="add-on">.00</span>
            </div>

            <label for="product_quantity">{translate name="Quantity"}</label>
            <div class="input-prepend">
                <span class="add-on"><i class="iconic-box"></i></span>
                <input type="text" id="product_quantity" class="span2" name="product_quantity" value="{$form->product_quantity|escape}" placeholder="Product Quantity" />
            </div>

            <label for="product_payment">{translate name="Payment"}</label>
            {product_payment default=$form->product_payment}

            <label for="product_delivery">{translate name="Delivery"}</label>
            {product_delivery default=$form->product_delivery}

            <label for="product_searchable">{translate name="Searchable"}</label>
            {product_searchable default=$form->product_searchable}

            <label for="product_description">{translate name="Description"}</label>
            <textarea class="ckeditor editor-html" id="product_description" name="product_description">{$form->product_description|escape}</textarea>
        </fieldset>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary pull-right">{translate name="Create Product"}</button>
            <a href="javascript:history.back(1)" class="btn">{translate name="Cancel"}</a>
        </div>
    </form>
</div>