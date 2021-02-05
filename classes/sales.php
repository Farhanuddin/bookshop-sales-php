<?php


class Sales {
	
	protected $db;
	protected $data_path;
	
	function __construct($db){
		$this->db = $db;
		$this->data_path = DATA_PATH;
	}

	//Method to get Sales data with/witout filters..
	function getSalesData($params){
		
		try{

			$result = null;
			$query  = "";
			$filterAdded = false;

			$query .= 'SELECT * FROM sales';

			if($params['filter'] == "true"){

				//If customer name filter was entered..
				if(!empty($params['customer_name'])){
					$query .= ' WHERE customer_name like "%'.addslashes(trim($params['customer_name'])).'%"';
					$filterAdded = true;
				}

				//If product name filter was entered..
				if(!empty($params['product_name'])){
					
					if($filterAdded == true){
						$query .= ' AND ';
					}else{
						$query .= ' WHERE';	
					}

					$query .= ' product_name like "%'.addslashes(trim($params['product_name'])).'%"';
					
					$filterAdded=true;

				}

				//If product price filter was
				if(!empty($params['product_price'])){
					
					if($filterAdded == true){
						$query .= ' AND';
					}else{
						$query .= ' WHERE';	
					}			
					
					$query .= ' product_price like "%'.addslashes(trim($params['product_price'])).'%"';
					
					$filterAdded=true;
				}		

			}

			//Prepare Sql statement..
			$qrySmt = $this->db->prepare($query);
			
			//Execute statement
			$qrySmt->execute();
		

			//Format fetched results
			$shapedResults = $this->shapeResults($qrySmt->fetchAll());

			return $shapedResults;

		}catch(Exception $e){
	   		echo "Error in Fetching Sales data: " . $e->getMessage();
		}finally{
			//For closing connection
			$this->db = null;			
		}
	}

	//Format fetched results to desired html and calculate total..
	function shapeResults($results){

		$data = '';

		if($results && count($results) > 0){

			$total_price = 0;

			for($i=0; $i<count($results); $i++) {
				$row = $results[$i];
			 	$data  .= '<tr>';
			 	$data  .= '<td>'.$row["sale_id"].'</td>';
			 	$data  .= '<td>'.$row["customer_name"].'</td>';
			 	$data  .= '<td>'.$row["customer_mail"].'</td>';
			 	$data  .= '<td>'.$row["product_id"].'</td>';
			 	$data  .= '<td>'.$row["product_name"].'</td>';
			 	$data  .= '<td>'.$row["product_price"].'</td>';
			 	$data  .= '<td>'.$row["sale_date"].'</td>';
			    $data  .= '</tr>';

			    $total_price += $row["product_price"];
			}

		$data .= "<tr class='text-center'><td><b>Total Price</b>. ".$total_price."<td><tr>";
		
		}else{
			$data  .= "<tr class='text-center'><td>No Rows Found.<td><tr>";
		}

		return $data;		
	}

	//Save sales Json..
	function saveSalesJson(){
       
		try{

	       $jsonFile   = $this->data_path;
	       $jsondata   = file_get_contents($jsonFile);
	       $array_data = json_decode($jsondata, true);
	       
	       $this->db->beginTransaction();

	       /*Prepare Sql Statement for bulk execute insert*/

	       $data = $this->getInsertValuesAndPlaceHolders($array_data);

	       $stmt = $this->db->prepare('INSERT INTO sales(sale_id, customer_name, customer_mail, product_id, product_name, product_price, sale_date) VALUES '.implode(',', $data['placeholder']) );

	       //Execute statement with query values..
		   $res = $stmt->execute($data['execute_values']);

		   if(!$res){
			  echo 'Something went wrong..';
		   }

		   //Everything went fine, commit query..
		   $this->db->commit();
   		
   		   echo 'data saved';

		}catch(Exception $e){
	   		echo "Error in Saving Sales data: " . $e->getMessage();
		}finally{
			//For closing connection			
 		   $this->db = null;
		}		
	}

	//Get placeholders and data values for preparing query statement and executing stament with values respetively..
	function getInsertValuesAndPlaceHolders($array_data){

		$queryData 					 = [];
		$queryData['placeholder'] 	 = [];
		$queryData['execute_values'] = [];
 		
		for($i=0; $i<count($array_data); $i++){

			//Get Question mark place holders for return statement..
			$queryData['placeholder'][] = '('.$this->getPlaceHolders('?', count($array_data[$i])).')';

			//Get values for pdo execute bulk insert statement..
			$queryData['execute_values'] = array_merge($queryData['execute_values'], array_values($array_data[$i]) );
			//var_dump($queryData['execute_values']);
			//die();
		}

		return $queryData;
	}


	//Method for getting Placer holder..
	function getPlaceHolders($text, $count=0){
	    $result = array();
	    if($count > 0){
	        for($x=0; $x<$count; $x++){
	            $result[] = $text;
	        }
	    }
	    return implode(',' , $result);		
	}

}