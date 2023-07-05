<?php
class Employee
{
    // Connection
    private $conn;
    // Table
    private $db_table = "employee";
    // Columns
    public $id;
    public $tanggal;
    public $nama;
    public $tema;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // GET ALL
    public function getEmployees()
    {
        $sqlQuery = "SELECT id, tanggal, nama, tema FROM "
            . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createEmployee()
    {
        $sqlQuery = "INSERT INTO
            " . $this->db_table . "
            SET
            tanggal = :tanggal, 
            nama = :nama, 
            tema = :tema";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->tema = htmlspecialchars(strip_tags($this->tema));
        // bind data
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":tema", $this->tema);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleEmployee()
    {
        $sqlQuery = "SELECT
            id, 
            tanggal, 
            nama, 
            tema
            FROM
            " . $this->db_table . "
            WHERE 
            id = ?
            LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->tanggal = $dataRow['tanggal'];
        $this->nama = $dataRow['nama'];
        $this->tema = $dataRow['tema'];
    }
    // UPDATE
    public function updateEmployee()
    {
        $sqlQuery = "UPDATE
            " . $this->db_table . "
            SET
            tanggal = :tanggal, 
            nama = :nama, 
            tema = :tema
            WHERE 
            id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->tema = htmlspecialchars(strip_tags($this->tema));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":tema", $this->tema);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // DELETE
    function deleteEmployee()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
