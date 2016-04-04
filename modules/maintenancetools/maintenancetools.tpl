{*
* Maintenance Tools v2.0 (Prestashop 1.6)
* @author kik-off.com <info@kik-off.com>
*}
<!-- Header -->
    <div class="header row">
        <div class="logo col-md-4">
            <h1>
			    <a href="{$base_dir}" title="{$shop_name|escape:'html':'UTF-8'}">
				    <img class="logo img-responsive" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"{if $logo_image_width} width="{$logo_image_width}"{/if}{if $logo_image_height} height="{$logo_image_height}"{/if}/>
			    </a>
		    </h1>
        </div>
        <div class="call-us col-md-8">
            <p>{if isset($shop_phone) && $shop_phone}{l s='Tel' mod='maintenancetools'}: <span>{$shop_phone}</span>{/if}{if isset($shop_phone) && $shop_phone && isset($shop_email) && $shop_email} | {/if}{if isset($shop_email) && $shop_email}{l s='E-mail' mod='maintenancetools'}: <span>{$shop_email}</span>{/if}</p>
            </div>
        </div>
    </div>
<!-- Content -->
    <div class="coming-soon">
        <div class="inner-bg">
            <div class="container">
                <div class="row">
                    <h2>{$maintenance.title|escape:'html':'UTF-8'}</h2>
                    <div class="content">{$maintenance.content}</div>
					{if $mt['PS_MAINTENANCE_COUNT'] == 1 && $date > $smarty.now|date_format:'%Y/%m/%d %H:%M:%S'}
                    <div class="timer">
                        <div class="days-wrapper">
                            <span class="days"></span> <br>{l s='days' mod='maintenancetools'}
                        </div>
                        <div class="hours-wrapper">
                            <span class="hours"></span> <br>{l s='hours' mod='maintenancetools'}
                        </div>
                        <div class="minutes-wrapper">
                            <span class="minutes"></span> <br>{l s='minutes' mod='maintenancetools'}
                        </div>
                        <div class="seconds-wrapper">
                            <span class="seconds"></span> <br>{l s='seconds' mod='maintenancetools'}
                        </div>
                    </div>
				    {/if}
                </div>
            </div>
        </div>
    </div>
<!-- Newsletter -->
{if Module::isEnabled('blocknewsletter') && $mt['PS_MAINTENANCE_NEWS'] == 1}
    <div class="container">
        <div class="row">
            <div class="span12 subscribe">
                <h3>{l s='Subscribe to our newsletter' mod='maintenancetools'}</h3>
                <p>{l s='Stay tuned for news and updates.' mod='maintenancetools'}</p>
                <form id="newsletter-form" class="form-inline" action="{$link->getPageLink('index.php')}" method="post">
                    {assign var=unique_id value=sha1(md5(time()))}
					<input type="text" name="email" placeholder="{l s='Enter your email...' mod='maintenancetools'}" />
					<input type="text" id="url-{$unique_id}" size="20" autocomplete="off" class="hidden" name="url" />
					<input name="action" type="hidden" value="0" />
					<input name="submitNewsletter" type="hidden" value="1" />
                    <button type="submit" class="btn btn-default submit">{l s='Subscribe' mod='maintenancetools'}</button>
					{if $mt['PS_MAINTENANCE_NEWS_C'] == 1 && $mt['PS_MAINTENANCE_NEWS_C_ID'] > 0}
					<p><input type="checkbox" id="check-conditions" name="conditions" /> <label for="check-conditions">{l s='I read and accept them' mod='maintenancetools'}</label>
					    <button id="conditions" rel="nofollow" rel="tooltip" data-placement="bottom" data-original-title="{l s='Newsletter conditions' mod='maintenancetools'}" type="button" class="btn-link">{l s='conditions' mod='maintenancetools'}.</button>
					</p>
					{/if}
                </form>
				{if $mt['PS_MAINTENANCE_NEWS_C'] == 1 && $mt['PS_MAINTENANCE_NEWS_C_ID'] > 0}
		            <div id="newsletter-condition" class="modal fade" tabindex="-1" aria-hidden="true" role="dialog">
		                <div class="modal-dialog modal-lg">
    		                <div class="modal-content">
      		                    <div class="modal-header">
        		                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#newsletter-condition').modal('hide')">&times;</button>
        		                    <h4 class="modal-title">{$conditions.title|escape:'html':'UTF-8'}</h4>
      		                    </div>
      		                    <div class="modal-body">{$conditions.content}</div>
								<div class="modal-footer">
                                    <button type="button" class="btn btn-default modal-close" data-dismiss="modal" onclick="$('#newsletter-condition').modal('hide')">{l s='Close' mod='maintenancetools'}</button>
                                </div>
                            </div>
                        </div>
                    </div>
					<script type="text/javascript">
					    $('#conditions').on('click', function (e) {
                            $('#newsletter-condition').modal({
							    backdrop: false
							});
                        });
					</script>
				{/if}
		    </div>
			{if isset($msg) && $msg}
		    <div class="subscribe-msg"><p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">{$msg}</p></div>
	        {/if}
        </div>
    </div>
{/if}
<!-- Socials -->
{if $mt['PS_MAINTENANCE_FB'] == 1 ||
    $mt['PS_MAINTENANCE_TW'] == 1 ||
	$mt['PS_MAINTENANCE_GO'] == 1 ||
	$mt['PS_MAINTENANCE_PIN'] == 1 ||
	$mt['PS_MAINTENANCE_YT'] == 1 ||
	$mt['PS_MAINTENANCE_VIM'] == 1 ||
	$mt['PS_MAINTENANCE_INST'] == 1 ||
	$mt['PS_MAINTENANCE_FLICKR'] == 1 ||
	$mt['PS_MAINTENANCE_GT'] == 1}
