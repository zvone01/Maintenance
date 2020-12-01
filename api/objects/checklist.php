<?php
class Checklist
{

    //checklist
    private $conn;
    private $table_name = "checklist";

    public $ID;
    public $Template_ID;
    public $Machine_ID;
    public $Item_ID;
    public $Date_Time;
    public $User_ID;
    public $Checked;
    public $Value;
    public $Note;
    public $Failure_ID;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // create user //ovo je da se zbuni neprijatelj koji nikad ne spava
    function save()
    {

        $query = "INSERT INTO
                " . $this->table_name . " SET               
                Template_ID=" . htmlspecialchars(strip_tags($this->Template_ID)) . ",
                Machine_ID=" . htmlspecialchars(strip_tags($this->Machine_ID)) . " ,
                Item_ID=" . htmlspecialchars(strip_tags($this->Item_ID)) . " ,
                Date_Time='" . htmlspecialchars(strip_tags($this->Date_Time)) . "' ,
                User_ID= " . htmlspecialchars(strip_tags($this->User_ID)) . " ,
                Checked=" . htmlspecialchars(strip_tags($this->Checked)) . " ,
                Value=" . htmlspecialchars(strip_tags($this->Value)) . " ,
                Note= '" . htmlspecialchars(strip_tags($this->Note)) . "' ,
                Failure_ID= " . htmlspecialchars(strip_tags($this->Failure_ID));

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        /*  $this->Template_ID = htmlspecialchars(strip_tags($this->Template_ID));
         $this->Machine_ID = htmlspecialchars(strip_tags($this->Machine_ID));
         $this->Item_ID = htmlspecialchars(strip_tags($this->Item_ID));
         $this->Date_Time = htmlspecialchars(strip_tags($this->Date_Time));
         $this->User_ID = htmlspecialchars(strip_tags($this->User_ID));
         $this->Checked = htmlspecialchars(strip_tags($this->Checked));
         $this->Value = htmlspecialchars(strip_tags($this->Value));
         $this->Note = htmlspecialchars(strip_tags($this->Note));
         $this->Failure_ID = htmlspecialchars(strip_tags($this->Failure_ID));*/


        // bind values
        /* $stmt->bindParam(":Template_ID", $this->Template_ID);
         $stmt->bindParam(":Machine_ID", $this->Machine_ID);
         $stmt->bindParam(":Item_ID", $this->Item_ID);
         $stmt->bindParam(":Date_Time", $this->Date_Time);
         $stmt->bindParam(":User_ID", $this->User_ID);
         $stmt->bindParam(":Checked", $this->Checked);
         $stmt->bindParam(":Value", $this->Value);
         $stmt->bindParam(":Note", $this->Note);
         $stmt->bindParam(" :Failure_ID ", $this->Failure_ID);*/
        //print_r($stmt);
        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
