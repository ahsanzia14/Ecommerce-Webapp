<?php

class Database
{
    private $_host = 'localhost';
    private $_user = 'root';
    private $_password = 'admin123';
    private $_db_name = 'pinna';

    private $_conn = false;
    private $_stmt = false;

    public $_last_query = null;

    public $_affected_rows = 0;
    // public $_insert_keys = array();
    // public $_insert_values = array();

    public $_update_sets = array();

    public $_id;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->_conn = new mysqli($this->_host, $this->_user, $this->_password, $this->_db_name);

        if ($this->_conn->connect_errno) {
            die('Database Connection Failed: ' . $this->_conn->connect_error);
        } else {
            $this->_conn->set_charset('utf8');
        }
    }

    public function close()
    {
        if (!$this->_conn->close()) {
            die('Closing Connection Failed.');
        }
    }

    public function fetchOne($sql)
    {
        $result = $this->_conn->query($sql);
        if ($result->num_rows) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function fetchAll($sql)
    {
        $result = $this->_conn->query($sql);
        if ($result->num_rows) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function prepare($sql)
    {
        $this->_stmt = $this->_conn->stmt_init();
        $this->_stmt = $this->_conn->prepare($sql);
    }

    public function bind($type = null, $values = array())
    {
        if (!empty($type) && !empty($values)) {

            $params[] = &$type;
            $values = is_array($values) ? $values : array($values);

            for ($i = 0; $i < strlen($type); $i++) {
                $params[] = &$values[$i];
            }

            call_user_func_array(array($this->_stmt, 'bind_param'), $params);

            /* if (strlen($type) === count($values)) {
                for ($c = 0; $c < strlen($type); $c++) {
                    $this->_stmt->bind_param($type[$c], $values[$c]);
                }
            } */
        }
    }

    public function remove()
    {
        return $this->_stmt->execute();
    }

    public function execute()
    {
        if ($this->_stmt->execute()) {
            $this->_id = $this->lastInsertId();
            return true;
        }
        return false;
    }

    public function closeStatement()
    {
        $this->_stmt->close();
    }

    public function single()
    {
        if ($this->_stmt->execute()) {
            $result = $this->_stmt->get_result();
            return $result->fetch_assoc();
        }
    }

    public function resultSet()
    {
        if ($this->_stmt->execute()) {
            $result = $this->_stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function rowCount()
    {
        return $this->_stmt->affected_rows;
    }

    public function lastInsertId()
    {
        return $this->_stmt->insert_id;
    }

    public function beginTransaction()
    {
        return $this->_conn->begin_transaction();
    }

    public function endTransaction()
    {
        return $this->_conn->commit();
    }

    public function cancelTransaction()
    {
        return $this->_conn->rollback();
    }
}

/* class Database
{

    private $host = 'localhost';
    private $db_name = 'ecommerce';
    private $pass = '03451481947';
    private $user = 'root';

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8;';
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = NULL)
    {

        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single()
    {
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }
} */
