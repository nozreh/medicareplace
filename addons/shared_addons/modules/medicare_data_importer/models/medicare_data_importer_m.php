<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 *
 * @author 		Herzon Garlan
 * @website		http://im.herzongarlan.com
 * @package 	guits
 * @subpackage 	medicare
 * @copyright 	MIT
 */
class medicare_data_importer_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'medicare_data_importer';
		$this->load->model('files/file_folders_m');
		$this->load->library('files/files');
		$this->folder = $this->file_folders_m->get_by('name', 'medicare_data_importer');
	}
	
/* BEGIN GET SECTION*/
	function get_all_rates($params = array())
	{
		$this->db->select('rates.*, company.name AS company_name, plan_type.name as plan_type_name')
			->join('company', 'rates.company_id = company.id')
			->join('plan_type', 'rates.plan_type_id = plan_type.id');
		$this->db->order_by('rates.created_on', 'ASC');
		$this->db->limit($params[0], $params[1]);
		
		// Limit the results based on 1 number or 2 (2nd is offset)
		return $this->db->get('rates')->result();
	}
	
	function count_rates(){
	
	return $this->db->count_all_results('rates');
	
	}
        
        
        function get_all_companies()
	{
		$this->db->select('company.*');
                $this->db->where('company.status', 1);

		$this->db->order_by('company.id', 'ASC');

		return $this->db->get('company')->result();
	}
        
        function get_all_plan_types()
	{
		$this->db->select('plan_type.*');

		$this->db->order_by('plan_type.code', 'ASC');

		return $this->db->get('plan_type')->result();
	}
        
        
        function get_rate_by_id($id)
	{
		$query = $this->db->get_where('rates', array('id' => $id));
                
                if($query->num_rows() > 0){
                return $query->row();
               }else return FALSE;
	}
        
        
        public function get_company_by_code($code = NULL){
        
            $query = $this->db->get_where('company', array('code' => $code));
           if($query->num_rows() > 0){
            return $query->row();
           }else return FALSE;
            
        }
        
        public function get_company_by_id($id = NULL){
            
             if(is_array($id)){
                $query = $this->db->get_where('company', $id);
            }else{
                 $query = $this->db->get_where('company', array('id' => $id));
            }
            
            
           
            if($query->num_rows() > 0){
            return $query->row();
           }else return FALSE;
            
        }
        
        public function get_plan_type_by_code($code = NULL){
        
            $query = $this->db->get_where('plan_type', array('code' => $code));
            if($query->num_rows() > 0){
            return $query->row();
           }else return FALSE;
            
        }
        
        public function get_plan_types_by_segment($segment = NULL)
        {
            $query = $this->db->get_where('plan_type', array('segment' => $segment));
            
            if($query->num_rows() > 0){
            return $query->result();
           }else return FALSE;
        }
        
        public function get_plan_type_by_id($id = NULL){
        
            if(is_array($id)){
                $query = $this->db->get_where('plan_type', $id);
            }else{
                $query = $this->db->get_where('plan_type', array('id' => $id));
            }
            
            
            if($query->num_rows() > 0){
            return $query->row();
           }else return FALSE;
            
        }
        
/* END GET SECTION*/	
	
/* BEGIN SET SECTION*/  
        
	//create a new rate item
	public function set_rate($input)
	{
            $rate_exist = $this->db->where('plan_type_id', $input['plan_type_id'])
                                   ->where('company_id', $input['company_id'])
                                   ->where('zipcode', $input['zipcode'])
                                   ->get('rates');
            
            if($rate_exist->num_rows() > 0){
                $id = $rate_exist->row();
                $this->edit_rate($id->id, $input); 
                return 'Item already exist, updating record';
            }
            else{
                // insert new rate record
		$to_insert = array(
			'plan_type_id' => $input['plan_type_id'],
			'company_id' => $input['company_id'],
                        'zipcode' => $input['zipcode'],
                        'preference' => $input['preference'],
                        'age' => $input['age'],
                        'gender' => $input['gender'],
                        'segment' => $input['segment'],
                        'amount' => $input['amount'],
                        'addon_amount' => $input['addon_amount'],
                        'remarks' => $input['remarks'],
                        'created_on' => time(),
                        'updated_on' => time(),

		);
                
                if($this->db->insert('rates', $to_insert)){
                    return $this->db->insert_id();
                }else return FALSE;
            }
	}
	
	public function set_batch_rate($input)
	{
        $this->db->trans_start();

			$this->db->insert_batch('rates', $input);

		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	

	//edit a new item
	public function edit_rate($id = 0, $input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			'plan_type_id' => $input['plan_type_id'],
			'company_id' => $input['company_id'],
                        'zipcode' => (string)$input['zipcode'],
                        'preference' => $input['preference'],
                        'age' => $input['age'],
                        'gender' => $input['gender'],
                        'segment' => $input['segment'],
                        'amount' => $input['amount'],
                        'addon_amount' => $input['addon_amount'],
                        'remarks' => $input['remarks'],
                        'updated_on' => time(),

		);

                if($this->db->where('id', $id)->update('rates', $to_insert)){
                    return TRUE;
                }else return FALSE; 
                

	}
        
        //create a new company item
	public function set_company($input)
	{
		// insert new rate record
		$to_insert = array(
			'code' => $input['code'],
			'name' => $input['name'],
                        'address' => $input['address'],
                        'contact' => $input['contact'],
                        'email' => $input['email'],
                        'status' => $input['status'],
                        'created_on' => time(),
                        'updated_on' => time(),

		);
                
                if($this->db->insert('company', $to_insert)){
                    return $this->db->insert_id();
                }else return FALSE; 
	}

	//edit a new item
	public function edit_comapany($id = 0, $input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			'name' => $input['name'],
                        'address' => $input['address'],
                        'contact' => $input['contact'],
                        'email' => $input['email'],
                        'status' => $input['status'],
                        'updated_on' => time(),

		);

                if($this->db->where('id', $id)->update('company', $to_insert)){
                    return TRUE;
                }else return FALSE; 
                

	}
        
        //delete a company
	public function delete_company($id = 0)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
                        'status' => 0,
                        'updated_on' => time(),

		);

                if($this->db->where('id', $id)->update('company', $to_insert)){
                    return TRUE;
                }else return FALSE; 
                

	}
        
        
        
        //create a new company item
	public function set_plan_type($input)
	{
		// insert new rate record
		$to_insert = array(
			'code' => $input['code'],
			'name' => $input['name'],
                        'segment' => $input['segment'],
                        'created_on' => time(),
                        'updated_on' => time(),

		);
                
                if($this->db->insert('plan_type', $to_insert)){
                    return $this->db->insert_id();
                }else return FALSE; 
	}

	//edit a new item
	public function edit_plan_type($id = 0, $input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			'name' => $input['name'],
                        'segment' => $input['segment'],
                        'updated_on' => time(),

		);

                if($this->db->where('id', $id)->update('plan_type', $to_insert)){
                    return TRUE;
                }else return FALSE; 
                

	}
        
        //edit a new item
	public function delete_plan_type($id = 0)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		

                if($this->db->delete('plan_type', array('id' => $id))){
                    return TRUE;
                }else return FALSE; 
                

	}
}
