<?php
class Helper {

	/**
	 * @param null $page
	 * @return null|string
     */
//	public static function getActive($page = null)
//	{
//		if (!empty($page)) {
//			if (is_array($page)) {
//				$error = array();
//				foreach ($page as $key => $value) {
//					if (Url::getParam($key) != $value) {
//						array_push($error, $key);
//					}
//				}
//				return (empty($error))? "class=\"act\"": null;
//			}
//		}
//		return (Url::currentPage() == $page)? "class=\"act\"": null;
//	}

	public static function getActive($page = null)
	{
		if (!empty($page)) {
			if (is_array($page)) {
				$error = array();
				foreach ($page as $key => $value) {
					if (Url::getParam($key) != $value) {
						array_push($error, $key);
					}
				}
				return (empty($error))? 'active': null;
			}
		}
		return (Url::currentPage() == $page)? 'active': null;
	}

	/**
	 * @param $image
	 * @param $case
	 * @return mixed
     */
	public static function getImageSize($image, $case)
	{
		if (is_file($image)){
			$size = getimagesize($image);
			return $size[$case];
		}
	}

	/**
	 * @param $string
	 * @param int $len
	 * @return string
     */
	public static function shortenString($string, $len = 60)
	{
		if (strlen($string) > $len){
			$string = trim(substr($string, 0, $len));
			$string = substr($string, 0, strrpos($string, ' '));
			$string .= $string . '...';
		} else {
			$string .= '...';
		}
		return $string;
	}

	/**
	 * @param null $url
     */
	public static function redirect($url = null)
	{
		if (!empty($url)){
			header('Location: ' .$url);
			exit;
		}
	}

	/**
	 * @param null $case
	 * @param null $date
	 * @return bool|string
     */
	public static function setDate($case = null, $date = null)
	{
		$date = empty($date)? time(): strtotime($date);

		switch ($case){
			case 1:
				return date('d/m/Y', $date);
				break;
			case 2:
				return date('l, jS F Y, H:i:s', $date);
				break;
			case 3:
				return date('Y-m-d-H-i-s', $date);
				break;
			case 4:
				return date('d/m/Y H:i:s', $date);
			default:
				return date('Y-m-d H:i:s', $date);
		}
	}

	/**
	 * @param $string
	 * @param int $case
	 * @return mixed|string
     */
//	public static function encodeHTML($string, $case = 2)
//	{
//		switch($case) {
//			case 1:
//			return htmlentities($string, ENT_NOQUOTES, 'UTF-8', false);
//			break;
//			case 2:
//			$pattern = '<([a-zA-Z0-9\.\, "\'_\/\-\+~=;:\(\)?&#%![\]@]+)>';
//			// put text only, devided with html tags into array
//			$textMatches = preg_split('/' . $pattern . '/', $string);
//			// array for sanitised output
//			$textSanitised = array();
//			foreach($textMatches as $key => $value) {
//				$textSanitised[$key] = htmlentities(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
//			}
//			foreach($textMatches as $key => $value) {
//				$string = str_replace($value, $textSanitised[$key], $string);
//			}
//			return $string;
//			break;
//		}
//	}

	public static function getBackBtn()
	{
		$btn = '<a href="javascript:window.history.back();" class="btn btn-sm btn-default">';
		$btn .= '<i class="fa fa-arrow-left fa-fw"></i>Back';
		$btn .= '</a>';
		return $btn;
	}
	
}