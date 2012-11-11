<?php /* Smarty version Smarty-3.1.12, created on 2012-11-11 12:09:52
         compiled from "/Applications/MAMP/htdocs/Champs/application/modules/default/views/templates/error/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:89730111509f2510629ee3-89806142%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '266a6fd93eb7131f5401933c28726612812ad021' => 
    array (
      0 => '/Applications/MAMP/htdocs/Champs/application/modules/default/views/templates/error/error.tpl',
      1 => 1352012262,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '89730111509f2510629ee3-89806142',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_509f2510685a33_24793761',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_509f2510685a33_24793761')) {function content_509f2510685a33_24793761($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Zend Framework Default Application</title>
</head>
<body>
  <h1>An error occurred</h1>

<h2><?php echo $_smarty_tpl->tpl_vars['this']->value->message;?>
</h2>

  <?php if ($_smarty_tpl->tpl_vars['this']->value->exception){?>
<h3>
  Exception information:
</h3>

<p>
  <b>Message:</b> <?php echo $_smarty_tpl->tpl_vars['this']->value->exception->getMessage();?>

</p>

<h3>
  Stack trace:
</h3>

<pre><?php echo $_smarty_tpl->tpl_vars['this']->value->exception->getTraceAsString();?>

  </pre>

<h3>
  Request Parameters:
</h3>

<pre><?php echo var_export($_smarty_tpl->tpl_vars['this']->value->request->getParams(),true);?>

  </pre>
  <?php }?>
</body>
</html>
<?php }} ?>