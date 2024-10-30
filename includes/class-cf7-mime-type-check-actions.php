<?php

/**
 * The actions of the plugin.
 *
 * @link       https://hmumarkhan.com/
 * @since      1.0.0
 *
 * @package    Cf7_Mime_Type_Check
 * @subpackage Cf7_Mime_Type_Check/Includes
 */

/**
 * The Actions of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * perform the actions required to be done in plugin.
 *
 * @package    Cf7_Mime_Type_Check
 * @subpackage Cf7_Mime_Type_Check/Includes
 * @author     Umar Khan <hmumarkhan@gmail.com>
 */
class Cf7_Mime_Type_Check_Actions {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Function to check posted files by Contact form 7 Files.
	 *
	 * @since    1.0.0
	 */
	function cf7_custom_posted_data ($posted_data) {
		if(isset($_FILES)){
			foreach ($_FILES as $key => $value) {
				if(isset($_FILES[$key]["tmp_name"]) && strlen($_FILES[$key]["tmp_name"])){
					$contentType = mime_content_type($_FILES[$key]["tmp_name"]);
		    		$_FILES[$key]['type'] = $contentType;
				}
			}
		}
	    return $posted_data;
	}

	/**
	 * Function to add custom mime type check validation in Contact form 7 File submission.
	 *
	 * @since    1.0.0
	 */
	function cf7_custom_file_validation ($result, $tag) {
		$tag = new WPCF7_FormTag( $tag );
		//getting cf7 error messages
		$error_messages = wpcf7_messages();
		//checking if required file has been submitted
		if(isset($_FILES[$tag->name])){
			// Checking if file is required
			if($tag->type == 'file*' && empty($_FILES[$tag->name]["tmp_name"])){
			$result->invalidate($tag, $error_messages['invalid_required']['default']);
			}else{
				$options = $tag->options;
				//Uploaded file Mime type
				$file_mime = $_FILES[$tag->name]['type'];
				$is_allowed = 0;
				if(!empty($options)){
					foreach ($options as $option) {
						if (strpos($option, 'filetypes') !== false) {
						    $filetypes = explode(":", $option);
						    $filetypes = explode("|", $filetypes[1]);
						    foreach ($filetypes as $allowed_type) {
						    	//Allowed mime types according to extensions
						    	$allowed_mime = ext2mime($allowed_type);
						    	//If there is an array of mimes releated to this extension
						    	if(is_array($allowed_mime)){
						    		if(in_array($file_mime, $allowed_mime)){
						    			$is_allowed = 1;
						    		}
						    	}elseif(!is_array($allowed_mime) && $allowed_mime != $file_mime){
						    		$is_allowed = 1;	
						    	}
						    }
							//if mime type is not allowed, throw an error
							if($is_allowed == 0){
								$result->invalidate($tag, $error_messages['upload_file_type_invalid']['default']);
							}
						}
					}
				}	
			}
		}
	    return $result;
	}
}
