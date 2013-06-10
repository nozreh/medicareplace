<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['validation_register'] =  array(
			
                        array(
				'field' => 'zip_code',
				'label' => 'Zip Code',
				'rules' => 'trim|required'
			),
                        array(
				'field' => 'start_coverage',
				'label' => 'Start Date for coverage',
				'rules' => 'trim|required'
			),
                        array(
				'field' => 'enrolled_in',
				'label' => 'Are you enrolled in Medicare Parts A and B?',
				'rules' => 'trim|required'
			),
                        array(
				'field' => 'birth_date',
				'label' => 'Birth Date',
				'rules' => 'required|trim|required|callback_birth_date_check'
			),
                        array(
				'field' => 'gender',
				'label' => 'Gender',
				'rules' => 'trim|required'
			),
                        array(
				'field' => 'preference',
				'label' => 'Smoker',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'first_name',
				'label' => 'First Name',
				'rules' => 'max_length[40]|required'
			),
			array(
				'field' => 'last_name',
				'label' => 'Last Name',
				'rules' => 'max_length[40]|required'
			),
                        array(
				'field' => 'address',
				'label' => 'Address',
				'rules' => 'required'
			),
                        array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'trim|required'
			),
                        array(
				'field' => 'state',
				'label' => 'State',
				'rules' => 'trim|required'
			),
                         array(
				'field' => 'contact',
				'label' => 'Phone',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'email',
				'label' => 'E-mail Address',
				'rules' => 'trim|required'
			)
		);


$config['validation_individual'] =  array(
			
                        
                        array(
				'field' => 'zip_code',
				'label' => 'Zip Code',
				'rules' => 'trim|required'
			),
                        array(
				'field' => 'start_coverage',
				'label' => 'Start Date for coverage',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'first_name',
				'label' => 'First Name',
				'rules' => 'max_length[40]|required'
			),
			array(
				'field' => 'last_name',
				'label' => 'Last Name',
				'rules' => 'max_length[40]|required'
			),
                        array(
				'field' => 'address',
				'label' => 'Address',
				'rules' => 'required|xss_clean'
			),
                        array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'trim|required'
			),
                        /*array(
				'field' => 'County',
				'label' => 'Address',
				'rules' => 'trim|required'
			),*/
                        array(
				'field' => 'state',
				'label' => 'State',
				'rules' => 'trim|required'
			),
                         array(
				'field' => 'contact',
				'label' => 'Phone',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'email',
				'label' => 'E-mail Address',
				'rules' => 'trim|required'
			)
		);