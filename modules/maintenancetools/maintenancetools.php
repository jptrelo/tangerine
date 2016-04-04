<?php
/*
* Maintenance Tools v2.1 (Prestashop 1.6)
* @author kik-off.com <info@kik-off.com>
*/

if (!defined('_PS_VERSION_'))
    exit;

include_once _PS_MODULE_DIR_.'maintenancetools/maintenancetoolsClass.php';

class maintenancetools extends Module
{
	protected $html;

	public $_html;

	const GUEST_NOT_REGISTERED = -1;
	const CUSTOMER_NOT_REGISTERED = 0;
	const GUEST_REGISTERED = 1;
	const CUSTOMER_REGISTERED = 2;

	public function __construct()
    {
        $this->name = 'maintenancetools';
        $this->tab = 'administration';
        $this->version = '2.1';
        $this->author = 'kik-off.com';
		$this->need_instance = 1;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Maintenance Tools');
        $this->description = $this->l('Custom offline message, Countdown, Newsletter Form and Social Links in Maintenance Page.');

		$this->error = false;
		$this->valid = false;
    }

	public function install()
	{
		$variables = array(0, '0000-00-00 00:00:00', 0, 0, 0,
		    'https://www.facebook.com', 0,
			'https://www.twitter.com', 0,
			'https://plus.google.com',  0,
			'https://www.youtube.com', 0,
			'https://www.pinterest.com',  0,
			'https://www.vimeo.com', 0,
			'https://www.flickr.com', 0,
			'http://instagram.com', 0,
			'https://github.com/', 0
		);

		return parent::install() &&
			$this->installDB() &&
			$this->installFixtures() &&
			$this->_moveTemplate() &&
			Configuration::updateValue('PS_MAINTENANCE_TOOLS', serialize($variables)) &&
			$this->registerHook('displayHeaderMaintenance') &&
			$this->registerHook('displayMaintenance');
	}

	public function installDB()
	{
		$return = true;
		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'maintenancetools` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(11) NOT NULL DEFAULT 1,
				`file_name_1` varchar(100) NOT NULL,
				`file_name_2` varchar(100) NOT NULL,
				`file_name_3` varchar(100) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'maintenancetools_lang` (
				`id` int(10) unsigned NOT NULL,
				`id_shop` int(11) NOT NULL DEFAULT 1,
				`id_lang` int(10) UNSIGNED NOT NULL,
				`title` varchar(300) NOT NULL,
				`content` text,
				`imprint` varchar(255) NOT NULL,
				PRIMARY KEY (`id`, `id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		return $return;
	}

	public function installFixtures()
	{
		$return = true;

		$id_shop = (int)Context::getContext()->shop->id;
		$maintenance = new maintenancetoolsClass();

		foreach (Language::getLanguages(false) as $lang)
		{
			$maintenance->title[$lang['id_lang']] = 'Under maintenance';
			$maintenance->content[$lang['id_lang']] = '<p>In order to perform website maintenance, our online store will be temporarily offline.</p>
			    <p>We apologize for the inconvenience and ask that you please try again later.</p>';
			$maintenance->imprint[$lang['id_lang']] = 'Copyright. All Right Reserved';
		}

        $maintenance->file_name_1 = 'background-1-1.jpg';
		$maintenance->file_name_2 = 'background-2-1.jpg';
		$maintenance->file_name_3 = 'background-3-1.jpg';
		$maintenance->id_shop = $id_shop;
		$return &= $maintenance->save();

		return $return;
	}

	public function _moveTemplate()
	{
		chmod(_PS_THEME_DIR_, 0777);
		if(file_exists(_PS_THEME_DIR_.'maintenance.tpl'))
		{
			rename(_PS_THEME_DIR_.'maintenance.tpl', _PS_THEME_DIR_.'maintenance_OLD_MAINTENANCE_TPL.tpl');
		}
		copy(_PS_MODULE_DIR_.'maintenancetools/theme/maintenance.tpl', _PS_THEME_DIR_.'maintenance.tpl');
		chmod(_PS_THEME_DIR_, 0755);
		return true;
	}

	public function uninstall()
	{
		$this->_removeTemplate();
		return Configuration::deleteByName('PS_MAINTENANCE_TOOLS') &&
			$this->uninstallDB() &&
			parent::uninstall();
	}

	public function _removeTemplate()
	{
		if(file_exists(_PS_THEME_DIR_.'maintenance_OLD_MAINTENANCE_TPL.tpl'))
		{
			chmod(_PS_THEME_DIR_, 0777);
			unlink(_PS_THEME_DIR_.'maintenance.tpl');
			rename(_PS_THEME_DIR_.'maintenance_OLD_MAINTENANCE_TPL.tpl', _PS_THEME_DIR_.'maintenance.tpl');
			chmod(_PS_THEME_DIR_, 0755);
		    return true;
		}
	}

	public function uninstallDB()
	{
		return Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'maintenancetools`') &&
		    Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'maintenancetools_lang`');
	}

