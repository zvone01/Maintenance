<?php
class ChecklistTemplate
{

    //checklist_templates
    private $conn;
    
    public $ID;
    public $Name;
    public $Machine_ID;
    public $Frequency;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    function read()
    {

        // select all query
        $query = "SELECT *  FROM checklist_templates";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //get one template
    function readByID()
    {

        $this->ID = htmlspecialchars(strip_tags($this->ID));
        // select all query
        $query = "SELECT *  FROM checklist_templates Where ID= ". $this->ID;
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        if($template = $stmt->fetch(PDO::FETCH_ASSOC)){
            $this->Name = $template['Name'];
            $this->Machine_ID  = $template['Machine_ID'];
            $this->Frequency = $template['Frequency'];
            return true;
        }
        
        return false;
   
    }


    function update()
    {

        // query to insert record
        $query = "UPDATE checklist_templates SET Name=:Name, Machine_ID=:Machine_ID, Frequency=:Frequency WHERE ID=:ID";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->ID = htmlspecialchars(strip_tags($this->ID));
        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Machine_ID = htmlspecialchars(strip_tags($this->Machine_ID));
        $this->Frequency = htmlspecialchars(strip_tags($this->Frequency));

        // bind values
        $stmt->bindParam(":ID", $this->ID);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Machine_ID", $this->Machine_ID);
        $stmt->bindParam(":Frequency", $this->Frequency);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readByMachineID($Machine_ID)
    {

        $Machine_ID = htmlspecialchars(strip_tags($Machine_ID));
        // select all query
        $query = "SELECT *  FROM checklist_templates Where Machine_ID= ".$Machine_ID;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function readByMachineIDwithDates($Machine_ID)
    {

        $Machine_ID = htmlspecialchars(strip_tags($Machine_ID));
        // select all query
        $query = "SELECT *, 
        case 
        when Frequency = '1' 
        then curdate()
        when Frequency = '2' 
        then subdate(curdate(), (day(curdate())-1))
        when Frequency = '3' 
        then MAKEDATE(year(now()),1)
        else null 
      end 
      AS StartDate,
       case 
        when Frequency = '1' 
        then curdate()
        when Frequency = '2' 
        then LAST_DAY(curdate())
        when Frequency = '3' 
        then MAKEDATE(year(now()),1)
        else null 
      end 
      AS EndDate          
          FROM checklist_templates Where Machine_ID= ".$Machine_ID;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create user
    function create()
    {

        // query to insert record
        $query = "INSERT INTO checklist_templates SET Name=:Name, Machine_ID=:Machine_ID, Frequency=:Frequency";
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Machine_ID = htmlspecialchars(strip_tags($this->Machine_ID));
        $this->Frequency = htmlspecialchars(strip_tags($this->Frequency));

        // bind values
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Machine_ID", $this->Machine_ID);
        $stmt->bindParam(":Frequency", $this->Frequency);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete the user
    function delete()
    {

        // delete query
        $query = "DELETE FROM checklist_templates WHERE ID = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->ID = htmlspecialchars(strip_tags($this->ID));

        // bind id of record to delete
        $stmt->bindParam(1, $this->ID);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function getChecklistTemplate()
    {
        // delete query
        $query = "SELECT * FROM checklist_templates WHERE ID =:ID";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->ID = htmlspecialchars(strip_tags($this->ID));

        $stmt->bindParam(":ID", $this->ID);


        $stmt->execute();
        return $stmt;
    }
}
