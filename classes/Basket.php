<?php

class Basket
{

    public $_catalogObj;
    public $_is_empty;
    public $_vat_rate;
    public $_num_of_items;
    public $_vat;
    public $_sub_total;
    public $_total;

    public function __construct()
    {
        $this->_catalogObj = new Catalog();
        $this->_is_empty = (empty($_SESSION['basket'])) ? true : false;

        $businessObj = new Business();
        $this->_vat_rate = $businessObj->getVatRate();

        $this->numOfItems();
        $this->subTotal();
        $this->vat();
        $this->total();
    }

    public function numOfItems()
    {
        $items = 0;
        if (!$this->_is_empty) {
            foreach ($_SESSION['basket'] as $key => $basket) {
                $items += $basket['quantity'];
            }
        }
        $this->_num_of_items = $items;
    }

    public function subTotal()
    {
        $subTotal = 0;
        if (!$this->_is_empty) {
            foreach ($_SESSION['basket'] as $key => $basket) {
                $product = $this->_catalogObj->getProduct($key);
                $subTotal += ($basket['quantity'] * $product['price']);
            }
        }
        $this->_sub_total = round($subTotal, 2);
    }

    public function vat()
    {
        $vat = 0;
        if (!$this->_is_empty) {
            $vat = $this->_vat_rate * ($this->_sub_total / 100);
        }
        $this->_vat = round($vat, 2);
    }

    public function total()
    {
        $this->_total = round($this->_vat + $this->_sub_total, 2);
    }

    public function itemTotal($price, $quantity)
    {
        if (!empty($price) && !empty($quantity)) {
            return round($price * $quantity, 2);
        }
    }

    //    public static function buttonActive($product_id)
    //    {
    //        if (isset($_SESSION['basket'][$product_id])){
    //            $job = 0;
    //            $label = 'remove from basket';
    //        } else {
    //            $job = 1;
    //            $label = 'add to basket';
    //        }
    //
    //        $button = '<a href="#" class="add_to_basket ';
    //        $button .= ($job == 0)? 'red"': '" ';
    //        $button .= 'rel="' . $product_id . '_' . $job . '">';
    //        $button .= $label . '</a>';
    //        return $button;
    //    }

    public static function buttonActive($product_id)
    {
        if (isset($_SESSION['basket'][$product_id])) {
            $job = 0;
            $label = 'Remove from Cart';
        } else {
            $job = 1;
            $label = 'Add to Cart';
        }

        $button = '<a href="#" class="add_to_basket btn btn-sm ';
        $button .= ($job == 0) ? 'btn-danger"' : 'btn-primary" ';
        $button .= 'rel="' . $product_id . '_' . $job . '">';
        $button .= $label . '</a>';
        return $button;
    }

    //    public static function removeButton($product_id)
    //    {
    //        if (!empty($product_id)){
    //            if (isset($_SESSION['basket'][$product_id])) {
    //                $button = '<a href="#" class="remove_basket red" rel="'.$product_id.'">Remove</a>';
    //                return $button;
    //            }
    //        }
    //    }

    public static function removeButton($product_id = null)
    {
        if (!empty($product_id)) {
            if (isset($_SESSION['basket'][$product_id])) {
                $button = '<span class="remove_basket btn btn-xs btn-danger" rel="' . $product_id . '">Remove</span>';
                return $button;
            }
        }
    }
}
