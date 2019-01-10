<?php
function set_rights($menus, $menuRights, $topmenu) {
    $data = array();

    for ($i = 0, $c = count($menus); $i < $c; $i++) {


        $row = array();
        for ($j = 0, $c2 = count($menuRights); $j < $c2; $j++) {
        	//check if the user has access to a function
        	if($menuRights[$j]["rr_topaccess"] == 1){
        		//get the available modules and access priviledges
        		if ($menuRights[$j]["rr_modulecode"] == $menus[$i]["mod_modulecode"]) {
        			//check if the create, read, update, delete right is true  
	                if (authorize($menuRights[$j]["rr_create"]) || authorize($menuRights[$j]["rr_edit"]) ||
	                        authorize($menuRights[$j]["rr_delete"]) || authorize($menuRights[$j]["rr_view"])
	                ) {
	                	//if at leaset on is true show the module
	                	/*
	                	 * GET THE DETAILS OF THE MODULE
	                	*/
	                    $row["menu"] = $menus[$i]["mod_modulegroupcode"];
	                    $row["menu_name"] = $menus[$i]["mod_modulename"];
	                    $row["page_name"] = $menus[$i]["mod_modulepagename"];
	                    $row["link_icon"] = htmlentities($menus[$i]["mod_modulenameicon"]);
	                    $row["code"] = $menuRights[$j]["rr_modulecode"];
	                    $row["create"] = $menuRights[$j]["rr_create"];
	                    $row["edit"] = $menuRights[$j]["rr_edit"];
	                    $row["delete"] = $menuRights[$j]["rr_delete"];
	                    $row["view"] = $menuRights[$j]["rr_view"];


	                    $data[$menus[$i]["mod_modulegroupcode"]][$menuRights[$j]["rr_modulecode"]] = $row;
	                    $data[$menus[$i]["mod_modulegroupcode"]]["top_menu_name"] = $menus[$i]["mod_modulegroupname"];
	                    $data[$menus[$i]["mod_modulegroupcode"]]["is_active"] = $menus[$i]["mod_modulepagename"];
	                    $data[$menus[$i]["mod_modulegroupcode"]]["top_menu_icon"] = htmlentities($menus[$i]["mod_modulegroupicon"]);
	                }
	            }
        	}else{
        		$data["unaccessable"][$j] = $menuRights[$j]["rr_modulecode"];
        	}
        }
    }
    
    return $data;
}

function authorize($module) {
    return $module == 1 ? TRUE : FALSE;
}