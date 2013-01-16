<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{translate name="Champs"}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Css -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
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

        {$this->layout()->content}

        {include file="footer.tpl"}

        <!-- JavaScript -->
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="http://twitter.github.com/bootstrap/assets/js/holder/holder.js"></script>
    </body>
</html>