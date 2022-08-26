<?php

class Paging {

	private $_records;
	private $_num_of_records;
	private $_num_of_pages;
	private $_max_records_per_page;
	private $_current;
	private $_offset = 0;
	public static $_key = 'pg';
	public $_url;

	/**
	 * Paging constructor.
	 * @param $rows
	 * @param int $max
     */
	public function __construct($rows, $max = 10)
	{
		$this->_records = $rows;
		$this->_num_of_records = count($this->_records);
		$this->_max_records_per_page = $max;
		$this->_url = Url::getCurrentUrl(self::$_key);
		$current = Url::getParam(self::$_key);
		$this->_current = (!empty($current))? $current: 1;
		$this->numberOfPages();
		$this->getOffset();
	}

	/**
	 *
     */
	private function numberOfPages()
	{
		$this->_num_of_pages = ceil($this->_num_of_records / $this->_max_records_per_page);
	}

	/**
	 *
     */
	private function getOffset()
	{
		$this->_offset = ($this->_current - 1) * $this->_max_records_per_page;
	}

	/**
	 * @return array
     */
	public function getRecords()
	{
		$out = array();
		$last = $this->_offset + $this->_max_records_per_page;

		if ($this->_num_of_pages > 1) {

			for ($c = $this->_offset; $c < $last; $c++) { 
				if ($c < $this->_num_of_records) {
					$out[] = $this->_records[$c];
				}
			}

		} else {
			$out = $this->_records;
		}
		return $out;
	}

	/**
	 * @return string
     */
	private function getLinks()
	{
		$out = array();
		if ($this->_num_of_pages > 1){

			//first link
			if ($this->_current > 1){
				$out[] = '<a href="' . $this->_url . '">First</a>';
			} else {
				$out[] = '<span>First</span>';
			}

			//previous link
			if ($this->_current > 1){
				$page_no = $this->_current - 1;
				$url = ($page_no > 1)?
					$this->_url. '&' .self::$_key. '=' .$page_no:
					$this->_url;
				$out[] = '<a href="' .$url. '">Previous</a>';
			} else {
				$out[] = '<span>Previous</span>';
			}

			//next link
			if ($this->_current < $this->_num_of_pages){
				$page_no = $this->_current + 1;
				$url = ($page_no <= $this->_num_of_pages)?
					$this->_url. '&' .self::$_key. '=' .$page_no:
					$this->_url;
				$out[] = '<a href="' .$url. '">Next</a>';
			} else {
				$out[] = '<span>Next</span>';
			}

			//last link
			if ($this->_current < $this->_num_of_pages){
				$url = $this->_url . '&' .self::$_key. '=' .$this->_num_of_pages;
				$out[] = '<a href="' .$url. '">Last</a>';
			} else {
				$out[] = '<span>Last</span>';
			}
			return '<li>' .implode('</li><li>', $out). '</li>';
		}
	}

	/**
	 * @return string
     */
//	public function getPages()
//	{
//		$links = $this->getLinks();
//		if (!empty($links)){
//			$out = '<ul class="paging">' .$links. '</ul>';
//			return $out;
//		}
//	}

	public function getPages()
	{
		$links = $this->getLinks();
		if (!empty($links)){
			$out = '<ul class="breadcrumb">' .$links. '</ul>';
			return $out;
		}
	}
}