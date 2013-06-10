<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Company Field Type
 *
 * @package		GITS
 * @author		herzongarlan
 */
class Field_company
{
	public $field_type_slug			= 'company';
	
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
		
		$companies_raw = $this->CI->db->order_by('name', 'asc')->get('company')->result();
		$companies = array();

		// If this is not required, then
		// let's allow a null option
		if ($field->is_required == 'no')
		{
			$companies[null] = $this->CI->config->item('dropdown_choose_null');
		}
		
		// Get user choices
		foreach ($companies_raw as $company)
		{
			$companies[$company->id] = $company->name;
		}
	
		return form_dropdown($params['form_slug'], $companies, $params['value'], 'id="'.$params['form_slug'].'"');
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
		
		$company = $this->CI->medicare_data_importer_m->get_company_by_id(array('id' => $input));

		$return = array(
			'company_id'		=> $company->id,
			'code'                  => $company->code,
			'name'			=> $company->name,
		);
		
		$this->cache[$input] = $return;
		
		return $return;
	}

}