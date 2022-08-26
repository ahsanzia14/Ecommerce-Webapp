<?php

class Admin extends Application
{
    private $_table = 'admins';
    public $_id;

    public function isAdminUser($email = null, $password = null)
    {
        if (!empty($email) && !empty($password)){
            $sql = "SELECT * FROM $this->_table WHERE email = ?;";
            $this->db->prepare($sql);
            $this->db->bind('s', array($email));
            $admin = $this->db->single();

            if (!empty($admin)){
                if (Login::verifyHash($password, $admin['password'])){
                    $this->_id = $admin['id'];
                    return true;
                }
            }
        }
        return false;
    }
}