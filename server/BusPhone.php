<?php

require (dirname( __FILE__ ) . '/Api.class.php');
require (dirname( __FILE__ ) . '/BusPhone.database.php');
class BusPhoneApi extends API
{

    public function __construct($request, $origin) {
        parent::__construct($request);
    }

    /**
     * Validate a ticket end point
     */
     protected function login(){
        if ($this->method == 'GET'){
            //Check for the ticket id request
            if(!isset($_REQUEST['email'])){
                return "No user email provided";
            }
            if(!isset($_REQUEST['pass'])){
                return "No user password provided";
            }

            //Open Database connection
            $DB_connection = new BusPhoneConnection();

            //Check for database error
            if($DB_connection->has_error()){
                return $DB_connection->get_error();
            }

            //Requested ticket it
            $email = $_REQUEST['email'];
            $pass = $_REQUEST['pass'];

            //Check if it exists in database available
            $result = $DB_connection->login($email, $pass);

            //Close database connection
            $DB_connection->close();

            return $result;
        }
     }

     protected function register(){
        if ($this->method == 'POST'){
            if(!isset($_REQUEST['name'])){
                return "No user name provided";
            }
            if(!isset($_REQUEST['pass'])){
                return "No user password provided";
            }
            if(!isset($_REQUEST['email'])){
                return "No user email provided";
            }
            if(!isset($_REQUEST['card_type'])){
                return "No user card_type provided";
            }
            if(!isset($_REQUEST['card_number'])){
                return "No user card_number provided";
            }
            if(!isset($_REQUEST['card_validity'])){
                return "No user card_validity provided";
            }

            //Open Database connection
            $DB_connection = new BusPhoneConnection();

            //Check for database error
            if($DB_connection->has_error()){
                return $DB_connection->get_error();
            }

            //Register user
            $result = $DB_connection->login($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['pass'], $_REQUEST['card_type'], $_REQUEST['card_number'], $_REQUEST['card_validity']);

            //Close database connection
            $DB_connection->close();

            return $result;
        }
     }

     protected function validate_ticket() {
        if ($this->method == 'GET') {
        	//Check for the ticket id request
        	if(!isset($_REQUEST['ticket_id'])){
        		return "No ticket id provided";
        	}

        	//Open Database connection
        	$DB_connection = new BusPhoneConnection();

        	//Check for database error
        	if($DB_connection->has_error()){
        		return $DB_connection->get_error();
        	}

        	//Requested ticket it
        	$ticket_id = $_REQUEST['ticket_id'];

        	//Check if it exists in database available
        	$result = $DB_connection->validate_ticket($ticket_id);

        	//Close database connection
        	$DB_connection->close();

            return $result;
        } else {
            return "Wrong method";
        }
     }

     protected function get_user_tickets() {
        if ($this->method == 'GET') {
            //Check for the ticket id request
            if(!isset($_REQUEST['email'])){
                return "No user email provided";
            }

            //Open Database connection
            $DB_connection = new BusPhoneConnection();

            //Check for database error
            if($DB_connection->has_error()){
                return $DB_connection->get_error();
            }

            //Requested ticket it
            $email = $_REQUEST['email'];

            //Check if it exists in database available
            $result = $DB_connection->get_tickets_by_user($email);

            //Close database connection
            $DB_connection->close();

            return $result;
        }
     }

     protected function get_used_tickets() {
        if ($this->method == 'GET') {
            //Check for the ticket id request
            if(!isset($_REQUEST['email'])){
                return "No user email provided";
            }

            //Open Database connection
            $DB_connection = new BusPhoneConnection();

            //Check for database error
            if($DB_connection->has_error()){
                return $DB_connection->get_error();
            }

            //Requested ticket it
            $email = $_REQUEST['email'];

            //Check if it exists in database available
            $result = $DB_connection->get_used_tickets_by_user($email);

            //Close database connection
            $DB_connection->close();

            return $result;
        }
     }

     protected function get_unused_tickets() {
        if ($this->method == 'GET') {
            //Check for the ticket id request
            if(!isset($_REQUEST['email'])){
                return "No user email provided";
            }

            //Open Database connection
            $DB_connection = new BusPhoneConnection();

            //Check for database error
            if($DB_connection->has_error()){
                return $DB_connection->get_error();
            }

            //Requested ticket it
            $email = $_REQUEST['email'];

            //Check if it exists in database available
            $result = $DB_connection->get_unused_tickets_by_user($email);

            //Close database connection
            $DB_connection->close();

            return $result;
        }
     }

     protected function user(){
        if ($this->method == 'GET') {
            //Check for the user request
            if(!isset($_REQUEST['email'])){
                return "No email provided";
            }

            //Open Database connection
            $DB_connection = new BusPhoneConnection();

            //Check for database error
            if($DB_connection->has_error()){
                return $DB_connection->get_error();
            }

            //Requested ticket it
            $email = $_REQUEST['email'];

            //Check if it exists in database available
            $result = $DB_connection->get_user_by_username( $email );

            //Close database connection
            $DB_connection->close();

            return $result;
        } else{
            return "Wrong method";
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