<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 *
 * @author 	Herzon Garlan
 * @website	http://im.herzongarlan.com
 * @package 	GITS
 * @subpackage 	medicareplace
 * @copyright 	MIT
 */
class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('plan_m');
		$this->lang->load('plan');
        $this->load->helper('text');

		// We'll set the partials and metadata here since they're used everywhere
		$_companies = array();
		if ($companies = $this->plan_m->get_all_companies())
		{
			foreach ($companies as $company)
			{
				$_companies[$company->id] = $company->name;
			}
		}
		$this->template->set('companies', $_companies);
	}

	/**
	 * List all items
	 */
	public function index()
	{
		
		//set the base/default where clause
		$base_where = array('show_future' => TRUE, 'status' => 'all', );

		//add post values to base_where if f_module is posted
		$base_where = $this->input->post('f_company') ? $base_where + array('company' => $this->input->post('f_company')) : $base_where;
		
		//$base_where = $this->input->post('f_plan_type') ? $base_where + array('plan_type' => $this->input->post('f_plan_type')) : $base_where;

		$base_where['status'] = $this->input->post('f_status') ? $this->input->post('f_status') : $base_where['status'];
		
		//$base_where['gender'] = $this->input->post('f_gender') ? $this->input->post('f_gender') : $base_where['gender'];

		$base_where = $this->input->post('f_zipcode') ? $base_where + array('zipcode' => $this->input->post('f_zipcode')) : $base_where;

		// Create pagination links
		$total_rows = $this->plan_m->count_plan_users_by($base_where);
		$pagination = create_pagination('admin/plan/index', $total_rows);

		// Using this data, get the relevant results
		$plan_users = $this->plan_m->limit($pagination['limit'])->get_plan_users_by($base_where);

		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set('pagination', $pagination)
			->set('plan_users', $plan_users);

		$this->input->is_ajax_request()
			? $this->template->build('admin/tables/posts')
			: $this->template->build('admin/index');

	}
	
	/**
	 * method to fetch filtered results
	 * @access public
	 * @return void
	 */
	public function ajax_filter()
	{
		$company = $this->input->post('f_company');
		$status = $this->input->post('f_status');
		$zipcode = $this->input->post('f_zipcode');

		$post_data = array();
		
		$post_data['status'] = $status;

		if ($company != 0)
		{
			$post_data['company_id'] = $company;
		}

		//zipcode , we can change this later for name, email etc
		if ($zipcode)
		{
			$post_data['zipcode'] = $zipcode;
		}

		$results = $this->plan_m->search_plan_users($post_data);

		//set the layout to false and load the view
		$this->template
			->set_layout(FALSE)
			->set('plan_users', $results)
			->build('admin/tables/posts');
	}
	
}
