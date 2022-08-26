<?php

class User extends Application {

    private $_table = 'clients';

    public $_id;

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function verifyUser($email, $password)
    {
        $sql = "SELECT * FROM $this->_table WHERE email = ? AND active = ?;";

        $this->db->prepare($sql);
        $this->db->bind('si', array($email, 1));
        $user = $this->db->single();

        if (!empty($user)){
            if (password_verify($password, $user['password'])){
                $this->_id = $user['id'];
                return true;
            }
        }
        return false;
    }

    /**
     * @param null $params
     * @param null $password
     * @return bool
     */
    public function addUser($params = null, $password = null)
    {
        if (!empty($params) & !empty($password)){

            $types = $placeHolders = $values = $keys = array();
            foreach ($params as $key => $value){
                $keys[] = $key;
                $values[] = $value;
                $types[] = 's';
                $placeHolders[] = '?';
            }

            $types = implode('', $types);
            $placeHolders = implode(',', $placeHolders);
            $keys = implode(',', $keys);

            $sql = "INSERT INTO $this->_table ($keys)
                    VALUES ($placeHolders)";

            $this->db->prepare($sql);
            $this->db->bind($types, $values);

            if ($this->db->execute()){
                $this->_id = $this->db->lastInsertId();

                $emailObj = new Email();

                if ($emailObj->process(1, array(
                    'email' => $params['email'],
                    'first_name' => $params['first_name'],
                    'last_name' => $params['last_name'],
                    'password' => $password,
                    'hash' => $params['hash']
                ))){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getUserById($id = null)
    {
        if (!empty($id)) {

            $sql = "SELECT * FROM $this->_table WHERE id = ? AND active = ?";

            $this->db->prepare($sql);
            $this->db->bind('ii', array($id, 1));

            return $this->db->single();
        }
    }

    /**
     * @param null $hash
     * @return mixed
     */
    public function getUserByHash($hash = null)
    {
        if (!empty($hash)) {

            $sql = "SELECT * FROM $this->_table WHERE hash = ?";

            $this->db->prepare($sql);
            $this->db->bind('s', array($hash));

            return $this->db->single();
        }
    }

    /**
     * @param null $email
     * @return mixed
     */
    public function getUserByEmail($email = null)
    {
        if (!empty($email)) {

            $sql = "SELECT * FROM $this->_table WHERE email = ? AND active = ?";

            $this->db->prepare($sql);
            $this->db->bind('si', array($email, 1));

            return $this->db->single();
        }
    }

    /**
     * @param null $id
     * @return bool
     */
    public function activateUser($id = null)
    {
        if (!empty($id)) {
            $sql = "UPDATE $this->_table SET active = ? WHERE id = ?";

            $this->db->prepare($sql);
            $this->db->bind('ii', array(1, $id));
            return $this->db->execute();
        }
    }

    /**
     * @param null $id
     * @param null $array
     * @return bool
     */
    public function updateUser($id = null, $array = null)
    {
        if (!empty($id) && !empty($array)){

            $keys = $types = $values = array();
            foreach ($array as $key => $value){
                $keys[] = $key;
                $values[] = $value;
                $types[] = 's';
            }

            $types[] = 'i';
            $values[] = $id;
            $types = implode('', $types);
            $keys = implode(' = ?, ', $keys) . ' = ?';

            $sql = "UPDATE $this->_table SET $keys WHERE id = ?;";

            $this->db->prepare($sql);
            $this->db->bind($types, $values);
            if ($this->db->execute()){
                return true;
            }
        }
        return false;
    }

    /**
     * @param null $search
     * @return mixed
     */
    public function getUsers($search = null)
    {
        $sql = "SELECT * FROM $this->_table WHERE active = 1 ";
        $types = null;
        $array = array();
        if (!empty($search)){
            $sql .= "AND first_name LIKE ? OR last_name LIKE ? ";
            $types = 'ss';
            $array = array('%'.$search.'%', '%'.$search.'%');
        }
        $sql .= "ORDER BY first_name, last_name ASC;";

        $this->db->prepare($sql);
        $this->db->bind($types, $array);
        return $this->db->resultSet();
    }

    /**
     * @param null $id
     * @return bool
     */
    public function removeUser($id = null)
    {
        if (!empty($id)){
            $sql = "DELETE FROM $this->_table WHERE id = ?;";
            $this->db->prepare($sql);
            $this->db->bind('i', $id);
            return $this->db->execute();
        }
    }

    /**
     * @return null
     */
    public function getClientsReport()
    {
        $sql = "SELECT clients.id, clients.first_name, clients.last_name, COUNT(orders.client) AS total 
                FROM clients 
                LEFT JOIN orders ON clients.id = orders.client 
                WHERE clients.active = 1 
                GROUP BY orders.client 
                ORDER BY total DESC;";

        return $this->db->fetchAll($sql);
    }
}