	private function _getVariables()
	{
	    $getConfig = unserialize(Configuration::get('PS_MAINTENANCE_TOOLS'));

		$maintenance = array();
		$maintenance['PS_MAINTENANCE_COUNT'] = $getConfig[0];
		$maintenance['PS_MAINTENANCE_DATE'] = $getConfig[1];
		$maintenance['PS_MAINTENANCE_NEWS'] = $getConfig[2];
		$maintenance['PS_MAINTENANCE_NEWS_C_ID'] = $getConfig[3];
		$maintenance['PS_MAINTENANCE_NEWS_C'] = $getConfig[4];
		$maintenance['PS_MAINTENANCE_FB_URL'] = $getConfig[5];
		$maintenance['PS_MAINTENANCE_FB'] = $getConfig[6];
		$maintenance['PS_MAINTENANCE_TW_URL'] = $getConfig[7];
		$maintenance['PS_MAINTENANCE_TW'] = $getConfig[8];
		$maintenance['PS_MAINTENANCE_GO_URL'] = $getConfig[9];
		$maintenance['PS_MAINTENANCE_GO'] = $getConfig[10];
		$maintenance['PS_MAINTENANCE_YT_URL'] = $getConfig[11];
		$maintenance['PS_MAINTENANCE_YT'] = $getConfig[12];
		$maintenance['PS_MAINTENANCE_PIN_URL'] = $getConfig[13];
		$maintenance['PS_MAINTENANCE_PIN'] = $getConfig[14];
		$maintenance['PS_MAINTENANCE_VIM_URL'] = $getConfig[15];
		$maintenance['PS_MAINTENANCE_VIM'] = $getConfig[16];
		$maintenance['PS_MAINTENANCE_FLICKR_URL'] = $getConfig[17];
		$maintenance['PS_MAINTENANCE_FLICKR'] = $getConfig[18];
		$maintenance['PS_MAINTENANCE_INST_URL'] = $getConfig[19];
		$maintenance['PS_MAINTENANCE_INST'] = $getConfig[20];
		$maintenance['PS_MAINTENANCE_GT_URL'] = $getConfig[21];
		$maintenance['PS_MAINTENANCE_GT'] = $getConfig[22];

	    return $maintenance;
	}

