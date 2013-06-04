<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is an GITS Plan module for Medicare APP
 *
 * @author 		Herz Garlan - GITS
 * @website		http://im.herzongarlan.com
 * @package 	Medicare
 * @subpackage 	Plan Module
 */
class plan extends Public_Controller
{
	
	var $data = array();
	var $userinfo;
	var $uid;
	var $plan;
	

	public function __construct()
	{
		parent::__construct();
		
		$this->plan = 'plan';	
		$this->load->library('form_validation');
		$this->load->model('plan_m');
		$this->load->helper('util');
		$this->load->helper('form');
		$this->lang->load('plan');
		$this->load->config('plan');
		$this->load->library('files/files');
		$this->load->spark('curl/1.2.1');
		$this->load->library('session');
			
		if( valued($this->session->userdata('user_info')) )
                {
                    $this->userinfo = $this->session->userdata('user_info');
                    $this->uid = $this->userinfo->uid; 
                }
               	
	}
	
	
	
	public function index( $zipcode = NULL )
	{
                //we don't want them to access this so lets clear the sessions
		$this->session->unset_userdata('user_info');
                $this->session->unset_userdata('zipcode_details');
                $this->session->unset_userdata('age_bracket');
                $this->session->unset_userdata('plan_option');
                print 'nothing here';
                //redirect();
	}
        
        /**
	 * Method to register a new user
	 */
	public function register()
	{   
                $user_info = $this->session->userdata('user_info');
                $zipcode_details = $this->session->userdata('zipcode_details');
                $age_bracket = $this->session->userdata('age_bracket');
                $plan_option = $this->session->userdata('plan_option');
                $this->form_validation->set_rules($this->config->item('validation_register'));
                $data = array();
                $applicant = array();
                
                if(!valued($zipcode_details)) {redirect();} //if user havent selected age and zipcode
                
                
                if($plan_option == 2) //if user try to cheat the url
                {
                    redirect('/plan/register_individual?demographic='.$age_bracket);
                }
                
                //get info from ajax session
                $data['age_bracket'] = $age_bracket;
                $data['plan_option'] = $plan_option;
                $data['zip_code'] = $zipcode_details['zip_code'];
                $data['state'] = $zipcode_details['state'];
                $data['city'] = $zipcode_details['city'];
                $data['county'] = $zipcode_details['county'];
                
                
                if($this->input->post('btnSubmit') == 'Get Quotes'){

                 if($this->input->post())
                 { 
                    // Merge the submitted data with the current data
                    $data = array_merge($this->input->post(),$data);
                    // show errors
                    if($this->form_validation->run() && $error_string == '')
                    {
                            //Let Rock n' Roll
                            $applicant = array( 'age_bracket' => $data['age_bracket'],
                                                'plan_option' => $data['plan_option'],
                                                'gender' => $data['gender'],
                                                'birth_date' => mdate('%Y%m%d', strtotime($data['birth_date'])),
                                                'preference' => $data['preference'],
                                                'enrolled_in' => $data['enrolled_in'],
                                                'zip_code' => $data['zip_code'],
                                                'start_coverage' => mdate('%Y%m%d', strtotime($data['start_coverage'])),
                                                'first_name' => $data['first_name'],
                                                'last_name' => $data['last_name'],
                                                'address' => $data['address'],
                                                'city' => $data['city'],
                                                'state' => $data['state'],
                                                'county' => $data['county'],
                                                'email' => $data['email'],
                                                'contact' => $data['contact'],
                                                'created_date' => mdate('%y%m%d', strtotime($data['start_coverage']))
                                                );


                            $uid = $this->plan_m->set_plan_user( $applicant );

                            if($uid)
                            {
                                $this->session->set_userdata('user_info', array_merge(array('uid' => $uid), $applicant));
                                 redirect('plan/select');

                            }

                           
                    }
                    else 
                    {

                         $error_string .= $this->form_validation->error_string();

                     }
                 }

                }
          

		$this->template
			->title('Personal Info')
			->set('zipcode_details', $zipcode_details)
                        ->set('error_string',$error_string)
			->build('register', $data);
	}
        
