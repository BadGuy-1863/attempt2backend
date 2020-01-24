<?php

/**
 * A class file to connect to database
 */
class DatabaseConnect {

    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }

    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }

    /**
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        require_once 'dbConfig.php';

        // Connecting to mysql database
        $con = mysqli_connect("localhost", "root", "WhateverPassword") or die(mysqli_error($con));

        // Selecing database
        $db = mysqli_select_db($con, "mydatabase") or die(mysqli_error()) or die(mysqli_error());

        // returing connection cursor
        return $con;
    }

    /**
     * Function to close db connection
     */
    function close() {
        // closing db connection
        mysqli_close($this->connect());
    }

}

?>
