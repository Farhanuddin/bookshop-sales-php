<?php 

require('database.php');
require('sales.php');

class App {

	private $db;

	function __construct(){
		$this->bootstrapApplication();
	}

	//Bootstrap application..
	function bootstrapApplication(){
		$database = new Db();
		$this->db = $database->getConnection();
	}

	//Search Sales Data
	function searchSalesData($params){
		$sales = new Sales($this->db);
		return $sales->getSalesData($params);
	}

	//Save sales data
	function saveSalesData(){
		$sales = new Sales($this->db);
		return $sales->saveSalesJson();
	}

}


//Fetch filtered via ajax..
if(isset($_GET["searchsubmit"]))  
{  
	$app = new App();
	echo json_encode($app->searchSalesData($_GET), JSON_UNESCAPED_SLASHES);
}


