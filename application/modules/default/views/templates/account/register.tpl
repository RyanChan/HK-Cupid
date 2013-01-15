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
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
</style>

{$fp->getErrors()|print_r}

<div class="container">
    <form class="form-signup" action="{geturl action="register"}" method="POST">
        <h2 class="form-signup-heading">{translate name="Register to Champs"}</h2>
        {formhash hash=$hash}
        <input type="text" class="input-block-level" name="first_name" placeholder="First Name" />
        <input type="text" class="input-block-level" name="last_name" placeholder="Last Name" />
        <input type="text" class="input-block-level" name="email" placeholder="Email address" />
        <input type="password" class="input-block-level" name="password" placeholder="Password" />
        {*<label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>*}
        <button class="btn btn-large btn-primary" type="submit">Sign up</button>
    </form>
</div>