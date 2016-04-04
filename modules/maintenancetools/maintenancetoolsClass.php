<?php
/*
* Maintenance Tools v2.0 ((Prestashop 1.6)
* @author kik-off.com <info@kik-off.com>
*/

class maintenancetoolsClass extends ObjectModel
{
	public $id;
	public $id_shop;
	public $file_name_1;
	public $file_name_2;
	public $file_name_3;
	public $title;
	public $content;
	public $imprint;

	public static $definition = array(
		'table' => 'maintenancetools',
		'primary' => 'id',
		'multilang' => true,
		'fields' => array(
			'file_name_1' => array('type' => self::TYPE_STRING, 'validate' => 'isFileName'),
			'file_name_2' => array('type' => self::TYPE_STRING, 'validate' => 'isFileName'),
			'file_name_3' => array('type' => self::TYPE_STRING, 'validate' => 'isFileName'),
			'title' =>       array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true),
			'content' =>     array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 3999999999999),
			'imprint' =>     array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => false),
		)
	);

	public function copyFromPost()
	{
		foreach ($_POST AS $key => $value)
			if (array_key_exists($key, $this))
				$this->{$key} = $value;

		if (sizeof($this->fieldsValidateLang))
		{
			$languages = Language::getLanguages(false);
			foreach ($languages AS $language)
				foreach ($this->fieldsValidateLang AS $field => $validation)
					if (isset($_POST[$field.'_'.(int)($language['id_lang'])]))
						$this->{$field}[(int)($language['id_lang'])] = $_POST[$field.'_'.(int)($language['id_lang'])];
		}
	}
}
