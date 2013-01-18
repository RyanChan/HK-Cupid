<style>
    .form-signin {
        max-width: 300px;
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
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
</style>
<div class="container">
    <form class="form-signin" action="{geturl action="login"}" method="POST">
        <h2 class="form-signin-heading">{translate name="Login to Champs"}</h2>
        {formhash hash=$hash}
        <input type="text" class="input-block-level" name="username" placeholder="Username">
        <input type="password" class="input-block-level" name="password" placeholder="Password">
        {*<label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>*}
        <button class="btn btn-large btn-primary pull-right" type="submit">{translate name="Sign in"}</button>
        <a href="{geturl action="register"}" class="btn btn-large">{translate name="Register"}</a>
    </form>
</div>