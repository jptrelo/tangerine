<?php /* Smarty version Smarty-3.1.19, created on 2016-03-28 00:00:53
         compiled from "E:\xampp\htdocs\eCommerceOdonto\themes\tangerine\modules\homefeatured\homefeatured.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2844756f8ba8583d692-38389177%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27a332d85de0c13ee0eb0b062f5c6987197af638' => 
    array (
      0 => 'E:\\xampp\\htdocs\\eCommerceOdonto\\themes\\tangerine\\modules\\homefeatured\\homefeatured.tpl',
      1 => 1459140719,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2844756f8ba8583d692-38389177',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56f8ba8584d095_99496290',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f8ba8584d095_99496290')) {function content_56f8ba8584d095_99496290($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('class'=>'homefeatured tab-pane','id'=>'homefeatured'), 0);?>

<?php } else { ?>
<ul id="homefeatured" class="homefeatured tab-pane">
	<li class="alert alert-info"><?php echo smartyTranslate(array('s'=>'No featured products at this time.','mod'=>'homefeatured'),$_smarty_tpl);?>
</li>
</ul>
<?php }?><?php }} ?>
