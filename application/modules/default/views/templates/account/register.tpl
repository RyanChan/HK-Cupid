<style>
    .form-signup {
        max-width: 350px;
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
    .form-signup .form-signup-heading,
    .form-signup .checkbox {
        margin-bottom: 10px;
    }
    .form-signup input[type="text"],
    .form-signup input[type="password"] {
        /*font-size: 16px;*/
        height: auto;
        width:310px;
        margin-bottom: 15px;
        /*padding: 7px 9px;*/
    }
</style>

<div class="container">
    <form class="form-signup" action="{geturl action="register"}" method="POST">
        <h2 class="form-signup-heading">{translate name="Register to Champs"}</h2>
        <hr />

        {formhash hash=$hash}
        <div class="input-prepend">
            <span class="add-on"><i class="icon-font"></i></span>
            <input type="text" class="span4" name="first_name" placeholder="First Name" />
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-bold"></i></span>
            <input type="text" class="span4" name="last_name" placeholder="Last Name" />
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-envelope"></i></span>
            <input type="text" class="span4" name="email" placeholder="Email Address" />
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-lock"></i></span>
            <input type="password" class="span4" name="password" placeholder="Password" />
        </div>
        {*<label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>*}
        <button class="btn btn-large btn-primary" type="submit">Sign up</button>
    </form>
</div>