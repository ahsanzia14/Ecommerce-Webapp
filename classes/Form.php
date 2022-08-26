<?php

class Form
{

    /**
     * @param null $field
     * @return bool
     */
    public function isPost($field = null)
    {
        if (!empty($field)){
            if (isset($_POST[$field])){
                return true;
            }
            return false;
        } else {
            if (isset($_POST)){
                return true;
            }
            return false;
        }
    }

    /**
     * @param null $field
     * @return null|string
     */
    public function getPost($field = null)
    {
        if (!empty($field)){
            return ($this->isPost($field))? strip_tags($_POST[$field]): null;
        }
    }

    /**
     * @param $field
     * @param $value
     * @param null $default
     * @return null|string
     */
    public function stickySelect($field, $value, $default = null)
    {
        if ($this->isPost($field) && $this->getPost($field) == $value){
            return 'selected="selected"';
        } else {
            return (!empty($default) && $default == $value)? 'selected="selected"': null;
        }
    }

    /**
     * @param $field
     * @param null $value
     * @return null|string
     */
    public function stickyText($field, $value = null)
    {
        if ($this->isPost($field)){
            return stripslashes($this->getPost($field));
        } else {
            return (!empty($value))? $value: null;
        }
    }

    /**
     * @param null $expected
     * @return array
     */
    public function getPostArray($expected = null)
    {
        if ($this->isPost()) {

            $out = array();
            foreach ($_POST as $key => $value) {

                if (!empty($expected)) {

                    if (in_array($key, $expected)) {
                        $out[$key] = strip_tags($value);
                    }
                    
                } else {
                    $out[$key] = strip_tags($value);
                }
            }
        }
        return $out;
    }

    /**
     * @param null $record
     * @return string
     */
//    public function getCountriesList($record = null){
//
//        $countryObj = new Country();
//        $countries = $countryObj->getCountries();
//
//        if (!empty($countries)){
//            $out = '<Select name="country" id="country" class="sel">';
//
//            if (empty($record)){
//                $out .= '<option value="">Select Country...</option>';
//            }
//
//            foreach ($countries as $key => $country){
//                $out .= '<option value="' .$country['id']. '" ';
//                $out .= $this->stickySelect('country', $country['id'], $record) .'>';
//                $out .= $country['name'];
//                $out .= '</option>';
//            }
//
//            $out .= '</select>';
//
//            return $out;
//        }
//    }

    public function getCountriesList($record = null){

        $countryObj = new Country();
        $countries = $countryObj->getCountries();

        if (!empty($countries)){
            $out = '<Select name="country" id="country" class="form-control">';

            if (empty($record)){
                $out .= '<option value="">Select Country...</option>';
            }

            foreach ($countries as $key => $country){
                $out .= '<option value="' .$country['id']. '" ';
                $out .= $this->stickySelect('country', $country['id'], $record) .'>';
                $out .= $country['name'];
                $out .= '</option>';
            }

            $out .= '</select>';

            return $out;
        }
    }
}