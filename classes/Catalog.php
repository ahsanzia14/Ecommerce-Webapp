<?php

class Catalog extends Application
{
    public $_id;
    private $_categories_table = 'categories';
    private $_products_table = 'products';

    public static $_image_path = 'media/catalog/';
    public static $_currency = '&dollar; ';

    /**
     * @return null
     */
    public function getCategories()
    {
        $sql = "SELECT * FROM $this->_categories_table ORDER BY name ASC;";
        return $this->db->fetchAll($sql);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategory($id)
    {
        $sql = "SELECT * FROM $this->_categories_table WHERE id = ?;";
        $this->db->prepare($sql);
        $this->db->bind('i', array($id));
        return $this->db->single();
    }

    /**
     * @param null $search
     * @return mixed
     */
    public function getAllCategory($search = null)
    {
        if (!empty($search)){
            $sql = "SELECT * FROM $this->_categories_table WHERE `name` LIKE ? OR id = ?;";
            $this->db->prepare($sql);
            $this->db->bind('ss', array('%'.$search.'%', $search));
            return $this->db->resultSet();
        }
    }

    /**
     * @param $cat
     * @return mixed
     */
    public function getProducts($cat)
    {
        $sql = "SELECT * FROM $this->_products_table WHERE category = ? ORDER BY date DESC;";
        $this->db->prepare($sql);
        $this->db->bind('i', array($cat));
        return $this->db->resultSet();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProduct($id)
    {
        $sql = "SELECT * FROM $this->_products_table WHERE id = ?;";
        $this->db->prepare($sql);
        $this->db->bind('i', array($id));
        return $this->db->single();
    }

    /**
     * @param null $search
     * @return null
     */
    public function getAllProducts($search = null)
    {
        $sql = "SELECT * FROM $this->_products_table ";
        if (!empty($search)){
            $sql .= "WHERE name LIKE ? || id = ? ";
        }
        $sql .= "ORDER BY `date` DESC;";

        if (!empty($search)){
            $this->db->prepare($sql);
            $this->db->bind('ss', array('%'.$search.'%', $search));
            return $this->db->resultSet();
        }

        return $this->db->fetchAll($sql);
    }

    /**
     * @param null $params
     * @return bool
     */
    public function addProduct($params = null)
    {
        if (!empty($params)){
            $types = $keys = $values = $placeHolders = array();
            foreach($params as $key => $value){
                $keys[] = $key;
                $values[] = $value;
                $types[] = 's';
                $placeHolders[] = '?';
            }

            $types = implode('', $types);
            $keys = implode(', ', $keys);
            $placeHolders = implode(', ', $placeHolders);

            $sql = "INSERT INTO $this->_products_table ($keys) VALUES($placeHolders);";
            $this->db->prepare($sql);
            $this->db->bind($types, $values);

            if ($this->db->execute()){
                $this->_id = $this->db->_id;
                return true;
            }
        }
        return false;
    }

    /**
     * @param null $array
     * @param null $id
     * @return bool
     */
    public function updateProduct($array = null, $id = null)
    {
        if (!empty($array) && !empty($id)){
            $types = $keys = $values = array();
            foreach ($array as $key => $value){
                $keys[] = $key.' = '.'?';
                $values[] = $value;
                $types[] = 's';
            }
            $values[] = $id;
            $types[] = 'i';
            $keys = implode(', ', $keys);
            $types = implode('', $types);

            $sql = "UPDATE $this->_products_table SET $keys WHERE id = ?;";
            $this->db->prepare($sql);
            $this->db->bind($types, $values);
            return $this->db->execute();
        }
        return false;
    }

    /**
     * @param null $id
     * @return bool
     */
    public function removeProduct($id = null)
    {
        if (!empty($id)){
            $sql = "DELETE FROM $this->_products_table WHERE id = ?;";
            $this->db->prepare($sql);
            $this->db->bind('i', $id);
            return $this->db->execute();
        }
    }

    /**
     * @param null $array
     * @return bool
     */
    public function addCategory($array = null)
    {
        if (!empty($array)){
            $sql = "INSERT INTO $this->_categories_table(`name`) VALUES(?);";
            $this->db->prepare($sql);
            $this->db->bind('s', $array['name']);
            return $this->db->execute();
        }
        return false;
    }

    /**
     * @param null $array
     * @param null $id
     * @return bool
     */
    public function updateCategory($array = null, $id = null)
    {
        if (!empty($array) && !empty($id)){
            $sql = "UPDATE $this->_categories_table SET `name` = ? WHERE id = ?;";
            $this->db->prepare($sql);
            $this->db->bind('si', array($array['name'], $id));
            return $this->db->execute();
        }
        return false;
    }

    /**
     * @param null $id
     * @return bool
     */
    public function removeCategory($id = null)
    {
        if (!empty($id)){
            $sql = "DELETE FROM $this->_categories_table WHERE id = ?;";
            $this->db->prepare($sql);
            $this->db->bind('i', $id);
            return $this->db->execute();
        }
    }

    /**
     * @return null
     */
    public function getReport()
    {
        $sql = "SELECT categories.id, categories.name, COUNT(category) AS total 
                FROM categories 
                LEFT JOIN products ON products.category = categories.id 
                GROUP BY category 
                ORDER BY total DESC;";

        $result = $this->db->fetchAll($sql);

        if (!empty($result)){
            $total = 0;
            foreach ($result as $row){
                $total += $row['total'];
            }
            $result['total'] = $total;
            return $result;
        }
        return null;
    }

    public function getStock()
    {
        $sql = "SELECT * FROM products ORDER BY qty, `date` DESC;";
        return $this->db->fetchAll($sql);
    }
}