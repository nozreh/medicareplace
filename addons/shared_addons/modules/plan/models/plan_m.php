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

	protected $_table = 'rates';
    
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
        
        
        function get_all()
	{
		$this->db->select('rates.*,
                        company.name AS company_name,
                        plan.name as plan_name,
                        plan.basic_benefits,
                        plan.skilled_nursing,
                        plan.part_b_excess,
                        plan.part_a_deductible,
                        plan.part_b_deductible,
                        plan.foreign_travel,')
			->join('company', 'rates.company_id = company.id')
			->join('plan', 'rates.plan_id = plan.id');

		$this->db->order_by('created_on', 'DESC');

		return $this->db->get('rates')->result();
	}
        
        public function get_by($key, $value = '')
	{
		$this->db->select('rates.*, plan.name')
			->join('plan', 'rates.plan_id = plan.id', 'left');
			
		if (is_array($key))
		{
			$this->db->where($key);
		}
		else
		{
			$this->db->where($key, $value);
		}

		return $this->db->get($this->_table)->row();
	}

	function get_many_by($params = array())
	{

		if (!empty($params['company_id']))
		{
			if (is_array($params['category']))
				$this->db->where_in('company_id', $params['company_id']);
			else
				$this->db->where('company_id', $params['category']);
		}
                
                if (!empty($params['plan_id']))
		{
			if (is_array($params['plan_id']))
				$this->db->where_in('plan_id', $params['plan_id']);
			else
				$this->db->where('plan_id', $params['plan_id']);
		}



		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);

		return $this->get_all();
	}
        
        function count_by($params = array())
	{
		$this->db->join('company', 'company.id = rates.company_id');
                $this->db->join('plan', 'rates.plan_id = plan.id');

		if (!empty($params['company_id']))
		{
			if (is_array($params['category']))
				$this->db->where_in('company_id', $params['company_id']);
			else
				$this->db->where('company_id', $params['category']);
		}
                
                if (!empty($params['plan_id']))
		{
			if (is_array($params['plan_id']))
				$this->db->where_in('plan_id', $params['plan_id']);
			else
				$this->db->where('plan_id', $params['plan_id']);
		}

		return $this->db->count_all_results('rates');
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
        
        /**
	 * Searches blog posts based on supplied data array
	 * @param $data array
	 * @return array
	 */
	public function search($data = array())
	{
		if (array_key_exists('company_id', $data))
		{
			$this->db->where_in('company_id', $data['company_id']);
		}
                
                if (array_key_exists('plan_id', $data))
		{
			$this->db->where_in('plan_id', $data['plan_id']);
		}
                
                /*
                 * * USE LATER IF NEEDED
                 *  
		if (array_key_exists('status', $data))
		{
			$this->db->where('status', $data['status']);
		}

		
                 
                 if (array_key_exists('keywords', $data))
		{
			$matches = array();
			if (strstr($data['keywords'], '%'))
			{
				preg_match_all('/%.*?%/i', $data['keywords'], $matches);
			}

			if (!empty($matches[0]))
			{
				foreach ($matches[0] as $match)
				{
					$phrases[] = str_replace('%', '', $match);
				}
			}
			else
			{
				$temp_phrases = explode(' ', $data['keywords']);
				foreach ($temp_phrases as $phrase)
				{
					$phrases[] = str_replace('%', '', $phrase);
				}
			}

			$counter = 0;
			foreach ($phrases as $phrase)
			{
				if ($counter == 0)
				{
					$this->db->like('blog.title', $phrase);
				}
				else
				{
					$this->db->or_like('blog.title', $phrase);
				}

				$this->db->or_like('blog.body', $phrase);
				$this->db->or_like('blog.intro', $phrase);
				$this->db->or_like('profiles.display_name', $phrase);
				$counter++;
			}
		}*/
		return $this->get_all();
	}
	
}
