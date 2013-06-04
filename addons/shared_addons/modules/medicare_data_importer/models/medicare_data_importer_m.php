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
	function get_all_rates()
	{
		$this->db->select('rates.*, company.name AS company_name, plan.name as plan_name')
			->join('company', 'rates.company_id = company.id')
			->join('plan', 'rates.plan_id = plan.id');

		$this->db->order_by('rates.created_on', 'DESC');

		return $this->db->get('rates')->result();
	}
        
        
        function get_all_companies()
	{
		$this->db->select('company.*');
                $this->db->where('company.status', 1);

		$this->db->order_by('company.id', 'DESC');

		return $this->db->get('company')->result();
	}
        
        function get_all_plans()
	{
		$this->db->select('plan.*');

		$this->db->order_by('plan.code', 'ASC');

		return $this->db->get('plan')->result();
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
        
            $query = $this->db->get_where('company', array('id' => $id));
            if($query->num_rows() > 0){
            return $query->row();
           }else return FALSE;
            
        }
        
        public function get_plan_by_code($code = NULL){
        
            $query = $this->db->get_where('plan', array('code' => $code));
            if($query->num_rows() > 0){
            return $query->row();
           }else return FALSE;
            
        }
        
        public function get_plan_by_id($id = NULL){
        
            $query = $this->db->get_where('plan', array('id' => $id));
            if($query->num_rows() > 0){
            return $query->row();
           }else return FALSE;
            
        }
        
/* END GET SECTION*/	
	
/* BEGIN SET SECTION*/  
        
	//create a new rate item
	public function set_rate($input)
	{
		// insert new rate record
		$to_insert = array(
			'plan_id' => $input['plan_id'],
			'company_id' => $input['company_id'],
                        'gender' => $input['gender'],
                        'zipcode' => (string)$input['zipcode'],
                        'preference' => $input['preference'],
                        'age' => $input['age'],
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

	//edit a new item
	public function edit_rate($id = 0, $input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			'plan_id' => $input['plan_id'],
			'company_id' => $input['company_id'],
                        'gender' => $input['gender'],
                        'zipcode' => (string)$input['zipcode'],
                        'preference' => $input['preference'],
                        'age' => $input['age'],
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
	public function set_plan($input)
	{
		// insert new rate record
		$to_insert = array(
			'code' => $input['code'],
			'name' => $input['name'],
                        'status' => $input['status'],
                        'status' => $input['status'],
                        'basic_benefits' => $input['basic_benefits'],
                        'skilled_nursing' => $input['skilled_nursing'],
                        'part_b_excess' => $input['part_b_excess'],
                        'part_a_deductible' => $input['part_a_deductible'],
                        'part_b_deductible' => $input['part_b_deductible'],
                        'foreign_travel' => $input['foreign_travel'],
                        'created_on' => time(),
                        'updated_on' => time(),

		);
                
                if($this->db->insert('plan', $to_insert)){
                    return $this->db->insert_id();
                }else return FALSE; 
	}

	//edit a new item
	public function edit_plan($id = 0, $input)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
			'name' => $input['name'],
                        'status' => $input['status'],
                        'basic_benefits' => $input['basic_benefits'],
                        'skilled_nursing' => $input['skilled_nursing'],
                        'part_b_excess' => $input['part_b_excess'],
                        'part_a_deductible' => $input['part_a_deductible'],
                        'part_b_deductible' => $input['part_b_deductible'],
                        'foreign_travel' => $input['foreign_travel'],
                        'updated_on' => time(),

		);

                if($this->db->where('id', $id)->update('plan', $to_insert)){
                    return TRUE;
                }else return FALSE; 
                

	}
        
        //edit a new item
	public function delete_plan($id = 0)
	{
		// $fileinput = Files::upload($this->folder->id, FALSE, 'fileinput');
		$to_insert = array(
                        'status' => 0,
                        'updated_on' => time(),

		);

                if($this->db->where('id', $id)->update('plan', $to_insert)){
                    return TRUE;
                }else return FALSE; 
                

	}
}