<div class="container">
    <div class="row">
        <div class="span12 social">
            {if $mt['PS_MAINTENANCE_FB'] == 1}
			<a href="{$mt['PS_MAINTENANCE_FB_URL']}" class="facebook" rel="tooltip" data-placement="top" data-original-title="Facebook" target="_blank"></a>
			{/if}
            {if $mt['PS_MAINTENANCE_TW'] == 1}
			<a href="{$mt['PS_MAINTENANCE_TW_URL']}" class="twitter" rel="tooltip" data-placement="top" data-original-title="Twitter" target="_blank"></a>
			{/if}
			{if $mt['PS_MAINTENANCE_GO'] == 1}
            <a href="{$mt['PS_MAINTENANCE_GO_URL']}" class="googleplus" rel="tooltip" data-placement="top" data-original-title="Google Plus" target="_blank"></a>
			{/if}
			{if $mt['PS_MAINTENANCE_FLICKR'] == 1}
            <a href="{$mt['PS_MAINTENANCE_FLICKR_URL']}" class="flickr" rel="tooltip" data-placement="top" data-original-title="Flickr" target="_blank"></a>
			{/if}
			{if $mt['PS_MAINTENANCE_INST'] == 1}
            <a href="{$mt['PS_MAINTENANCE_INST_URL']}" class="instagram" rel="tooltip" data-placement="top" data-original-title="Instagram" target="_blank"></a>
			{/if}
			{if $mt['PS_MAINTENANCE_PIN'] == 1}
            <a href="{$mt['PS_MAINTENANCE_PIN_URL']}" class="pinterest" rel="tooltip" data-placement="top" data-original-title="Pinterest" target="_blank"></a>
			{/if}
			{if $mt['PS_MAINTENANCE_YT'] == 1}
            <a href="{$mt['PS_MAINTENANCE_YT_URL']}" class="youtube" rel="tooltip" data-placement="top" data-original-title="Youtube" target="_blank"></a>
			{/if}
			{if $mt['PS_MAINTENANCE_VIM'] == 1}
            <a href="{$mt['PS_MAINTENANCE_VIM_URL']}" class="vimeo" rel="tooltip" data-placement="top" data-original-title="Vimeo" target="_blank"></a>
			{/if}
			{if $mt['PS_MAINTENANCE_GT'] == 1}
            <a href="{$mt['PS_MAINTENANCE_GT_URL']}" class="github" rel="tooltip" data-placement="top" data-original-title="Github" target="_blank"></a>
			{/if}
        </div>
    </div>
</div>
{/if}
<!-- Languages -->
{if count($languages) > 1}
	<div class="languages container">
		{foreach from=$languages key=k item=language name="languages"}
			<div class="language{if $language.iso_code == $lang_iso} selected_language{/if}">
			{if $language.iso_code != $lang_iso}
				{assign var=indice_lang value=$language.id_lang}
				{if isset($lang_rewrite_urls.$indice_lang)}
					<a href="{$lang_rewrite_urls.$indice_lang|escape:htmlall}" title="{$language.name}" rel="tooltip" data-placement="top" data-original-title="{$language.name}">
				{else}
					<a href="{$link->getLanguageLink($language.id_lang)|escape:htmlall}" title="{$language.name}" rel="tooltip" data-placement="top" data-original-title="{$language.name}">
				{/if}
			{/if}
			{$language.iso_code|upper}
			{if $language.iso_code != $lang_iso}
				</a>
			{/if}
			</div>
		{/foreach}
	</div>
{/if}
<!-- Imprint -->
{if isset($maintenance.imprint) && $maintenance.imprint}
    <div class="container">
	    <p class="imprint">{$maintenance.imprint|escape:'html':'UTF-8'}</p>
    </div>
{/if}