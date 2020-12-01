<?php
class CheckItems
{

    // database connection and table name
    private $conn;
    private $table_name = "checkitems";
    private $templateitems_table = "checklist_templates_items";

    // object properties
    public $ID;
    public $Name;
    public $Description;
    public $Unit_of_measure;
    public $List_ID;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // read Items
    function read()
    {

        // select all query
        $query = "SELECT *  FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    
    // read Items
    function readById()
    {

        $this->ID = htmlspecialchars(strip_tags($this->ID));
        // select all query
        $query = "SELECT *  FROM " . $this->table_name ." WHERE ID = ".$this->ID;
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        if($template = $stmt->fetch(PDO::FETCH_ASSOC)){
            $this->Name = $template['Name'];
            $this->Description  = $template['Description'];
            $this->Unit_of_measure = $template['Unit_of_measure'];
            return true;
        }
        return false;
    }

    function readByListID_OLD()
    {

        $query = "SELECT 
        " . $this->table_name . ".ID, 
        " . $this->table_name . ".Name, 
        " . $this->table_name . ".Description, 
        " . $this->table_name . ".Unit_of_measure, 
        " . $this->templateitems_table . ".List_ID 
        FROM " . $this->table_name .
            " INNER JOIN " . $this->templateitems_table . "
        ON " . $this->table_name . ".ID=" . $this->templateitems_table . ".Item_ID 
        WHERE " . $this->templateitems_table . ".List_ID = ?";

        $stmt = $this->conn->prepare($query);

        $this->List_ID = htmlspecialchars(strip_tags($this->List_ID));

        $stmt->bindParam(1, $this->List_ID);

        $stmt->execute();

        return $stmt;
    }

    function readByListID()
    {

        $query = " SELECT ct.ID, ci.Name, cti.Item_ID as Item_ID, cl.ID as Cheklist_ID, ct.Machine_ID, ct.Frequency, cl.Date_Time 
        FROM `checklist_templates` ct
        Left Join `checklist_templates_items` cti on cti.List_ID = ct.ID 
        left join `checkitems` ci on ci.ID = cti.Item_ID
        Left join `checklist` cl on cl.Template_ID = ct.ID AND cl.Machine_ID = ct.Machine_ID AND cl.Item_ID = cti.Item_ID 
        AND ( ( ct.Frequency = 1 AND DATE(Date_Time) = DATE(NOW()) ) /*danas*/ 
        OR ( ct.Frequency = 2 AND YEARWEEK(`Date_Time`, 1) = YEARWEEK(CURDATE(), 1)) /*ovaj tjedan*/ 
        OR ( ct.Frequency = 3 AND MONTH(`Date_Time`) = MONTH(CURDATE()) ) /*Ovaj misec*/ ) 
        WHERE ct.ID = ?";

        $stmt = $this->conn->prepare($query);

        $this->List_ID = htmlspecialchars(strip_tags($this->List_ID));

        $stmt->bindParam(1, $this->List_ID);

        $stmt->execute();

        return $stmt;
    }



    public function readLast()
    {
        // select all query
        $query = "SELECT
                    *
            FROM " . $this->table_name . "
        ORDER BY ID DESC LIMIT 1";
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
        $query = "INSERT INTO
               " . $this->table_name . " SET               
               Name=:Name, 
               Description=:Description, 
               Unit_of_measure=:Unit_of_measure";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Unit_of_measure = htmlspecialchars(strip_tags($this->Unit_of_measure));



        // bind values
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":Unit_of_measure", $this->Unit_of_measure);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function update()
    {

        $this->ID = htmlspecialchars(strip_tags($this->ID));
        // query to insert record
        $query = "UPDATE ". $this->table_name . " SET Name=:Name , Description=:Description , Unit_of_measure=:Unit_of_measure  WHERE ID = ".$this->ID;

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Unit_of_measure = htmlspecialchars(strip_tags($this->Unit_of_measure));
        
        // bind values
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":Unit_of_measure", $this->Unit_of_measure);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    // delete the item
    function delete()
    {

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE ID = ?";

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
}
