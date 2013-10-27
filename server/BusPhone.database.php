<?php

class BusPhoneConnection
{

	protected $connection = null; 

	public function __construct() {
        // https://mysqladmin.amen.pt/phpmyadmin/?language=por
        $connection = mysqli_connect("hostingmysql116.amen.pt", "BM36_cmov", "cmov_feup", "plusquare_pt_bus_phone");
    }

    //Check for connection error
    public function has_error(){
    	if (mysqli_connect_errno($connection)){
			return true;
		}
		return false;
    }

    //Get connection error
    public function get_error(){
		if (mysqli_connect_errno($connection)){
			return "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		return null;
    }

    //Close connection
    public function close(){
		mysqli_close($con);
    }
}