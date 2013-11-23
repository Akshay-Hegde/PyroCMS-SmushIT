<?php defined('BASEPATH') or exit('No direct script access allowed');

class Events_Smushit
{
	protected $ci;
	
	public function __construct()
	{
		//Recupero l'istanza
		$this->ci =& get_instance();
				
		//Registro gli eventi
		Events::register('file_uploaded', array($this, 'smush_file'));
		
		//Get the value from settings --> 0 = no 1 = yes
		$this->enabled = Settings::get('smushit_option');
		
	}
	
	public function smush_file( $data )
	{
		//If module is enabled in Settings
		if( $this->enabled == 1 )
		{
			//Set extensions array
			$ext = array('.jpg', '.jpeg', '.png');
			
			//We need just image file
			if( in_array($data['extension'], $ext) )
			{
				//Load library
				$this->ci->load->library('smushit/smushit');
				
				//Get image name
				$src_name = base_url().'files/large/'.$data['filename'];
				$dest_name = './uploads/'.SITE_REF.'/files/'.$data['filename'];
				
				//Smush the image
				$result = $this->ci->smushit->smush($src_name , $dest_name);
				
				//If the status is false something went wrong - log it
				if( $result['status'] == false )
				{
					log_message('error', 'SmushIT Error: '.$result['msg']);
				}
			}
		}
	}
}