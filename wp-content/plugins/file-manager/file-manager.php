<?php
/**
 * 
 * Plugin Name: File Manager
 * Author Name: Aftabul Islam
 * Version: 3.0.0
 * Author Email: toaihimel@gmail.com
 * License: GPLv2
 * Description: Manage your file the way you like. You can upload, delete, copy, move, rename, compress, extract files. You don't need to worry about ftp any more. It is realy simple and easy to use.
 *
 * */

// Including elFinder class
require_once('elFinder/elFinder.php');

// Including bootstarter
require_once('BootStart/__init__.php');

class FM extends FM_BootStart {

	public function __construct($name){

		// Adding Menu
		$this->menu_data = array(
			'type' => 'menu',
		);

		// Adding Ajax
		$this->add_ajax('connector'); // elFinder ajax call
		$this->add_ajax('valid_directory'); // Checks if the directory is valid or not

		parent::__construct($name);

	}
	
	/**
	 * 
	 * File manager connector function
	 * 
	 * */
	public function connector(){
		
		if(!defined('FILE_MANAGER_PREMIUM')){
			$file_operations = array( 'mkdir', 'mkfile', 'rename', 'duplicate', 'paste', 'ban', 'archive', 'extract', 'copy', 'cut', 'edit' );
			$mime_allowed = array('text/plain');
			$mime_denied = array('image');
		} else {
		
			$file_operations = array();
			$mime_allowed = array('text/plain', 'image');
			$mime_denied = array();
			
		}
		
		$opts = array(
			'debug' => true,
			'roots' => array(
				array(
					'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
					'path'          => ABSPATH,                     // path to files (REQUIRED)
					'URL'           => site_url(),                  // URL to files (REQUIRED)
					'uploadDeny'    => $mime_denied,                // All Mimetypes not allowed to upload
					'uploadAllow'   => $mime_allowed,               // Mimetype `image` and `text/plain` allowed to upload
					'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
					'accessControl' => 'access',
					'disabled'      => $file_operations             // disable and hide dot starting files (OPTIONAL)
				)
			)
		);
		
		$elFinder = new FM_EL_Finder();
		$elFinder = $elFinder->connect($opts);
		$elFinder->run();
				
		die();
	}

}

global $FileManager;
$FileManager = new FM('File Manager');
