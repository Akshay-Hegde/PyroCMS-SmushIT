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
				//$src_name = "http://mysocialpet.it/files/large/74fe6222912f9c2/680";
				//$dest_name = './uploads/'.SITE_REF.'/files/mio_file_smush.jpg';
				
				log_message('error', 'src: '.$src_name.' - Dest: '.$dest_name);		
						
				if( $this->ci->smushit->smush($src_name , $dest_name) )
				{
					log_message('error', 'ridimensionata: ');
				}
			}
		}
	}
}