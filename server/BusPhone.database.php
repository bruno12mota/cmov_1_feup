<?php

class BusPhoneConnection
{

	protected $connection = Null; 

	public function __construct() {
        // https://mysqladmin.amen.pt/phpmyadmin/?language=por
        $this->connection = mysqli_connect("hostingmysql116.amen.pt", "BM36_cmov", "cmov_feup", "plusquare_pt_bus_phone");
    }

    //Check for connection error
    public function has_error(){
    	if (mysqli_connect_errno($this->connection)){
			return true;
		}
		return false;
    }

    //Get connection error
    public function get_error(){
		if (mysqli_connect_errno($this->connection)){
			return "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		return null;
    }

    //Close connection
    public function close(){
		mysqli_close($this->connection);
    }

    //Query
    private function query_select($query){
        // Perform Query
        $result = $this->connection->query($query);

        // This shows the actual query sent to MySQL, and the error. Useful for debugging.
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }

        if( $result->num_rows ){
            //$row = mysqli_fetch_assoc($result);
            while($row = mysqli_fetch_assoc ($result)){
                //  cast results to specific data types
                $test_data[]=$row;
            }
            $json['result']=$test_data;
        }

        //Clean
        mysqli_free_result($result);

        return $json;
    }

    private function query_update($query){
        // Perform Query
        $result = $this->connection->query($query);

        // This shows the actual query sent to MySQL, and the error. Useful for debugging.
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }

        $json['result']="success";

        return $json;
    }

    /*
     *  QUERIES
    */

    public function register($user_name, $user_email, $user_pass, $card_type, $card_number, $card_validity){
        $pass = hash('sha256', $user_pass);

        $query = sprintf("INSERT INTO users (`name`, `email`, `password`, `card_type`, `card_number`, `card_validity`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", 
                            $this->connection->real_escape_string ($user_name),
                            $this->connection->real_escape_string ($user_email),
                            $this->connection->real_escape_string ($pass),
                            $this->connection->real_escape_string ($card_type),
                            $this->connection->real_escape_string ($card_number),
                            $this->connection->real_escape_string ($card_validity));

        return $this->query_update($query);
    }

    public function login($user_email, $user_pass){
        $pass = hash('sha256', $user_pass);

        $query = sprintf("SELECT users.name FROM users WHERE users.email='%s' AND users.password='%s'", $this->connection->real_escape_string ($user_email), $pass);

        $result = $this->query_select($query);
        if($result != NULL)
            $json['result'] = array("success" => $result);
        else
            $json['result'] = array("error" => "Login incorrect!");

        return $json;
    }

    //Gets the used tickets of an user
    public function get_tickets_by_user($user_email){
        $query = sprintf("SELECT tickets.* FROM tickets, users, users_tickets WHERE users.email = '%s' AND tickets.ticket_id=users_tickets.ticket_id AND users.user_id = users_tickets.user_id", $this->connection->real_escape_string ($user_email));

        return $this->query_select($query);
    }

    //Gets the used tickets of an user
    public function get_unused_tickets_by_user($user_email){
        $query = sprintf("SELECT tickets.* FROM tickets, users, users_tickets WHERE users.email = '%s' AND tickets.validated='0' AND tickets.ticket_id=users_tickets.ticket_id AND users.user_id = users_tickets.user_id", $this->connection->real_escape_string ($user_email));

        return $this->query_select($query);
    }

    //Gets the used tickets of an user
    public function get_used_tickets_by_user($user_email){
        $query = sprintf("SELECT tickets.* FROM tickets, users, users_tickets WHERE users.email = '%s' AND tickets.validated='1' AND tickets.ticket_id=users_tickets.ticket_id AND users.user_id = users_tickets.user_id", $this->connection->real_escape_string ($user_email));

        return $this->query_select($query);
    }

    //Gets a ticket by id
    public function get_ticket_by_id( $ticket_id ){
        $query = sprintf("SELECT tickets.* FROM tickets WHERE ticket_id='%s'", $this->connection->real_escape_string ($ticket_id));

        return $this->query_select($query);
    }

    //Validate ticket by id
    public function validate_ticket( $ticket_id ){
        //Get ticket
        $ticket = $this->get_ticket_by_id($ticket_id);

        //Check if ticket has already been validated
        if($ticket['result'][0]["validated"] == '1'){
            $json['result']=array("error" => "Ticket already validated");
            return $json;
        }

        //Validate ticket
        $mysqldate = date( 'Y-m-d H:i:s' );
        $query = sprintf("UPDATE tickets SET validated=1, validation_date='%s' WHERE ticket_id='%s'", $mysqldate, $this->connection->real_escape_string ($ticket_id));
        
        return $this->query_update($query);
    }

    public function get_user_by_username( $username ){
        //echo $username;
        $query = sprintf("SELECT users.* FROM users WHERE username='%s'", $this->connection->real_escape_string ($username));
        
        return $this->query_select($query);
    }
}