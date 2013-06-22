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
		$this->load->model('medicare_data_importer_m');
                $this->load->config('validation_rules');
		$this->load->library('form_validation');
		$this->load->library('simplexlsx');//must be inside the system/cms/libraries folder
		$this->lang->load('medicare_data_importer');
                $this->load->helper('text');

		// Set the validation rules see config > validation_rules.php
		$this->rate_rules = $this->config->item('rate_validation');
                $this->company_rules = $this->config->item('company_validation');
                $this->plan_type_rules = $this->config->item('plan_type_validation');

		// We'll set the partials and metadata here since they're used everywhere
		$this->template->append_js('module::admin.js')
				->append_css('module::admin.css');
	}

	/**
	 * List all items
	 */
	public function index()
	{
		
		// Create pagination links
		$total_rows = $this->medicare_data_importer_m->count_rates();
		$pagination = create_pagination('admin/medicare_data_importer/index', $total_rows);
		// Using this data, get the relevant results
		$rates = $this->medicare_data_importer_m->get_all_rates($pagination['limit']);

		
		//$rates = $this->medicare_data_importer_m->get_all_rates();
		
		$this->template
			->title($this->module_details['name'])
            ->set('active_section', 'rates')
			->build('admin/index',array(
			'rates' => $rates, 'pagination' => $pagination));
	}
	
	/**
	 * Upload a theme to the server
	 */
	public function upload_rate()
	{
		if ( ! $this->settings->addons_upload)
		{
			show_error('Uploading add-ons has been disabled for this site. Please contact your administrator');
		}

		if ($this->input->post('btnAction') == 'upload')
		{
			
			$config['upload_path'] 		= UPLOAD_PATH;
			$config['allowed_types'] 	= 'xlsx';
			$config['max_size']         = '10240';
			$config['overwrite'] 		= TRUE;

			$this->load->library('upload', $config);
			

			if ($this->upload->do_upload())
			{
                            $upload_data = $this->upload->data();
                            $xlsx = new SimpleXLSX($upload_data['full_path']);
                            $rows = count($xlsx->rows()) > 0 ? $xlsx->rows() : NULL;
                            $data = array();
							
							
                            // Now try to open the xlsx file
                            if ( valued($rows) ){
									

                                       for($i = 0; $i <= count($xlsx->rows()); $i++)
                                        {
                                                    
                                                    $gender = strtolower(trim($rows[$i][5])) == 'male' ? 0 : 1;
                                                    
                                                    $data = array(
                                                    'plan_type_id' => $this->medicare_data_importer_m->get_plan_type_by_code( strtolower(trim($row[0])))->id,
                                                    'company_id' => $this->medicare_data_importer_m->get_company_by_code(strtolower(trim($row[1])))->id,
                                                    'zipcode' => trim($row[2]),
                                                    'preference' => $row[3],
                                                    'age' => $row[4],
                                                    'gender' => $gender,
                                                    'segment' => $row[6],
                                                    'amount' => $row[7],
                                                    'addon_amount' => $row[8],
                                                    'remarks' => $row[9],
                                                    'created_on' => time(),
                                                    'updated_on' => time(),
                                                    );

                                                    $new_rate_id = $this->medicare_data_importer_m->set_rate($data);
                                                    
                                                    if(!$new_rate_id) //Make sure we successfully added new record
                                                    {
                                                        $this->session->set_flashdata('error', 'Unable to add record, or record already exist!');
                                                        exit();
                                                        
                                                    }else{
                                                        $this->session->set_flashdata('success', $new_rate_id); //if exists just update it
                                                        continue;     
                                                    }

                                        }
                                        
                                        
                                    }
                                    else
                                    {
                                            $this->session->set_flashdata('error', 'Unable to read file please verify the format!');
                                    }


                            // Delete uploaded file
                            @unlink($upload_data['full_path']);

			}
			else
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}

			redirect('admin/medicare_data_importer');
		}

		$this->template
			->title($this->module_details['name'], lang('modules.upload_title'))
                        ->set('active_section', 'rates')
			->build('admin/upload_rates');
	}
        
        public function create_rate()
        {
            	$data = array();
                $companies_data = $this->medicare_data_importer_m->get_all_companies();
                $plans_data = $this->medicare_data_importer_m->get_all_plan_types();
                $campanies = array(); foreach($companies_data as $company) { $companies[$company->id] = $company->name; }
                $plan_types = array(); foreach($plans_data as $plan_type) { $plan_types[$plan_type->id] = $plan_type->name; }
                
                $this->form_validation->set_rules($this->rate_rules);
		$m_data = array();
		
		// check if the form validation passed
                if ($this->input->post('btnAction') == 'save')
		{   
                    if($this->form_validation->run())
                    {
                    	$gender = $this->input->post('gender') == 'male' ? 0 : 1;

                        $m_data = array(
                                'plan_type_id' => $this->input->post('plan_type_id'),
                                'company_id' => $this->input->post('company_id'),
                                'zipcode' => $this->input->post('zipcode'),
                                'preference' => $this->input->post('preference'),
                                'age' => $this->input->post('age'),
                                'gender' => $gender,
                                'segment' => $this->input->post('segment'),
                                'amount' => $this->input->post('amount'),
                                'addon_amount' => $this->input->post('addon_amount'),
                                'remarks' => $this->input->post('remarks'),

                                );

                                $result = $this->medicare_data_importer_m->set_rate($m_data);

                                if($result) //Make sure we successfully added new record
                                {
                                    $this->session->set_flashdata('success', 'Successfully created rate!');
                                    redirect('admin/medicare_data_importer');        
                                }
                                else 
                                {
                                    $this->session->set_flashdata('error', 'Unable to read file please verify the format!');
                                    exit();

                                }

                    }else{

                        $this->session->set_flashdata('error', $this->form_validation->error_string());

                    }
                
                } 
                
                $data['plan_types'] = $plan_types;
                $data['companies'] = $companies;
            
                    $this->template
			->title($this->module_details['name'], lang('modules.add_title'))
                        ->set('active_section', 'rates')
			->build('admin/rate_form', $data);
	
        }
        
        public function edit_rate($rate_id = NULL)
        {
                $data = array();
            	$rate = $this->medicare_data_importer_m->get_rate_by_id($rate_id);
                $companies_data = $this->medicare_data_importer_m->get_all_companies();
                $plans_data = $this->medicare_data_importer_m->get_all_plan_types();
                $campanies = array(); foreach($companies_data as $company) { $companies[$company->id] = $company->name; }
                $plan_types = array(); foreach($plans_data as $plan_type) { $plan_types[$plan_type->id] = $plan_type->name; }
                
                $this->form_validation->set_rules($this->rate_rules);
		$m_data = array();
		
		
                
                if ($this->input->post('btnAction') == 'save')
		{
                    // check if the form validation passed
                    if($this->form_validation->run())
                    {
						$gender = $this->input->post('gender') == 'male' ? 0 : 1;
                        $m_data = array(
                                'plan_type_id' => $this->input->post('plan_type_id'),
                                'company_id' => $this->input->post('company_id'),
                                'zipcode' => $this->input->post('zipcode'),
                                'preference' => $this->input->post('preference'),
                                'age' => $this->input->post('age'),
                                'gender' => $gender,
                                'segment' => $this->input->post('segment'),
                                'amount' => $this->input->post('amount'),
                                'addon_amount' => $this->input->post('addon_amount'),
                                'remarks' => $this->input->post('remarks'),

                                );

                                $result = $this->medicare_data_importer_m->edit_rate($rate_id, $m_data);

                                if($result) //Make sure we successfully added new record
                                {
                                    $this->session->set_flashdata('success', 'Successfully updated rate!');
                                    redirect('admin/medicare_data_importer/edit_rate/'.$rate_id);

                                }
                                else 
                                {
                                    $this->session->set_flashdata('error', 'Unable to read file please verify the format!');
                                    exit();

                                }

                    }else{

                        $this->session->set_flashdata('error', $this->form_validation->error_string());

                    }
                }
                
                $data['rate'] = $rate;
                $data['plan_types'] = $plan_types;
                $data['companies'] = $companies;
            
                    $this->template
			->title($this->module_details['name'], lang('modules.add_title'))
                        ->set('active_section', 'rates')
			->build('admin/rate_form', $data);
	
        }
        
        public function company()
        {
            $companies = $this->medicare_data_importer_m->get_all_companies();	
            
            $this->template
			->title($this->module_details['name'], lang('medicare_data_importer:companies'))
                        ->set('active_section', 'companies')
			->build('admin/companies',array(
			'companies' => $companies));
	
        }
        
        public function create_company()
        {
            	
            $this->form_validation->set_rules($this->company_rules);
            $m_data = array();

            // check if the form validation passed
            if ($this->input->post('btnAction') == 'save')
            {   
                if($this->form_validation->run())
                {

                    $m_data = array(
                            'code' => $this->input->post('code'),
                            'name' => $this->input->post('name'),
                            'address' => $this->input->post('address'),
                            'contact' => $this->input->post('contact'),
                            'email' => $this->input->post('email'),
                            'website' => $this->input->post('website'),
                            'status' => $this->input->post('status'),

                            );

                            $result = $this->medicare_data_importer_m->set_company($m_data);

                            if($result) //Make sure we successfully added new record
                            {
                                $this->session->set_flashdata('success', 'Successfully created company!');
                                redirect('admin/medicare_data_importer/company');        
                            }
                            else 
                            {
                                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                                exit();

                            }
                            
                            

                }else{

                    $this->session->set_flashdata('error', $this->form_validation->error_string());

                }

            } 
            
            
            $this->template
                        ->append_js('module::slug.js')
        		->append_js('module::fields.js')
			->title($this->module_details['name'], lang('modules.add_title'))
                        ->set('active_section', 'companies')
			->build('admin/company_form');
	
        }
        
        public function edit_company($company_id = NULL)
        {
            
            $company = $this->medicare_data_importer_m->get_company_by_id($company_id);
            $this->form_validation->set_rules($this->company_rules);
            $m_data = array();

            // check if the form validation passed
            if ($this->input->post('btnAction') == 'save')
            {   
                if($this->form_validation->run())
                {

                    $m_data = array(
                            'name' => $this->input->post('name'),
                            'address' => $this->input->post('address'),
                            'contact' => $this->input->post('contact'),
                            'email' => $this->input->post('email'),
                            'website' => $this->input->post('website'),
                            'status' => $this->input->post('status'),

                            );

                            $result = $this->medicare_data_importer_m->edit_company($company_id,  $m_data);

                            if($result) //Make sure we successfully added new record
                            {
                                $this->session->set_flashdata('success', 'Successfully updated company!');
                                redirect('admin/medicare_data_importer/company');        
                            }
                            else 
                            {
                                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                                exit();

                            }
                            
                            

                }else{

                    $this->session->set_flashdata('error', $this->form_validation->error_string());

                }

            } 
            
            
            $this->template
			->title($this->module_details['name'], lang('modules.add_title'))
                        ->set('active_section', 'companies')
			->build('admin/company_form', array('company' => $company));
	
        }
        
        public function delete_company($company_id = NULL)
        {
            
            
            $result = $this->medicare_data_importer_m->delete_company($company_id);

            if($result) //Make sure we successfully added new record
            {
                $this->session->set_flashdata('success', 'Successfully deleted company!');
                redirect('admin/medicare_data_importer/company');        
            }
            else 
            {
                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                redirect('admin/medicare_data_importer/company');  

            }

        }
        
        
        public function plan_types()
        {
            $plan_types = $this->medicare_data_importer_m->get_all_plan_types();	
            
            $this->template
			->title($this->module_details['name'], 'Plan Types')
                        ->set('active_section', 'plan_types')
			->build('admin/plan_types',array(
			'plan_types' => $plan_types));
	
        }
        
        public function create_plan_type()
        {
            	
            $this->form_validation->set_rules($this->plan_type_rules);
            $m_data = array();

            // check if the form validation passed
            if ($this->input->post('btnAction') == 'save')
            {   
                if($this->form_validation->run())
                {

                    $m_data = array(
                            'code' => $this->input->post('code'),
                            'name' => $this->input->post('name'),
                            'segment' => $this->input->post('segment'),
                            );

                            $result = $this->medicare_data_importer_m->set_plan_type($m_data);

                            if($result) //Make sure we successfully added new record
                            {
                                $this->session->set_flashdata('success', 'Successfully created Plan Type!');
                                redirect('admin/medicare_data_importer/plan_types');        
                            }
                            else 
                            {
                                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                                exit();

                            }
                            
                            

                }else{

                    $this->session->set_flashdata('error', $this->form_validation->error_string());

                }

            } 
            
            
            $this->template
			->append_js('module::slug.js')
        		->append_js('module::fields.js')
                        ->title($this->module_details['name'], lang('modules.add_title'))
                        ->set('active_section', 'plan_types')
			->build('admin/plan_type_form');
	
        }
        
         public function edit_plan_type($plan_type_id = NULL)
        {
            
            $plan_type = $this->medicare_data_importer_m->get_plan_type_by_id($plan_type_id);
            $this->form_validation->set_rules($this->plan_type_rules);
            $m_data = array();

            // check if the form validation passed
            if ($this->input->post('btnAction') == 'save')
            {   
                if($this->form_validation->run())
                {

                    $m_data = array(
                            
                            'name' => $this->input->post('name'),
                            'segment' => $this->input->post('segment'),
                            );

                            $result = $this->medicare_data_importer_m->edit_plan_type($plan_type_id,  $m_data);

                            if($result) //Make sure we successfully added new record
                            {
                                $this->session->set_flashdata('success', 'Successfully updated company!');
                                redirect('admin/medicare_data_importer/plan_types');        
                            }
                            else 
                            {
                                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                                exit();

                            }
                            
                            

                }else{

                    $this->session->set_flashdata('error', $this->form_validation->error_string());

                }

            } 
            
            
            $this->template
			->title($this->module_details['name'], lang('modules.add_title'))
                        ->set('active_section', 'plan_types')
			->build('admin/plan_type_form', array('plan_type' => $plan_type));
	
        }
        
        public function delete_plan_type($plan_type_id = NULL)
        {
            
            
            $result = $this->medicare_data_importer_m->delete_plan_type($plan_type_id);

            if($result) //Make sure we successfully added new record
            {
                $this->session->set_flashdata('success', 'Successfully deleted Plan Type!');
                redirect('admin/medicare_data_importer/plan_type');        
            }
            else 
            {
                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                redirect('admin/medicare_data_importer/plan_type');  

            }

        }
}
