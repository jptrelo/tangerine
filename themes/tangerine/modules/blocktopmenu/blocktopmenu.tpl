{if $MENU != ''}
	<!-- Menu -->
	<div id="block_top_menu" class="sf-contener clearfix col-lg-12">
		<div class="cat-title">{l s="Menu" mod="blocktopmenu"}</div>
		<ul class="sf-menu clearfix menu-content">			
			{$MENU}
			{Hook::exec('displayInsideMenu')}
			{if $MENU_SEARCH}
				<li class="sf-search noBack" style="float:right">
					<a href="#" onclick="return false;"><span>{l s='Buscar' mod='blocktopmenu'}</span></a>
					<ul>
						<li>
							<form id="searchbox" action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" method="get">
								<p>
								<input type="hidden" name="controller" value="search" />
								<input type="hidden" value="position" name="orderby"/>
								<input type="hidden" value="desc" name="orderway"/>
								<input type="text" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|escape:'html':'UTF-8'}{/if}" />
								<button type="submit" name="submit_search" class="btn btn-default button-search">
									<span>{l s='Buscar' mod='blocktopmenu'}</span>
								</button>
								</p>
							</form>
						</li>						
					</ul>
					
				</li>
			{/if}			
		</ul>
	</div>
	<!--/ Menu -->
{/if}