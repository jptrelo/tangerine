{*
* Maintenance Tools v2.1 (Prestashop 1.6)
* @author kik-off.com <info@kik-off.com>
*}
<!DOCTYPE html>
<html id="{$shop_name|lower|replace:' ':'-'|replace:'-':'.'}" lang="{$lang_iso}">
	<head>
		<title>{$meta_title|escape:'html':'UTF-8'}</title>
		<meta charset="utf-8">
{if isset($meta_description)}
		<meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
{/if}
{if isset($meta_keywords)}
		<meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
{/if}
		<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,follow" />
		<link rel="shortcut icon" href="{$favicon_url}" />
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="{$favicon_url}" />
		<!-- CSS -->
        <link rel='stylesheet' href='{$modules_dir}maintenancetools/css/bootstrap.min.css'>
		<link rel='stylesheet' href='{$modules_dir}maintenancetools/css/style.css'>
		{hook h='displayHeaderMaintenance'}
	</head>
	<body>
	    <div class="container">
        {$HOOK_MAINTENANCE}
		</div>
		{strip}
        {addJsDef baseDir=$content_dir}
        {addJsDef baseUri=$base_uri}
        {if isset($cookie->id_lang)}
	        {addJsDef id_lang=$cookie->id_lang|intval}
        {/if}
        {/strip}
	</body>
</html>
