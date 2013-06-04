<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * To initiate a connection to Facebook api thru Facebook's phpsdk
 */

	/**
	 * Handy d()
	 */
	function d($data)
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	
	/**
	 * Handy Array convert Object to standard the format
	*/
	function array_toObject($array)
	{
		$obj = new stdClass;
		  foreach($array as $k => $v) {
			 if(is_array($v)) {
				$obj->{$k} = array_toObject($v); //RECURSION
			 } else {
				$obj->{$k} = $v;
			 }
		  }

		
		return $obj;
		 
	}
	
	/**
	 * Adds timestamp to any array data
	 */
	function timestamp($data = null, $name = 'updated') 
	{
		if( ! isset($data) && ! is_array($data)) exit('$data cannot be null');
		
		$keys = array_keys($data); //get all the keys in the array
		$i = 1;
		
		while(in_array($name, $keys))//to avoid collision of key name
		{ 
			$name .= $i; //increment key name if name already in use
			$i++;
		}
		
		$data[$name.'_date'] = mdate('%y%m%d', now()); //stamp date in ddmmyy format
		$data[$name.'_datetime'] = now(); //stamp datetime in unix format
		
		return $data;
	}
	
	/**
	 * Check if a variable contains any value
	 */
	function valued($var) 
	{
		return ( ! isset($var) || empty($var)) ? FALSE : TRUE;
	}
	
	
	
/**
 * create a js redirect function
 */	
function js_redirect($url = null) {
	if( ! isset($url)) return FALSE;
	echo '<html><body><script type="text/javascript">self.parent.location = "'.$url.'"</script></body></html>';
}



	