    public function getContent()
	{
		$html = '';

		if (Tools::isSubmit('saveMaintenanceTools'))
		{
			$id_shop = Tools::getValue('id_shop');
			$maintenancetools = new maintenancetoolsClass($id_shop);
			$maintenancetools->copyFromPost();

			if ($maintenancetools->validateFields(false) && $maintenancetools->validateFieldsLang(false))
			{
				$maintenancetools->save();
				if (isset($_FILES['image_1']) && isset($_FILES['image_1']['tmp_name']) && !empty($_FILES['image_1']['tmp_name']))
				{
					if ($error = ImageManager::validateUpload($_FILES['image_1']))
						return false;
					elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['image_1']['tmp_name'], $tmpName))
						return false;
					elseif (!ImageManager::resize($tmpName, dirname(__FILE__).'/img/backgrounds/background-1-'.(int)$maintenancetools->id_shop.'.jpg'))
						return false;
					unlink($tmpName);
					$maintenancetools->file_name_1 = 'background-1-'.(int)$maintenancetools->id_shop.'.jpg';
					$maintenancetools->save();
				}
				if (isset($_FILES['image_2']) && isset($_FILES['image_2']['tmp_name']) && !empty($_FILES['image_2']['tmp_name']))
				{
					if ($error = ImageManager::validateUpload($_FILES['image_2']))
						return false;
					elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['image_2']['tmp_name'], $tmpName))
						return false;
					elseif (!ImageManager::resize($tmpName, dirname(__FILE__).'/img/backgrounds/background-2-'.(int)$maintenancetools->id_shop.'.jpg'))
						return false;
					unlink($tmpName);
					$maintenancetools->file_name_2 = 'background-2-'.(int)$maintenancetools->id_shop.'.jpg';
					$maintenancetools->save();
				}
				if (isset($_FILES['image_3']) && isset($_FILES['image_3']['tmp_name']) && !empty($_FILES['image_3']['tmp_name']))
				{
					if ($error = ImageManager::validateUpload($_FILES['image_3']))
						return false;
					elseif (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) || !move_uploaded_file($_FILES['image_3']['tmp_name'], $tmpName))
						return false;
					elseif (!ImageManager::resize($tmpName, dirname(__FILE__).'/img/backgrounds/background-3-'.(int)$maintenancetools->id_shop.'.jpg'))
						return false;
					unlink($tmpName);
					$maintenancetools->file_name_3 = 'background-3-'.(int)$maintenancetools->id_shop.'.jpg';
					$maintenancetools->save();
				}

				$html .= $this->displayConfirmation($this->l('The settings have been updated successfully.'));
			}
			else
				$html .= $this->displayError($this->l('An error occurred while attempting to save.'));
		}
		if (Tools::isSubmit('saveConfigMaintenanceTools'))
		{
			if (!Module::isEnabled('blocknewsletter'))
			    $PS_MAINTENANCE_NEWS = 0;
			$PS_MAINTENANCE_NEWS = (int)Tools::getValue('PS_MAINTENANCE_NEWS');

			$variables = array(
			    (int)Tools::getValue('PS_MAINTENANCE_COUNT'),
				Tools::getValue('PS_MAINTENANCE_DATE'),
				$PS_MAINTENANCE_NEWS,
				(int)Tools::getValue('PS_MAINTENANCE_NEWS_C_ID'),
				(int)Tools::getValue('PS_MAINTENANCE_NEWS_C'),
				Tools::getValue('PS_MAINTENANCE_FB_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_FB'),
				Tools::getValue('PS_MAINTENANCE_TW_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_TW'),
				Tools::getValue('PS_MAINTENANCE_GO_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_GO'),
				Tools::getValue('PS_MAINTENANCE_YT_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_YT'),
				Tools::getValue('PS_MAINTENANCE_PIN_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_PIN'),
				Tools::getValue('PS_MAINTENANCE_VIM_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_VIM'),
				Tools::getValue('PS_MAINTENANCE_FLICKR_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_FLICKR'),
				Tools::getValue('PS_MAINTENANCE_INST_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_INST'),
				Tools::getValue('PS_MAINTENANCE_GT_URL'),
				(int)Tools::getValue('PS_MAINTENANCE_GT')
			);
			Configuration::updateValue('PS_MAINTENANCE_TOOLS', serialize($variables));
			$html .= $this->displayConfirmation($this->l('The settings have been updated successfully.'));
		}

		$html .= '
		<style type="text/css">
		    #imprint{width: 100%; text-align: right;}
            #imprint-logo {float: left;}
		</style>';

		$id_shop = $this->context->shop->id;
		$maintenance = new maintenancetoolsClass($id_shop);

		$helper = $this->initForm();
		foreach (Language::getLanguages(false) as $lang) {
			$helper->fields_value['title'][(int)$lang['id_lang']] = $maintenance->title[(int)$lang['id_lang']];
			$helper->fields_value['content'][(int)$lang['id_lang']] = $maintenance->content[(int)$lang['id_lang']];
			$helper->fields_value['imprint'][(int)$lang['id_lang']] = $maintenance->imprint[(int)$lang['id_lang']];
		}

		$this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_shop');
		$helper->fields_value['id_shop'] = (int)$id_shop;
		$html .= $helper->generateForm($this->fields_form);

		$helper = $this->initConfigForm();
		$mt = $this->_getVariables();
		$helper->fields_value['PS_MAINTENANCE_COUNT'] = $mt['PS_MAINTENANCE_COUNT'];
		$helper->fields_value['PS_MAINTENANCE_DATE'] = $mt['PS_MAINTENANCE_DATE'];
		$helper->fields_value['PS_MAINTENANCE_NEWS'] = $mt['PS_MAINTENANCE_NEWS'];
		$helper->fields_value['PS_MAINTENANCE_NEWS_C_ID'] = $mt['PS_MAINTENANCE_NEWS_C_ID'];
		$helper->fields_value['PS_MAINTENANCE_NEWS_C'] = $mt['PS_MAINTENANCE_NEWS_C'];
		$helper->fields_value['PS_MAINTENANCE_FB_URL'] = $mt['PS_MAINTENANCE_FB_URL'];
		$helper->fields_value['PS_MAINTENANCE_FB'] = $mt['PS_MAINTENANCE_FB'];
		$helper->fields_value['PS_MAINTENANCE_TW_URL'] = $mt['PS_MAINTENANCE_TW_URL'];
		$helper->fields_value['PS_MAINTENANCE_TW'] = $mt['PS_MAINTENANCE_TW'];
		$helper->fields_value['PS_MAINTENANCE_GO_URL'] = $mt['PS_MAINTENANCE_GO_URL'];
		$helper->fields_value['PS_MAINTENANCE_GO'] = $mt['PS_MAINTENANCE_GO'];
		$helper->fields_value['PS_MAINTENANCE_YT_URL'] = $mt['PS_MAINTENANCE_YT_URL'];
		$helper->fields_value['PS_MAINTENANCE_YT'] = $mt['PS_MAINTENANCE_YT'];
		$helper->fields_value['PS_MAINTENANCE_PIN_URL'] = $mt['PS_MAINTENANCE_PIN_URL'];
		$helper->fields_value['PS_MAINTENANCE_PIN'] = $mt['PS_MAINTENANCE_PIN'];
		$helper->fields_value['PS_MAINTENANCE_VIM_URL'] = $mt['PS_MAINTENANCE_VIM_URL'];
		$helper->fields_value['PS_MAINTENANCE_VIM'] = $mt['PS_MAINTENANCE_VIM'];
		$helper->fields_value['PS_MAINTENANCE_FLICKR_URL'] = $mt['PS_MAINTENANCE_FLICKR_URL'];
		$helper->fields_value['PS_MAINTENANCE_FLICKR'] = $mt['PS_MAINTENANCE_FLICKR'];
		$helper->fields_value['PS_MAINTENANCE_INST_URL'] = $mt['PS_MAINTENANCE_INST_URL'];
		$helper->fields_value['PS_MAINTENANCE_INST'] = $mt['PS_MAINTENANCE_INST'];
		$helper->fields_value['PS_MAINTENANCE_GT_URL'] = $mt['PS_MAINTENANCE_GT_URL'];
		$helper->fields_value['PS_MAINTENANCE_GT'] = $mt['PS_MAINTENANCE_GT'];

	    $html .= $helper->generateForm($this->fields_form);

		$html .= '
		<div id="imprint">
		    <fieldset class="panel">
			    <span id="imprint-logo"><a href="http://kik-off.com" target="_blank" title="http://kik-off.com"><img src="'.$this->_path.'img/logo_kik_off.gif" alt="" /></a> '.$this->displayName.' v'.$this->version.'</span>
			    <span id="imprint-text">'.$this->l('Module by').': <a href="http://kik-off.com" target="_blank" title="http://kik-off.com">kik-off.com</a>, <a href="mailto:support@kik-off.com">support@kik-off.com</a></span>
			</fieldset>
		</div>';

		return $html;
	}

	protected function initForm()
	{
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		$id_shop = $this->context->shop->id;
		$random_number = rand(1, 10000);

		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('Maintenance Tools'),
				'icon' => 'icon-cogs'
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Title'),
					'lang' => true,
					'name' => 'title',
					'size' => 100
				),
				array(
					'type' => 'file',
					'label' => $this->l('Background 1'),
					'name' => 'image_1',
					'desc' => '<img src="../modules/maintenancetools/img/backgrounds/background-1-'.$id_shop.'.jpg?ranimg='.$random_number.'" style="width: 82px; height: 50px;" />
					    <br/>'. $this->l('Recommended size').' 593x362.',
					'value' => true
				),
				array(
					'type' => 'file',
					'label' => $this->l('Background 2'),
					'name' => 'image_2',
					'desc' => '<img src="../modules/maintenancetools/img/backgrounds/background-2-'.$id_shop.'.jpg?ranimg='.$random_number.'" style="width: 82px; height: 50px;" />
					    <br/>'. $this->l('Recommended size').' 593x362.',
					'value' => true
				),
				array(
					'type' => 'file',
					'label' => $this->l('Background 3'),
					'name' => 'image_3',
					'desc' => '<img src="../modules/maintenancetools/img/backgrounds/background-3-'.$id_shop.'.jpg?ranimg='.$random_number.'" style="width: 82px; height: 50px;" />
					    <br/>'. $this->l('Recommended size').' 593x362.',
					'value' => true
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content'),
					'lang' => true,
					'name' => 'content',
					'autoload_rte' => true,
					'cols' => 40,
					'rows' => 10
				),
				array(
					'type' => 'text',
					'label' => $this->l('Imprint'),
					'lang' => true,
					'name' => 'imprint',
					'size' => 100
				)
			),
			'submit' => array(
				'title' => $this->l('Save')
			)
		);

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'maintenancetools';
		$helper->identifier = 'id_shop';
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		foreach (Language::getLanguages(false) as $lang)
			$helper->languages[] = array(
				'id_lang' => $lang['id_lang'],
				'iso_code' => $lang['iso_code'],
				'name' => $lang['name'],
				'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
			);

		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->toolbar_scroll = true;
		$helper->title = $this->displayName;
		$helper->submit_action = 'saveMaintenanceTools';

		return $helper;
	}

	protected function initConfigForm()
	{
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$options = array();
        $options[0] = array(
                'id' => 0,
                'name' => '-- '.$this->l('Select a CMS').' --'
            );

		foreach (CMS::getLinks((int)Context::getContext()->language->id) as $cms) {
            $options[] = array(
                'id' => (int)$cms['id_cms'],
                'name' => $cms['meta_title']
            );
        }

		$this->fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Global configuration'),
				'icon' => 'icon-cogs'
			),
			'input' => array(
				array(
					'type' => 'datetime',
					'label' => $this->l('Countdown date'),
					'name' => 'PS_MAINTENANCE_DATE',
					'size' => 30,
					'class' => 'datetimepicker'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Countdown'),
					'name' => 'PS_MAINTENANCE_COUNT',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_COUNT_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_COUNT_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Newsletter'),
					'name' => 'PS_MAINTENANCE_NEWS',
					'desc' => $this->l('You need to have installed the block Newsletter').
					    (!Module::isEnabled('blocknewsletter') ? '<br/><div class="warn alert alert-warning">'.$this->l('Block Newsletter not installed.').'</div>' : ''),
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_NEWS_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_NEWS_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
				    'type' => 'select',
					'label' => $this->l('Conditions CMS'),
					'name' => 'PS_MAINTENANCE_NEWS_C_ID',
					'options' => array(
                        'query' => $options,
                        'id' => 'id',
                        'name' => 'name'
                    )
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Conditions'),
					'name' => 'PS_MAINTENANCE_NEWS_C',
					'desc' => $this->l('Newsletter conditions'),
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_NEWS_C_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_NEWS_C_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Faceboobk url'),
					'name' => 'PS_MAINTENANCE_FB_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_FB',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_FB_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_FB_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Twitter url'),
					'name' => 'PS_MAINTENANCE_TW_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_TW',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_TW_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_TW_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Google+ url'),
					'name' => 'PS_MAINTENANCE_GO_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_GO',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_GO_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_GO_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Youtube url'),
					'name' => 'PS_MAINTENANCE_YT_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_YT',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_YT_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_YT_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Pinterest url'),
					'name' => 'PS_MAINTENANCE_PIN_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_PIN',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_PIN_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_PIN_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Vimeo url'),
					'name' => 'PS_MAINTENANCE_VIM_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_VIM',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_VIM_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_VIM_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Flickr url'),
					'name' => 'PS_MAINTENANCE_FLICKR_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_FLICKR',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_FLICKR_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_FLICKR_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Instagram url'),
					'name' => 'PS_MAINTENANCE_INST_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_INST',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_INST_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_INST_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Github url'),
					'name' => 'PS_MAINTENANCE_GT_URL',
					'size' => 100
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Active'),
					'name' => 'PS_MAINTENANCE_GT',
					'values' => array(
                        array(
                            'id' => 'PS_MAINTENANCE_GT_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'PS_MAINTENANCE_GT_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
					'class' => 't',
					'is_bool' => true
				)
			),
			'submit' => array(
				'title' => $this->l('Save')
			)
		);

		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = 'maintenancetools';
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		foreach (Language::getLanguages(false) as $lang)
			$helper->languages[] = array(
				'id_lang' => $lang['id_lang'],
				'iso_code' => $lang['iso_code'],
				'name' => $lang['name'],
				'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
			);

		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->show_toolbar = false;
		$helper->title = $this->displayName;
		$helper->submit_action = 'saveConfigMaintenanceTools';

		return $helper;
	}

	public function getMaintenanceTexts($id_shop, $id_lang)
	{
		$texts =  Db::getInstance()->executeS('
			SELECT mtl.`title`, mtl.`content`, mtl.`imprint`
			FROM `'._DB_PREFIX_.'maintenancetools` mt
			LEFT JOIN `'._DB_PREFIX_.'maintenancetools_lang` mtl ON (mt.`id_shop` = mtl.`id_shop`)
			WHERE mt.`id_shop` = '.(int)$id_shop.' AND mtl.`id_lang` = '.(int)$id_lang);

		return $texts[0];
	}

	public function getMaintenanceImages($id_shop)
	{
		$images =  Db::getInstance()->executeS('
			SELECT mt.`file_name_1`, mt.`file_name_2`, mt.`file_name_3`
			FROM `'._DB_PREFIX_.'maintenancetools` mt
			WHERE mt.`id_shop` = '.(int)$id_shop);

		return $images[0];
	}

	private function isNewsletterRegistered($customerEmail)
 	{
		$id_shop = (int)Context::getContext()->shop->id;

		$sql = 'SELECT `email`
			FROM '._DB_PREFIX_.'newsletter
			WHERE `email` = \''.pSQL($customerEmail).'\'
			AND id_shop = '.$id_shop;

		if (Db::getInstance()->getRow($sql))
			return 1;

        $sql = 'SELECT `newsletter`
			FROM '._DB_PREFIX_.'customer
			WHERE `email` = \''.pSQL($customerEmail).'\'
			AND id_shop = '.$id_shop;

		if (!$registered = Db::getInstance()->getRow($sql))
			return -1;
		return 0;
 	}

 	private function newsletterRegistration()
 	{
		$mt = $this->_getVariables();
		if ($mt['PS_MAINTENANCE_NEWS_C'] && !isset($_POST['conditions']) || $mt['PS_MAINTENANCE_NEWS_C'] && !$_POST['conditions'])
			return $this->error = $this->l('You must accept the conditions');
		if ($_POST['url'] && !empty($_POST['url']))
			return $this->error = $this->l('An error occurred during the subscription, please wait some seconds');
		if (empty($_POST['email']) OR !Validate::isEmail($_POST['email']) OR $_POST['email'] == Configuration::get('PS_SHOP_EMAIL'))
			return $this->error = $this->l('Invalid e-mail address');

	 	if ($_POST['action'] == '0')
	 	{
	 	 	$registerStatus = $this->isNewsletterRegistered(pSQL($_POST['email']));
			if ($registerStatus > 0)
				return $this->error = $this->l('E-mail address already registered');
			elseif ($registerStatus == -1)
			{
				global $cookie;

				$id_shop = (int)Context::getContext()->shop->id;

				if (!Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'newsletter (id_shop, email, newsletter_date_add, ip_registration_newsletter, http_referer, active)
				    VALUES (\''.$id_shop.'\', \''.pSQL($_POST['email']).'\', NOW(), \''.pSQL(Tools::getRemoteAddr()).'\',
					(SELECT c.http_referer FROM '._DB_PREFIX_.'connections c WHERE c.id_guest = '.(int)($cookie->id_guest).' ORDER BY c.date_add DESC LIMIT 1), 1)'))
					return $this->error = $this->l('Error during subscription');
				return $this->valid = $this->l('Subscription successful');
			}
		}
		else
		    return $this->error = $this->l('An error occurred during the subscription, please wait some seconds');
 	}

	public function hookDisplayHeaderMaintenance($params)
    {
		$_html = '';

		$mt = $this->_getVariables();

		if((bool)Configuration::get('PS_JS_DEFER'))
		{
		    $this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-1.11.0.min.js');
	        $this->context->controller->addJS(($this->_path).'js/bootstrap.min.js');
	        $this->context->controller->addJS(($this->_path).'js/jquery.backstretch.min.js');

		    if ($mt['PS_MAINTENANCE_COUNT'])
	            $this->context->controller->addJS(($this->_path).'js/jquery.countdown.min.js');
		}
		else
		{
		    $_html .= '<script type="text/javascript" src="'.$this->_path.'js/jquery-1.11.0.min.js"></script>';
	        $_html .= '<script type="text/javascript" src="'.$this->_path.'js/bootstrap.min.js"></script>';
	        $_html .= '<script type="text/javascript" src="'.$this->_path.'js/jquery.backstretch.min.js"></script>';

		    if ($mt['PS_MAINTENANCE_COUNT'])
	            $_html .= '<script type="text/javascript" src="'.$this->_path.'js/jquery.countdown.min.js"></script>';

			$_html .= '
		    <script type="text/javascript">
			    var baseDir = "'._PS_BASE_URL_.__PS_BASE_URI__.'";
				var baseUri = "'._PS_BASE_URL_.__PS_BASE_URI__.'";
				var id_lang = "'.$this->context->language->id.'";
			</script>';
		}

		$date = str_replace('-', '/', $mt['PS_MAINTENANCE_DATE']);
		$id_shop = $this->context->shop->id;
		$images = $this->getMaintenanceImages($id_shop);

		$images_1 = $images['file_name_1'] ? 'modules/maintenancetools/img/backgrounds/'.$images['file_name_1'] : '';
		$images_2 = $images['file_name_2'] ? 'modules/maintenancetools/img/backgrounds/'.$images['file_name_2'] : '';
		$images_3 = $images['file_name_3'] ? 'modules/maintenancetools/img/backgrounds/'.$images['file_name_3'] : '';

		$_html .= '
		<script type="text/javascript">
		    $(document).ready(function() {
				$(".coming-soon").backstretch([
				    baseUri + "'.$images_1.'",
					baseUri + "'.$images_2.'",
					baseUri + "'.$images_3.'"
				], {duration: 3000, fade: 750});';

		if ($mt['PS_MAINTENANCE_COUNT'])
		{
		    $_html .= '$(".timer").countdown("'.$date.'").on("update.countdown", function(event) {
                    var $this = $(this).html(event.strftime(""
                    + "<div class=\'days-wrapper\'><span class=\'days\'>%D</span><br> '.$this->l('days').'</div>"
                    + "<div class=\'hours-wrapper\'><span class=\'hours\'>%H</span><br> '.$this->l('hours').'</div>"
                    + "<div class=\'minutes-wrapper\'><span class=\'minutes\'>%M</span><br> '.$this->l('minutes').'</div>"
                    + "<div class=\'seconds-wrapper\'><span class=\'seconds\'>%S</span><br> '.$this->l('seconds').'</div>"));
                }).on("finish.countdown", hideTimer);
				function hideTimer(){$(".timer").hide()}';
		}

        $_html .= '$(".social a.facebook").tooltip();
                $(".social a.twitter").tooltip();
                $(".social a.googleplus").tooltip();
                $(".social a.pinterest").tooltip();
                $(".social a.youtube").tooltip();
				$(".social a.vimeo").tooltip();
				$(".social a.flickr").tooltip();
				$(".social a.instagram").tooltip();
				$(".social a.github").tooltip();
				$(".language a").tooltip();
				$("#conditions").tooltip();
            });
		</script>
		';

		return Media::minifyHTML($_html);
	}

	public function hookDisplayMaintenance($params)
    {
		if (Tools::isSubmit('submitNewsletter'))
		{
			$this->newsletterRegistration();
			if ($this->error)
			{
				$this->context->smarty->assign(array(
					'msg' => $this->error,
					'nw_value' => isset($_POST['email']) ? pSQL($_POST['email']) : false,
					'nw_error' => true,
					'action' => $_POST['action'])
				);
			}
			elseif ($this->valid)
			{
				if (Configuration::get('NW_CONFIRMATION_EMAIL') AND isset($_POST['action']) AND (int)($_POST['action']) == 0)
					Mail::Send((int)$params['cookie']->id_lang,
					    'newsletter_conf',
						Mail::l('Newsletter confirmation',
						(int)$params['cookie']->id_lang),
						array(),
						pSQL($_POST['email']),
						NULL,
						NULL,
						NULL,
						NULL,
						NULL,
						_PS_MODULE_DIR_.'blocknewsletter/mails/'
					);

				$this->context->smarty->assign(array(
					'msg' => $this->valid,
					'nw_error' => false)
				);
		    }
		}

		$mt = $this->_getVariables();
		$this->context->smarty->assign(array(
		    'mt' => $mt,
			'date' => str_replace('-', '/', $mt['PS_MAINTENANCE_DATE']),
			'shop_email' => Configuration::get('PS_SHOP_EMAIL'),
			'shop_phone' => Configuration::get('PS_SHOP_PHONE')
		));

		$id_shop = $this->context->shop->id;

		$id_lang = $this->context->language->id;
		$maintenance = $this->getMaintenanceTexts($id_shop, $id_lang);

		$this->context->smarty->assign(array('maintenance' => $maintenance));

		if ($mt['PS_MAINTENANCE_NEWS_C'] == 1)
		{
			$conditions = new CMS($mt['PS_MAINTENANCE_NEWS_C_ID']);
			$this->context->smarty->assign(array(
				'conditions' => array(
				    'title' => $conditions->meta_title[$id_lang],
					'content' => $conditions->content[$id_lang])
				)
			);
		}

		return $this->display(__FILE__, 'maintenancetools.tpl');
    }
}
?>