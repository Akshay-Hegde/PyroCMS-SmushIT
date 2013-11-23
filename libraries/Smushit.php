<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SmushIt
{
	public function smush( $src = "" , $dest = "" )
	{
		//Src url must be set
		if( trim( $src ) == "" || trim( $dest ) == "" )
		{
			return array(
				'status' => false,
				'msg' 	 => "SRC and DEST cannot be empty"
			);
		}				

		//Set the Smushit URL
		$image_url = "http://www.smushit.com/ysmush.it/ws.php?img=".$src;			
		
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $image_url );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	
		//Execute 
		$result = curl_exec( $ch );
	
		//Close
		curl_close( $ch );	

		//If we do not have any result something went wrong
		if( trim( $result ) == '' )
		{		   	
		   	return array(
				'status' => false,
				'msg' 	 => "Unknown error"
			);
		}   

	    //Get the info from $result
	    $new_image = json_decode( $result );

	    //Should we download the new image?
	    if( $new_image->dest_size < $new_image->src_size )
	    {
	    	//Get the new image from smushit
	    	$new_url = $new_image->dest;
			
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $new_url );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
			//Execute 
			$new_result = curl_exec( $ch );
		
			//Close
			curl_close( $ch );
			
	    	//If we do not have any result something went wrong
			if( trim( $new_result ) == '' )
			{
			   	return array(
					'status' => false,
					'msg' 	 => "Unknown error"
				);
			}

	    	//Save the new image
	    	$fh = @fopen($dest, 'w');
  			@fwrite($fh, $new_result);
  			@fclose($fh);
  		
			return array(
				'status' 	=> true,
				'msg' 		=> "The image has been smushed. Saved ".( $new_image->src_size - $new_image->dest_size )." (".$new_image->percent."%)",
				'diff_size' => $new_image->src_size - $new_image->dest_size,
				'percent' 	=> $new_image->percent
			);
	    }
	    else 
	    {			
			return array(
				'status' => true,
				'msg' 	 => "The source image is already smushed."
			);
	    }		   
	}
}