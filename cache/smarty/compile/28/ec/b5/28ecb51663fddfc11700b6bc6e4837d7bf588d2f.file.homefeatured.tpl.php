<?php /* Smarty version Smarty-3.1.19, created on 2016-02-16 17:09:26
         compiled from "E:\xampp\htdocs\eCommerceOdonto\themes\default-bootstrap\modules\homefeatured\homefeatured.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2318156c349b6c7dd33-26063165%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28ecb51663fddfc11700b6bc6e4837d7bf588d2f' => 
    array (
      0 => 'E:\\xampp\\htdocs\\eCommerceOdonto\\themes\\default-bootstrap\\modules\\homefeatured\\homefeatured.tpl',
      1 => 1452117028,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2318156c349b6c7dd33-26063165',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56c349b6c95437_82844528',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56c349b6c95437_82844528')) {function content_56c349b6c95437_82844528($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class'=>'homefeatured tab-pane','id'=>'homefeatured'), 0);?>

<?php } else { ?>
<ul id="homefeatured" class="homefeatured tab-pane">
	<li class="alert alert-info"><?php echo smartyTranslate(array('s'=>'No featured products at this time.','mod'=>'homefeatured'),$_smarty_tpl);?>
</li>
</ul>
<?php }?><?php }} ?>