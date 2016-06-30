<?php

require("../models/database.php");

$db = new Database("127.0.0.1", "addressbook", "root", "");

$results = null;

/* GET */

if (isset($_GET["contact"]))
{
	if ($_GET["contact"] == "all")
	{
		$results = $db->get("contacts");
	}
	else
	{
		$results = $db->get("contacts", "firstname = '$_GET[contact]'");
	}
}
else if (isset($_GET["address"]))
{
	if (isset($_GET["contact_id"]))
	{
		$results = $db->get("addresses");
	}
	else if (isset($_GET["id"]))
	{
		$results = $db->get("addresses", "id = '$_GET[id]'");
	}
}

/* POST */
if (isset($_POST["newuser"]))
{
	$results = $db->insert("contacts", array(
		"gender" 	=> "male",
		"lastname"	=> "Doe",
		"firstname" => "John",
		"token"		=> bin2hex(openssl_random_pseudo_bytes(16))
	));
}
else if (isset($_POST["add"]))
{
	$results = $db->insert("addresses", array(
		"street"	=> $_POST["street"],
		"zipcode"	=> $_POST["zipcode"],
		"city"		=> $_POST["city"]
	), $_POST["token"]);
}
else if (isset($_POST["edit"]))
{
	$results = $db->update("addresses", $_POST["id"], array(
		"street"	=> $_POST["street"],
		"zipcode"	=> $_POST["zipcode"],
		"city"		=> $_POST["city"]
	), $_POST["token"]);
}
else if (isset($_POST["delete"]))
{
	$results = $db->delete("addresses", $_POST["id"], $_POST["token"]);
}

if (isset($_GET["xml"])) {
	header("Content-type: text/xml");

	function array_to_xml( $data, &$xml_data ) {
	    foreach( $data as $key => $value ) {
	        if( is_array($value) ) {
	            if( is_numeric($key) ){
	                $key = 'item'.$key; //dealing with <0/>..<n/> issues
	            }
	            $subnode = $xml_data->addChild($key);
	            array_to_xml($value, $subnode);
	        } else {
	            $xml_data->addChild("$key",htmlspecialchars("$value"));
	        }
	     }
	}

	// creating object of SimpleXMLElement
	$xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

	// function call to convert array to xml
	array_to_xml($results,$xml_data);

	echo $xml_data->asXML();
} else {
	header("Content-type: text/json");

	echo json_encode($results);
}