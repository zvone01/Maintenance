<?php
class Machine{
 
    // database connection and table name
    private $conn;
    private $table_name = "machine";
 
    // object properties
    public $ID;
    public $Name;
    public $Description;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read users
    function read(){
    
        // select all query
        $query = "SELECT *  FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create user
function create(){
 
    // query to insert record
    $query = "INSERT INTO
               " . $this->table_name . " SET Name=:Name, Description=:Description";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
 
    // bind values
    $stmt->bindParam(":Name", $this->Name);
    $stmt->bindParam(":Description", $this->Description);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// delete the user
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE ID = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->ID=htmlspecialchars(strip_tags($this->ID));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->ID);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function get_machine()
{
   // delete query
   $query = "SELECT * FROM " . $this->table_name . " WHERE Name =:Name";
 
   // prepare query
   $stmt = $this->conn->prepare($query);

   // sanitize
   $this->Name=htmlspecialchars(strip_tags($this->Name));
  

   
   $stmt->bindParam(":Name", $this->Name);
   

  $stmt->execute();
  return $stmt;

}

function readOne(){
 
    $this->ID=htmlspecialchars(strip_tags($this->ID));

    // query to read single record
    $query = "SELECT *  FROM " . $this->table_name . " WHERE ID = ".$this->ID;

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    
    // execute query
    $stmt->execute();
 
    if($stmt->rowCount() < 1)
        return false;
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->Name = $row['Name'];
    $this->Description = $row['Description'];
    return true;
}


function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Name = :Name ,
                Description = :Description           
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':Name', $this->Name);
    $stmt->bindParam(':Description', $this->Description);
    $stmt->bindParam(':ID', $this->ID);
    
    // execute the query
    if($stmt->execute()){
        return true;
    }
    return false;

}

function updateName(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Name = :Name            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Password=htmlspecialchars(strip_tags($this->Name));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':Password', $this->Name);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}

function updateDescription(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
            Description = :Description            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':Description', $this->Description);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}

}