<?php

class Country extends Application
{
    public function getCountries()
    {
        $sql = "SELECT * FROM countries ORDER BY name ASC;";

        return $this->db->fetchAll($sql);
    }

    public function getCountry($id = null)
    {
        if (!empty($id)){
            $sql = "SELECT * FROM countries WHERE id = ?;";
            $this->db->prepare($sql);
            $this->db->bind('i', array($id));

            return $this->db->single();
        }
    }
}