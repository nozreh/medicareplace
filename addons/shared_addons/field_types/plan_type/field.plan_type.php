<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Plan Field Type
 *
 * @package		GITS
 * @author		herzongarlan
 */
class Field_plan_type
{
	public $field_type_slug			= 'plan_type';
	
	public $db_col_type			= 'int';

	public $version				= '1.0';

	public $author				= array('name'=>'herzongarlan', 'url'=>'http://groundupitsolutions.com');

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($params, $entry_id, $field)
	{
		
		$plans_raw = $this->CI->db->order_by('code', 'asc')->get('plan_type')->result();
		$plan_types = array();

		// If this is not required, then
		// let's allow a null option
		if ($field->is_required == 'no')
		{
			$plan_types[null] = $this->CI->config->item('dropdown_choose_null');
		}
		
		// Get user choices
		foreach ($plans_raw as $plan_type)
		{
			$plan_types[$plan_type->id] = $plan_type->name;
		}
	
		return form_dropdown($params['form_slug'], $plan_types, $params['value'], 'id="'.$params['form_slug'].'"');
	}
        

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting for the plugin
	 *
	 * This creates an array of data to be merged with the
	 * tag array so relationship data can be called with
	 * a {field.column} syntax
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	array
	 */
	public function pre_output_plugin($input, $params)
	{
		// Can't do anything without an input
		if ( ! is_numeric($input) OR $input < 1)
		{
			return null;
		}
	
		// Check run-time cache
		if (isset($this->cache[$input]))
		{
			return $this->cache[$input];
		}
	
		$this->CI->load->model('medicare_data_importer/medicare_data_importer_m');
		
		$plan_type = $this->CI->medicare_data_importer_m->get_plan_type_by_id(array('id' => $input));

		$return = array(
			'plan_type_id'		=> $plan_type->id,
			'code'                  => $plan_type->code,
			'name'			=> $plan_type->name,
		);
		
		$this->cache[$input] = $return;
		
		return $return;
	}

}