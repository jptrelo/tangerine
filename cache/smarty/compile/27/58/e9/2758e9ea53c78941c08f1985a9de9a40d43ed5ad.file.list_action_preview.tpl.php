<?php /* Smarty version Smarty-3.1.19, created on 2016-02-16 14:46:29
         compiled from "E:\xampp\htdocs\eCommerceOdonto\4dm0n\themes\default\template\helpers\list\list_action_preview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2882356c37c95628247-03378458%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2758e9ea53c78941c08f1985a9de9a40d43ed5ad' => 
    array (
      0 => 'E:\\xampp\\htdocs\\eCommerceOdonto\\4dm0n\\themes\\default\\template\\helpers\\list\\list_action_preview.tpl',
      1 => 1452117028,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2882356c37c95628247-03378458',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56c37c9562ff48_51795053',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56c37c9562ff48_51795053')) {function content_56c37c9562ff48_51795053($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" target="_blank">
	<i class="icon-eye"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a>
<?php }} ?>
