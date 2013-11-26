<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Smushit extends Module
{
	public $version = "1.0.0";
	
	public function info()
	{
		return array(
			'name' => array(
				'it' => "SmushIt",
				'en' => "SmushIt"
			),
			'description' => array(
				'it' => "Permette di rimpicciolire il peso delle immagini senza perdere la qualità sfruttando il servizio SmushIt",
				'en' => "Allow users to reduce images size using Yahoo online service smushit"
			),
			'author' => "Christian Giupponi STILOGO",
			'frontend' => false,
			'backend' => false
		);
	}
	
	public function install()
	{
		//Load lang
		$this->lang->load('smushit/smushit');
		
		//cURL must be enabled
		if( ! function_exists('curl_version') )
		{
			$this->session->set_flashdata('error', lang("smushit:install:error:curl") );
			redirect('admin/addons/');
			exit;
		}

		//We need json support
		if( ! function_exists('json_decode') )
		{
			$this->session->set_flashdata('error', lang("smushit:install:error:json") );
			redirect('admin/addons/');
			exit;
		}

		$settings = array(
			'smushit_option' => array(
				'title' 	  => lang('smushit:install:settings:title'),
				'description' => lang('smushit:install:settings:descr'),
				'type' 		  => 'select',
				'default' 	  => '1',
				'value' 	  => '',
				'options' 	  => '0='.lang('global:no').'|1='.lang('global:yes'),
				'is_required' => 1,
				'is_gui' 	  => 1,
				'module' 	  => 'smushit',
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
