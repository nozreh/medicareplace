<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* plan Event Class
* 
* @author		AppsBaker Dev Team
* @package 		PyroCMS
* @subpackage 	plan Module
* @category 	events
*/
class Events_plan
{
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
		$this->ci->load->model('plan/plan_m');
		$this->ci->load->library('files/files');
                $this->ci->load->library('session');
        
		Events::register('zipcode_checker', array($this, 'zipcode_checker'));
		Events::register('get_plan', array($this, 'get_plan'));
		Events::register('get_company', array($this, 'get_company'));
		Events::register('get_plan_details', array($this, 'get_plan_details'));
     }

    public function zipcode_checker($params = array())
    {

            $zipcode_details = $this->ci->plan_m->zipcode_checker($params['zip_code']);
            $data = array();
           
            if( valued($zipcode_details) )
            {
                 $data['id'] = $zipcode_details->id;
                 $data['zip_code'] = $zipcode_details->zip;
                 $data['type'] = $zipcode_details->type;
                 $data['city'] = $zipcode_details->city;
                 $data['state'] = $zipcode_details->state;
                 $data['county'] = $zipcode_details->county;
                 $data['area_codes'] = $zipcode_details->area_codes;
                 
                 $this->ci->session->set_userdata('zipcode_details', $data);
                 
                 return $data;
            }
            else
            {
                    return FALSE;
            }


           
            
    }
    
    public function new_plan_user($params = array())
    {
            $applicant = $params['applicant'];
            $spouse = $params['spouse'];
            $childs = $params['childs'];
            
            $applicant_result = $this->ci->plan_m->set_plan_user($applicant);
            $data = array();
           
            
            return $applicant_result;

           
            
    } 
     
    /* 
    public function get_plan($params = array())
    {

            $plan = $this->ci->plan_m->get_plan($params['plan_id']);

            if( valued($plan) )
            {
                    return $plan;

            }
            else
            {
                    return FALSE;
            }

    }
    
    
    public function get_company($params = array())
    {

            $company = $this->ci->plan_m->get_company($params['company_id']);

            if( valued($company) )
            {
                    return $company;

            }
            else
            {
                    return FALSE;
            }

    }
    
    public function get_plan_details($params = array())
    {

            $plan_details = $this->ci->plan_m->get_plan_details($params['plan_id'], $params['company_id']);

            if( valued($plan_details) )
            {
                    return $plan_details;

            }
            else
            {
                    return FALSE;
            }

    }

    */
	
}

/* End of file events.php */