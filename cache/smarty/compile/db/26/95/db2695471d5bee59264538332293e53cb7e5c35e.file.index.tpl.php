<?php /* Smarty version Smarty-3.1.19, created on 2016-03-30 01:27:28
         compiled from "E:\xampp\htdocs\eCommerceOdonto\themes\tangerine\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2389256fb71d008fda6-34266068%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db2695471d5bee59264538332293e53cb7e5c35e' => 
    array (
      0 => 'E:\\xampp\\htdocs\\eCommerceOdonto\\themes\\tangerine\\index.tpl',
      1 => 1459298407,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2389256fb71d008fda6-34266068',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_HOME_TAB_CONTENT' => 0,
    'HOOK_HOME_TAB' => 0,
    'HOOK_HOME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56fb71d00a74a9_41806259',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fb71d00a74a9_41806259')) {function content_56fb71d00a74a9_41806259($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value)) {?>
       <ul id="home-page-tabs" class="nav nav-tabs clearfix">
       	<?php echo $_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value;?>

       </ul>
	<?php }?>
	<div class="tab-content"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value;?>
</div>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME']->value)) {?>
	<div class="clearfix"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>
</div>
<?php }?><?php }} ?>
