<?php /* Smarty version Smarty-3.1.12, created on 2012-11-11 12:09:52
         compiled from "/Applications/MAMP/htdocs/Champs/application/modules/default/views/templates/static/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1350108302509f25106984e5-65683405%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7c25241b7eec5ed2025ed5298843d2612bc2c4f' => 
    array (
      0 => '/Applications/MAMP/htdocs/Champs/application/modules/default/views/templates/static/footer.tpl',
      1 => 1352606923,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1350108302509f25106984e5-65683405',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_509f251069b864_00119113',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_509f251069b864_00119113')) {function content_509f251069b864_00119113($_smarty_tpl) {?><footer>
    <div class="container">

      <div class="four columns">
        <div class="about">
          <h3 class="title">About Us<span class="line"></span></h3>
          <p>
          Consectetur adipiscing elit aeneane lorem lipsum, condimentum ultrices consequat eu, vehicula mauris lipsum adipiscing
          lipsum aenean orci lorem Asequat. <br /> lorem ipsum dolor lorem sit amet, consectetur adipiscing dolor .
          </p>
        </div>
      </div><!-- End about -->

      <div class="four columns">
        <div class="tweets">
          <h3 class="title">Latest tweets<span class="line"></span></h3>
            <div class='tweet query footer'></div><!-- Tweets Code -->
        </div>
      </div><!-- End tweets -->

      <div class="four columns">
        <div class="flickr">
          <h3 class="title">Flickr<span class="line"></span></h3>
          <ul id="footer" class="thumbs"></ul> <!-- Flickr Code -->
        </div>
      </div><!-- End flickr -->

      <div class="four columns">
        <div class="subscribe">
          <h3 class="title">Subcribe<span class="line"></span></h3>
          <p>Subscribe to our e-mail newsletter to receive updates.</p>
          <form action="#">
            <input type="text" class="mail" value="Enter your Email" onBlur="if(this.value == '') { this.value = 'Enter your Email'; }"
            onfocus="if(this.value == 'Enter your Email') { this.value = ''; }"/>
            <input type="submit" value="Submit" class="submit" />
          </form>
        </div>
      </div><!-- End subscribe -->

      <div class="sixteen columns"><hr class="bottom" /></div>

      <div class="eight columns"><span class="copyright">
      ¬© Copyright 2012 <a href="index.html">Crevision</a>. All Rights Reserved. by
      <a href="http://jozoor.com/" target="_blank" data="Jozoor Team">jozoor</a></span></div>

      <div class="eight columns">
        <div class="social">
          <a href="#"><img src="/images/icons/twitter.png" alt="" /></a>
          <a href="#"><img src="/images/icons/facebook.png" alt="" /></a>
          <a href="#"><img src="/images/icons/skype.png" alt="" /></a>
          <a href="#"><img src="/images/icons/digg.png" alt="" /></a>
          <a href="#"><img src="/images/icons/linkedin.png" alt="" /></a>
          <a href="#"><img src="/images/icons/vimeo.png" alt="" /></a>
        </div>
      </div>

    </div><!-- End container -->
  </footer><!-- <<< End Footer >>> --><?php }} ?>