<?php

class Business extends Application
{
    private $_table = 'business';
    private $_table_account = 'accounts';


    public function getBusiness()
    {
        $sql = "SELECT * FROM $this->_table WHERE id = 1";
        return $this->db->fetchOne($sql);
    }

    public function getVatRate()
    {
    	$business = $this->getBusiness();
    	return $business['vat_rate'];
    }

    public function updateBusiness($array = null)
    {
        if (!empty($array)){

            $keys = $types = $values = array();
            foreach ($array as $key => $value){
                $keys[] = $key;
                $values[] = $value;
                $types[] = 's';
            }
            $types = implode('', $types);
            $keys = implode(' = ?, ', $keys) . ' = ?';

            $sql = "UPDATE $this->_table SET $keys WHERE id = 1;";
            $this->db->prepare($sql);
            $this->db->bind($types, $values);
            return $this->db->execute();
        }
        return false;
    }

    public function getAccountInfo()
    {
        $sql = "SELECT * FROM $this->_table_account 
                LEFT JOIN countries ON $this->_table_account.country = countries.id 
                WHERE business = 1;";
        return $this->db->fetchOne($sql);
    }

    public function updateAccountInfo($array = null)
    {
        if (!empty($array)){

            $keys = $types = $values = array();
            foreach ($array as $key => $value){
                $keys[] = $key;
                $values[] = $value;
                $types[] = 's';
            }
            $types = implode('', $types);
            $keys = implode(' = ?, ', $keys) . ' = ?';

            $sql = "UPDATE $this->_table_account SET $keys WHERE business = 1;";
            $this->db->prepare($sql);
            $this->db->bind($types, $values);
            return $this->db->execute();
        }
        return false;
    }
}