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
        <script src="/js/cupid.js"></script>

        <!-- Css -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/css/bootstrap-responsive.css" rel="stylesheet">

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
        <div id="notice" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="noticeLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="noticeLabel">{translate name="注意"}</h3>
            </div>
            <div class="modal-body">
                <p>正在測試階段，網站可能間中暫停。</p>
                <p>
                    正局部開放網站功能
                </p>
                <p><a href="{geturl controller="dating"}" class="btn btn-primary">交友&nbsp;<i class="iconic-o-check"></i></a></p>
                <p><a href="{geturl controller="album"}" class="btn btn-primary">相簿&nbsp;<i class="iconic-o-check"></i></a></p>
                <p><a href="#" class="btn btn-danger">買賣&nbsp;<i class="iconic-o-x"></i></a></p>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>

        {include file="header.tpl"}

        {$this->layout()->content}

        {include file="footer.tpl"}
    </body>
</html>