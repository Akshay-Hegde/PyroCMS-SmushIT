<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Smushit extends Module
{
	public $version = "1.0.0";
	
	public function info()
	{
		return array(
			'name' => array(
				'it' => "SmushIt"
			),
			'description' => array(
				'it' => "Permette di rimpicciolire il peso delle immagini senza perdere la qualità sfruttando il servizio SmushIt"
			),
			'author' => "Christian Giupponi STILOGO",
			'frontend' => false,
			'backend' => false
		);
	}
	
	public function install()
	{
		//cURL must be enabled
		if( ! function_exists('curl_version') )
		{
			$this->session->set_flashdata('error', "cURL must be enabled" );
			redirect('admin/addons/');
			exit;
		}

		//We need json support
		if( ! function_exists('json_decode') )
		{
			$this->session->set_flashdata('error', "jSON must be enabled");
			redirect('admin/addons/');
			exit;
		}

		$settings = array(
			'smushit_option' => array(
				'title' => 'Abilita SmushIt',
				'description' => 'Abilitando il servizio tutte le immagini caricate verranno rimpicciolite',
				'type' => 'select',
				'default' => '1',
				'value' => '',
				'options' => '0=NO|1=SI',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'smushit',
			),	
		);
		
		foreach ($settings as $slug => $setting_info)
		{
			$setting_info['slug'] = $slug;
			if ( ! $this->db->insert('settings', $setting_info))
			{
				return false;
			}
		}
		
		return true;
	}
	
	public function uninstall()
	{
		if( ! $this->db->query("DELETE FROM default_settings WHERE slug = 'smushit_option'") )
		{
			return false;
		}
		
		return true;
	}
	
	public function upgrade( $old_version )
	{
		return true;
	}
}