         /**
	 * Method to register a new user
	 */
	public function register_individual()
	{   
                
                $user_info = $this->session->userdata('user_info');
                $zipcode_details = $this->session->userdata('zipcode_details');
                $age_bracket = $this->session->userdata('age_bracket');
                $plan_option = $this->session->userdata('plan_option');
                $this->form_validation->set_rules($this->config->item('validation_individual'));
                $data = array();
                $dependants = array();
                $childs = array();
                
               if(!valued($zipcode_details)) {redirect();} //if user havent selected age and zipcode
                
                
                if($plan_option == 1) //if user try to cheat the url
                {
                    redirect('/plan/register?demographic='.$age_bracket);
                }
                
                //get info from ajax session
                $data['age_bracket'] = $age_bracket;
                $data['plan_option'] = $plan_option;
                $data['zip_code'] = $zipcode_details['zip_code'];
                $data['state'] = $zipcode_details['state'];
                $data['city'] = $zipcode_details['city'];
                $data['county'] = $zipcode_details['county'];
                
                if($this->input->post('btnSubmit') == 'Get Quotes'){
                  if($this->input->post())
                   {
                    
                    $gender = $this->input->post('gender');
                    $dependant_types = $this->input->post('dependant_type');
                    $child = 0;
                    
                    // Merge the submitted data with the current data
                    $data = array_merge($this->input->post(),$data);
                    // show errors

                   foreach($data as $input => $item) //loop through all data
                   {
                       if($input == 'dependant_type') //check if dependant type
                       {
                           foreach($dependant_types as $i => $dependant)
                            {

                                  if($dependant == 'child'){ //for childs

                                       $childs[$child] = array('gender' => $data['gender'][$i],
                                                                   'birth_date' => $data['birth_date'][$i],
                                                                   'preference' => $data['preference'][$i],
                                                                   'student' => $data['student'][$i]
                                                                   );
                                       $child++;
                                       $dependants['childs'] = $childs;
                                  }
                                  elseif ($dependant == 'spouse') 
                                  {
                                      $dependants[$dependant] = 
                                                               array('gender' => $data['gender'][$i],
                                                                   'birth_date' => $data['birth_date'][$i],
                                                                   'preference' => $data['preference'][$i],
                                                                   'student' => $data['student'][$i]
                                                                   );

                                   }
                                  else //for applicant
                                  {
                                      if(!valued($data['gender'][$i])) //Check gender only for applicant
                                      {
                                          $error_string .= '<p>Applicant\'s Gender is required.</p>';
                                      }
                                      $dependants[$dependant] = array('gender' => $data['gender'][$i],
                                                                   'birth_date' => $data['birth_date'][$i],
                                                                   'preference' => $data['preference'][$i],
                                                                   'student' => $data['student'][$i],
                                                                   'zip_code' => $data['zip_code'],
                                                                   'start_coverage' => $data['start_coverage'],
                                                                   'first_name' => $data['first_name'],
                                                                   'last_name' => $data['last_name'],
                                                                   'address' => $data['address'],
                                                                   'city' => $data['city'],
                                                                   'county' => $data['county'],
                                                                   'state' => $data['state'],
                                                                   'email' => $data['email'],
                                                                   'contact' => $data['contact'],
                                                                   );
                                  }
                               }

                       }
                       else
                       {

                       }
                   }
             
                    
                    if($this->form_validation->run() && $error_string == '')
                    {
                            //Let Rock n' Roll
                            $applicant = $dependants['applicant'];
                            $applicant = array( 'age_bracket' => $data['age_bracket'],
                                                'plan_option' => $data['plan_option'],
                                                'gender' => $applicant['gender'],
                                                'birth_date' => mdate('%Y%m%d', strtotime($applicant['birth_date'])),
                                                'preference' => $applicant['preference'],
                                                'student' => $applicant['student'],
                                                'zip_code' => $applicant['zip_code'],
                                                'start_coverage' => mdate('%Y%m%d', strtotime($applicant['start_coverage'])),
                                                'first_name' => $applicant['first_name'],
                                                'last_name' => $applicant['last_name'],
                                                'address' => $applicant['address'],
                                                'city' => $applicant['city'],
                                                'state' => $applicant['state'],
                                                'email' => $applicant['email'],
                                                'contact' => $applicant['contact'],
                                                'created_date' => mdate('%y%m%d', strtotime($applicant['start_coverage']))
                                                );
                            
                            $spouse = $dependants['spouse'];
                            $childs = $dependants['childs'];
                            //$result = Events::trigger('new_plan_user',array('data' => $dependants));
                           
                            
                            $uid = $this->plan_m->set_plan_user( $applicant );
                            if($uid)
                            {
                                $this->session->set_userdata('user_info', array_merge(array('uid' => $uid), $applicant));
                                
                                $this->plan_m->set_plan_dependant($spouse, $uid, 'spouse');
                            
                                $this->plan_m->set_plan_dependant($childs, $uid, 'child');
                                
                                redirect('plan/select');
                                
                            }
                            
                            
                    }
                    else 
                    {
                          
                         $error_string .= $this->form_validation->error_string();

                     }
                   }

                }
                
                $data = $dependants;

		$this->template
			->title('Personal Info')
			->set('zipcode_details', $zipcode_details)
                        ->set('error_string',$error_string)
			->build('register_individual', $data);
	}
	
        
        public function select()
        {
            //we don't want them to go here without registration
            $user_info = $this->session->userdata('user_info');
            if(!valued($user_info)){ redirect();}
            $zipcode_details = $this->session->userdata('zipcode_details');
            $age_bracket = $this->session->userdata('age_bracket');
            $plan_option = $this->session->userdata('plan_option');
           
            $this->template
			->title('Personal Info')
			->set('zipcode_details', $zipcode_details)
                        ->set('error_string',$error_string)
			->build('select_plan', $user_info);
            
        }
        
	
	public function ajax_check_zipcode()
	{
		$valid_zipcode = Events::trigger('zipcode_checker',array('zip_code' => $this->input->post('zip_code')));
		$age_bracket = $this->input->post('age_bracket');
                $plan_option = $this->input->post('plan_option');
                
                $this->session->set_userdata('age_bracket', $age_bracket); //0=below 64 , 1=above 64
                $this->session->set_userdata('plan_option', $plan_option); //false = no selected option, 0=parts A-B, 1=individual plans
               
		if( $valid_zipcode )
		{
			$data['result'] = TRUE;
                        $data['age_bracket'] = $age_bracket;
                        $data['plan_option'] = $plan_option;
                        
		}
		else
		{
			$data['result'] = FALSE;
                        $data['message'] = 'Invalid zipcode.';
		}
		
		echo json_encode($data);
	}
	
	public function ajax_register()
	{
		
		$this->form_validation->set_rules($this->validation_rules);
		$m_data = array();
		
		// check if the form validation passed
		if($this->form_validation->run())
		{
			
			$details = array(
                                        'uid' => $this->uid, 
                                        'age_range' => $this->input->post('age_range'),
                                        'gender' => $this->input->post('gender'),
                                        'first_name' => $this->input->post('first_name'),
                                        'last_name' => $this->input->post('last_name'),
                                        'email' => $this->input->post('email'),
                                        'newsletter' => $this->input->post('newsletter'),
                                        'branch' => $this->input->post('branch')
                                        );

				
			if($this->plan_m->set_participant($details)) 
			{
				$m_data['success'] = true;
				$m_data['message'] = lang('plan:message:register_success');
					
			}
			else{
				
					$m_data['success'] = false;
					$m_data['message'] = lang('plan:message:register_failed');
				
			}
		}else{
			
			$m_data['success'] = false;
			$m_data['message'] = $this->form_validation->error_string();
		}
		
		echo json_encode($m_data);
		
	}
        
        public function _reset_sessions()
        {
            $this->session->set_userdata('zipcode_details',NULL);
            $this->session->set_userdata('age_bracket', NULL);
        }
	
	
	
}