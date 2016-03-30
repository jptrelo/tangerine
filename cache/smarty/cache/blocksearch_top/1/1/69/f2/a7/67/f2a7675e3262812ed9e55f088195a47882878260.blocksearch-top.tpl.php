<?php /*%%SmartyHeaderCode:3117156f8ba83ead7e7-73354062%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2a7675e3262812ed9e55f088195a47882878260' => 
    array (
      0 => 'E:\\xampp\\htdocs\\eCommerceOdonto\\themes\\tangerine\\modules\\blocksearch\\blocksearch-top.tpl',
      1 => 1459140719,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3117156f8ba83ead7e7-73354062',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56fb2ba3c940c6_00017985',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56fb2ba3c940c6_00017985')) {function content_56fb2ba3c940c6_00017985($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top" class="col-sm-4 clearfix">
	<form id="searchbox" method="get" action="//localhost/eCommerceOdonto/buscar" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Buscar" value="" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span>Buscar</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }} ?>
