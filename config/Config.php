<?php
// --- ENABLE ONLY WHEN GOING ON LIVE (ONLINE) ---

define("BASE_URL", '/villagemarket/');




// define the root path for inclusive files

define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"]."/villagemarket/");



//var_dump(ROOT_PATH);



// get the value of the base url (Troubleshooting purpose)

function get_base_url(){

	return BASE_URL;

}



// get the value of the root path (Troubleshooting purpose)

function get_root_path(){

	return ROOT_PATH;

}