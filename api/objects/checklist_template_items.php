<?php
class ChecklistTemplateItems
{

    // database connection and table name
    private $conn;
    private $table_name = "checklist_templates_items";

    // object properties
    public $Item_ID;
    public $List_ID;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // create user
    function create()
    {

        // query to insert record
        $query = "INSERT INTO
               " . $this->table_name . " SET               
               Item_ID=:Item_ID, 
               List_ID=:List_ID
               ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Item_ID = htmlspecialchars(strip_tags($this->Item_ID));
        $this->List_ID = htmlspecialchars(strip_tags($this->List_ID));


        // bind values
        $stmt->bindParam(":Item_ID", $this->Item_ID);
        $stmt->bindParam(":List_ID", $this->List_ID);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete 
    function deleteItem()
    {

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE Item_ID = " . htmlspecialchars(strip_tags($this->Item_ID));

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete 
    function deleteList()
    {

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE List_ID = " . htmlspecialchars(strip_tags($this->List_ID));

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
