<?php /* Smarty version Smarty-3.1.12, created on 2012-11-10 21:35:42
         compiled from "/Applications/MAMP/htdocs/Champs/application/modules/default/views/templates/index/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1870905317509610f76422e7-98344991%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '623772b6e93dfbacb75a98cf5bbe11e2705b2372' => 
    array (
      0 => '/Applications/MAMP/htdocs/Champs/application/modules/default/views/templates/index/index.tpl',
      1 => 1352554541,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1870905317509610f76422e7-98344991',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_509610f7650701_98641336',
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_509610f7650701_98641336')) {function content_509610f7650701_98641336($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php if (!$_smarty_tpl->tpl_vars['user']->value){?>
        YES
    <?php }else{ ?>
        NO
    <?php }?>
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>