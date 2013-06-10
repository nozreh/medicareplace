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
                $this->load->model('medicare_data_importer/medicare_data_importer_m');
		$this->load->helper('util');
		$this->load->helper('form');
		$this->lang->load('plan');
		$this->load->config('plan');
		$this->load->library('files/files');
		$this->load->spark('curl/1.2.1');
		$this->load->library('session');
                $this->load->driver('Streams');
			
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
                $this->session->unset_userdata('segment');
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
                $segment = $this->session->userdata('segment');
                $this->form_validation->set_rules($this->config->item('validation_register'));
                $data = array();
                $applicant = array();
                
                if(!valued($zipcode_details)) {redirect();} //if user havent selected age and zipcode
                
                
                if($segment == 2) //if user try to cheat the url
                {
                    redirect('/plan/register_individual?demographic='.$age_bracket);
                }
                
                //get info from ajax session
                $data['age_bracket'] = $age_bracket;
                $data['segment'] = $segment;
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
                                                'segment' => $data['segment'],
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
                $segment = $this->session->userdata('segment');
                $this->form_validation->set_rules($this->config->item('validation_individual'));
                $data = array();
                $dependants = array();
                $childs = array();
                
               if(!valued($zipcode_details)) {redirect();} //if user havent selected age and zipcode
                
                
                if($segment == 1) //if user try to cheat the url
                {
                    redirect('/plan/register?demographic='.$age_bracket);
                }
                
                //get info from ajax session
                $data['age_bracket'] = $age_bracket;
                $data['segment'] = $segment;
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
                                                'segment' => $data['segment'],
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
            $segment = $this->session->userdata('segment');
            
            $company_list = $this->medicare_data_importer_m->get_all_companies();
            $plan_list = $this->medicare_data_importer_m->get_plan_types_by_segment($segment);
            
            $base_where = array();
            //add post values to base_where if f_module is posted
            $base_where = $this->input->post('f_company') ? $base_where + array('company_id' => $this->input->post('f_company')) : $base_where;

            $base_where = $this->input->post('f_plan_type') ? $base_where + array('plan_type_id' => $this->input->post('f_plan_type')) : $base_where;

            // Create pagination links
            $total_rows = $this->plan_m->count_by($base_where);
            $pagination = create_pagination('plan/select', $total_rows);

            // Using this data, get the relevant results
            $rates = $this->plan_m->limit($pagination['limit'])->get_many_by($base_where);

            //do we need to unset the layout because the request is ajax?
            $this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

            $this->template
                    ->title($this->module_details['name'])
                    ->set('zipcode_details', $zipcode_details)
                    ->set('error_string',$error_string)
                    ->set('user_info', $user_info)
                    ->set('pagination', $pagination)
                    ->set('company_list', $company_list)
                    ->set('plan_list', $plan_list)
                    ->set('rates', $rates);
            

            $this->input->is_ajax_request()
                    ? $this->template->build('tables/posts')
                    : $this->template->build('select_plan');
            
        }
        
	
	public function ajax_check_zipcode()
	{
		$valid_zipcode = Events::trigger('zipcode_checker',array('zip_code' => $this->input->post('zip_code')));
		$age_bracket = $this->input->post('age_bracket');
                $segment = $this->input->post('segment');
                
                $this->session->set_userdata('age_bracket', $age_bracket); //0=below 64 , 1=above 64
                $this->session->set_userdata('segment', $segment); //-1 = no selected option, 0=parts A-B, 1=individual plans
               
		if( $valid_zipcode )
		{
			$data['result'] = TRUE;
                        $data['age_bracket'] = $age_bracket;
                        $data['segment'] = $segment;
                        
		}
		else
		{
			$data['result'] = FALSE;
                        $data['message'] = 'Invalid zipcode.';
		}
		
		echo json_encode($data);
	}
        
        public function ajax_filter()
        {
            $company = $this->input->post('f_company');
            $plan = $this->input->post('f_plan_type');
            //$keywords = $this->input->post('f_keywords');

            $post_data = array();

            if ( $plan != 0)
            {
                $post_data['plan_type_id'] = $plan;
            }

            if ($company != 0)
            {
                $post_data['company_id'] = $company;
            }

            //keywords, lets explode them out if they exist
            /*if ($keywords)
            {
                $post_data['keywords'] = $keywords;
            }*/
            
            $results = $this->plan_m->search($post_data);

            //set the layout to false and load the view
            $this->template
                ->set_layout(FALSE)
                ->set('rates', $results)
                ->build('tables/plans');
        }
	
        
        public function ajax_plan_details()
        {
            $segment = $this->input->post('segment');
            $plan_type_id = $this->input->post('plan_type_id');
            $company_id = $this->input->post('company_id');
            
            $data = array();
            
            switch($segment)
            {
                case 0:
                    $params = array(
                        'stream' => 'plan_details_segment_a',
                        'namespace' => 'streams',
                        'paginate' => 'no',
                        'where' => 'plan_type_id = '.$plan_type_id.' AND company_id = '.$company_id
                    );
                    break;
               case 1:
                    $params = array(
                        'stream' => 'plan_details_segment_b',
                        'namespace' => 'streams',
                        'paginate' => 'no',
                        'where' => 'plan_type_id = '.$plan_type_id.' AND company_id = '.$company_id
                    );
                    break;
                
            
            }
            
            $results = $this->streams->entries->get_entries($params);
            $details = $results['entries'][0];
            if(count($details) > 0){
                
                $output = '<table><tbody>';
                $hidden_list = array('id','created','updated','created_by','ordering_count','plan_type_id','last','odd_even','count');

                foreach($details as $label => $detail){
                    
                    if(in_array($label, $hidden_list)) continue; //we don't want to display some prebuilt data
                    else{
                        $label = ucfirst(str_replace('_', ' ', $label)); //format the label

                        if(is_array($detail)){
                            if(valued($detail['img'])){
                               $output .= '<tr><td>'.$label.':</td><td>'. $detail['img'].'</td></tr>';
                            }
                            elseif (valued($detail['file'])) {
                              $output .= '<tr><td>'.$label.':</td><td><a href="'. $detail['file'].'" target="_blank" >Click to view</a></td></tr>';
                           }
                           elseif (valued($detail['name'])) {
                              $output .= '<tr><td>'.$label.':</td><td>'. $detail['name'].'</td></tr>';
                           }
                           else{
                               $output .= '<tr><td>'.$label.':</td><td>'. $detail['val'].'</td></tr>';
                            }
                        }
                        else {
                         $output .= '<tr><td>'.$label.':</td><td>'. $detail.'</td></tr>';  
                        }
                    }

                }

                 $output .= ' </tbody></table>';

                $data['result'] = $output;
                $data['success'] = TRUE;
            }  
            else     
            {
                $data['result'] = 'No detail found';
                $data['success'] = FALSE;
            }
            
            echo json_encode($data);
        }
	
        
        public function _reset_sessions()
        {
            $this->session->set_userdata('zipcode_details',NULL);
            $this->session->set_userdata('age_bracket', NULL);
            $this->session->set_userdata('segment', NULL);
        }
        
        public function birth_date_check($birth_date)
        {
       
            $age_bracket = $this->session->userdata('age_bracket');
            $date_tocheck = date('Y') - date('Y', strtotime($birth_date));
            
              
                if( $date_tocheck <= 64 && $age_bracket == 1 )
                {
                    $this->form_validation->set_message('birth_date_check', 'The %s field input is less than age 64');
                    return FALSE;
                }
		else
		{
                    return TRUE;
		}
        }
	
	
	
}