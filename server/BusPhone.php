<?php

require_once 'API.class.php';
require_once 'BusPhone.database.php';
class BusPhoneApi extends API
{

    public function __construct($request, $origin) {
        parent::__construct($request);
    }

    /**
     * Validate a ticket end point
     */
     protected function validate_ticket() {
        if ($this->method == 'GET') {
        	//Check for the ticket id request
        	if(!isset($_REQUEST['ticket_id'])){
        		return "No ticket id provided";
        	}

        	//Open Database connection
        	$DB_connection = new BusPhoneConnection();

        	//Check for database error
        	if($DB_connection.has_error()){
        		return $DB_connection.get_error();
        	}

        	//Requested ticket it
        	$ticket_id = $_REQUEST['ticket_id'];

        	//Check if it exists in database available
        	

        	//Close database connection
        	$DB_connection.close();
        } else {

        }
     }
 }


 // Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new BusPhoneApi($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}