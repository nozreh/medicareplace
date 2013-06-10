<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Validaion Rules
| -------------------------------------------------------------------------
| Define validation rules here with unique name
|
*/

// front-end
$config['rate_validation']   = array(
			array(
                                'field' => 'plan_id',
                                'label' => 'Plan_id',
                                'rules' => 'required|trim|integer|xss_clean',
                         ),
                        array(
                                'field' => 'company_id',
                                'label' => 'Company_id',
                                'rules' => 'required|trim|integer|xss_clean',
                        ),
                        array(
                                'field' => 'gender',
                                'label' => 'Gender',
                                'rules' => 'required|trim|xss_clean',
                        ),
                         array(
                                'field' => 'zipcode',
                                'label' => 'Zipcode',
                                'rules' => 'required|trim|xss_clean',
                        ),
                        array(
                                'field' => 'preference',
                                'label' => 'Preference',
                                'rules' => 'required|trim|xss_clean',
                        ),
                        array(
                                'field' => 'age',
                                'label' => 'Age',
                                'rules' => 'required|trim|xss_clean',
                        ),
                        array(
                                'field' => 'amount',
                                'label' => 'Amount',
                                'rules' => 'required|trim|xss_clean',
                        ),
                        array(
                                'field' => 'addon_amount',
                                'label' => 'Addon_amount',
                                'rules' => 'trim|xss_clean',
                        ),
                        array(
                                'field' => 'remarks',
                                'label' => 'Remarks',
                                'rules' => 'xss_clean',
                        ),

		);
                
 $config['company_validation']   = array(
			array(
                                'field' => 'code',
                                'label' => 'code',
                                'rules' => 'required|trim|xss_clean',
                         ),
                        array(
                                'field' => 'name',
                                'label' => 'name',
                                'rules' => 'required|xss_clean',
                        ),
                        array(
                                'field' => 'address',
                                'label' => 'address',
                                'rules' => 'xss_clean',
                        ),
                         array(
                                'field' => 'contact',
                                'label' => 'contact',
                                'rules' => 'trim|xss_clean',
                        ),
                        array(
                                'field' => 'email',
                                'label' => 'email',
                                'rules' => 'valid_email|trim',
                        ),

		);
 
  $config['plan_type_validation']   = array(
			array(
                                'field' => 'code',
                                'label' => 'code',
                                'rules' => 'required|trim|xss_clean',
                         ),
                        array(
                                'field' => 'name',
                                'label' => 'name',
                                'rules' => 'required|xss_clean',
                        ),

		);