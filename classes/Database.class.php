<?php

/**
 * The Database class controls any commands and data sent to and from the db.
 *
 * Example usage:
 * $database = new Database();
 * $database->query('SELECT * FROM table_name');
 * $results = $database->getAll();
 *
 */
class Database
{

  /**
   * @var object $db   Contains the PDO object that connects to the db
   * @var object $stmt The SQL being sent to the db
   */
  private $db;
  private $stmt;

  /**
   * Database constructor
   *
   */
  public function __construct()
  {
    // Try connecting to the db and if it fails, echo a message on the screen
    try
    {
    	// Creating the PDO object with the database information (variables from config.php)
    	$this->db = new PDO("mysql:host=" . $GLOBALS['DB_HOST'] . ";dbname=" . $GLOBALS['DB_NAME'] .";port=" . $GLOBALS['DB_PORT'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASS']);
    	// Setting the different attributes we need on the connection
    	$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
    	// NOTE: To echo the actual error, add '. $e->getMessage()' to the end of the line
    	echo "Could not connect to the database.";
    	exit;
    }
  }

  /**
   * Prepares a SQL query to be sent
   *
   * @var string $query The SQL query to be sent
   */
   public function query($query)
   {
     $this->stmt = $this->db->prepare($query);
   }

  /**
   * Binds values to the parameters in the SQL statement
   *
   * @var string|int|bool|null $param The parameter in the SQL statement to be replaced
   * @var string|int|bool|null $value The actual data to be put in the SQL statement
   * @var object               $type  Constant to be used for the type of value
   */
  public function bind($param, $value, $type = null)
  {
    // If no type has been set, browse the types and set the correct one
    if (is_null($type))
    {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
    }
    // Bind the value to the statement
    $this->stmt->bindValue($param, $value, $type);
  }

  /**
   * Actually executes the SQL statement
   *
   * @return object $stmt Excuted statement
   */
   public function execute()
   {
     return $this->stmt->execute();
   }

  /**
   * Gets all of the rows from the SQL statement
   *
   * @return array A multidimensional array of all the information that matches
   */
  public function getAll()
  {
    // Executing the query created on construction
    $this->execute();
    // Returning all of the rows from the query
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Gets one row from the db that matches SQL statement
   *
   * @return array An array with one of the matches from the db
   */
  public function getOne()
  {
    // Executing the query created on construction
    $this->execute();
    // Returning one row from the query
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Returns the number of rows effected by the query
   */
  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  /**
   * Returns the ID of the last row effected by the query
   */
  public function lastInsertId()
  {
    return $this->db->lastInsertId();
  }

  /**
   * Begins a transaction with the db
   */
  public function beginTransaction()
  {
    return $this->db->beginTransaction();
  }

   /**
    * Ends and commits a transaction to the db
    */
   public function endTransaction()
   {
     return $this->db->commit();
   }

   /**
    * Cancels a transaction with the db
    */
   public function cancelTransaction()
   {
     return $this->db->rollBack();
   }

}
