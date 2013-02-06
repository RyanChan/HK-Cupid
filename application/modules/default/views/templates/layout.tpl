<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{translate name="Champs"}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- JavaScript -->
        <script src="/ckeditor/ckeditor.js"></script>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="http://twitter.github.com/bootstrap/assets/js/holder/holder.js"></script>
        <script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
        <script src="/js/bootstrap-image-gallery.min.js"></script>
        <script src="/js/cupid.js"></script>

        <!-- Css -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/css/bootstrap-image-gallery.min.css" rel="stylesheet">

        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }

            .sidebar-nav {
                padding: 9px 0;
            }
        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        {include file="header.tpl"}
        <div class="container">
            <noscript>
            <div class="row-fluid">
                <div class="alert alert-error">
                    <i class="iconic-o-x" style="color:#BD362F;"></i>{nbsp nbsp=2}{translate name="Please enable JavaScript"}
                </div>
            </div>
            </noscript>
        </div>
        {$this->layout()->content}

        {include file="footer.tpl"}
    </body>
</html>