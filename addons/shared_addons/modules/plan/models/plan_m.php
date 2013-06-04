<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Medicare Plan module model
 *
 * @author 		Herz Garlan - GITS
 * @website		http://im.herzongarlan.com
 * @package 	Medicare
 * @subpackage 	Plan Module
 */
class Plan_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->db->set_dbprefix(SITE_REF.'_'); //set the prefix back again to normal
		$this->load->config('plan/plan');
		$this->load->library('email');
		
	}
        
        public function zipcode_checker($zipcode)
        {
            
            $result = $this->db->get_where('zipcode', array('zip' => $zipcode))
						->row();
            
            if($result)
            {
                return $result;
            }
            else
            {
                return FALSE;
            }
        }
        
	
	
	public function get_plan($plan_id = NULL)
	{
                if( valued($plan_id) ){
            
                    return $this->db->get_where('plan', array('id' => $plan_id))
						->row();
                }else{
                    
                    return $this->db->get('plan')->result();
                }
	}
	
	
	/* Get Plan User */
	public function get_user_info($uid = NULL)
	{
	
		$query =  $this->db->get_where('plan_users', array('uid' => $uid))	
						  ->row();
		
		if( valued( $query) )
		{
			return $query;
		}
		else
		{
			return false;
		}
	}
	
	
	/* set entry per user*/
	public function set_plan_user($details = array())
	{
		$applicant = $this->db->insert('plan_users', array_merge($details, array('created_on' => time(), 'updated_on' => time()))); //attempt to insert a new record instead
		
                if($applicant) {
		
		return $this->db->insert_id();;
		}
		return FALSE; 
                
	}	
        
        /* set entry per user*/
	public function set_plan_dependant($details = array(), $uid, $type)
	{
		
                if($type == 'child')
                {
                    foreach($details as $detail)
                    {
                        if( valued($detail['gender']) )
                        {
                        $dependant = $this->db->insert('user_dependants', 
                                                array_merge(array_replace_recursive($detail, array('birth_date' => mdate('%Y%m%d', strtotime($detail['birth_date'])))), array('uid' => $uid, 'type' => $type, 'created_on' => time(), 'updated_on' => time()))
                                                ); //attempt to insert a new record instead
                        }
                    }
                }
                else
                {
                    if( valued($details['gender']) )
                    {
                     $dependant = $this->db->insert('user_dependants', 
                                                array_merge(array_replace_recursive($details, array('birth_date' => mdate('%Y%m%d', strtotime($details['birth_date'])))), array('uid' => $uid, 'type' => $type, 'created_on' => time(), 'updated_on' => time()))
                                                ); //attempt to insert a new record instead
                    }
                }
            
               
		
                if($dependant) {
		
		return $this->db->insert_id();;
		}
                
	}
	
}
