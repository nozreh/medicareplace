<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_medicare_data_importer extends Module {

	public $version = '1.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Medicare Data Importer'
				),
			'description' => array(
				'en' => 'Upload existing rates data. To see open "Utilities > Medicare Data Importer"'
				),
			'frontend' => false,
			'backend' => true,
			'menu' => 'utilities', // You can also place modules in their top level menu. For example try: 'menu' => 'Medicare Data Importer',
			'sections' => array(
				'rates' => array(
					'name' 	=> 'medicare_data_importer:rates', // These are translated from your language file
					'uri' 	=> 'admin/medicare_data_importer',
					'shortcuts' => array(
						'upload' => array(
							'name' 	=> 'medicare_data_importer:upload',
							'uri' 	=> 'admin/medicare_data_importer/upload_rate',
							'class' => 'add'
							),
                                                 'create' => array(
							'name' 	=> 'medicare_data_importer:create',
							'uri' 	=> 'admin/medicare_data_importer/create_rate',
							'class' => 'add'
							)
						)
					),
                                 'companies' => array(
					'name' 	=> 'medicare_data_importer:companies', // These are translated from your language file
					'uri' 	=> 'admin/medicare_data_importer/company',
					'shortcuts' => array(
                                                 'create_company' => array(
							'name' 	=> 'medicare_data_importer:create_company',
							'uri' 	=> 'admin/medicare_data_importer/create_company',
							'class' => 'add'
							)
						)
					),
                                  'plans' => array(
					'name' 	=> 'medicare_data_importer:plans', // These are translated from your language file
					'uri' 	=> 'admin/medicare_data_importer/plan',
					'shortcuts' => array(
                                                 'create_plan' => array(
							'name' 	=> 'medicare_data_importer:create_plan',
							'uri' 	=> 'admin/medicare_data_importer/create_plan',
							'class' => 'add'
							)
						)
					),
                            
				)
			);
	}

	public function install()
	{

	  $medicare_rates = "CREATE TABLE " . $this->db->dbprefix('rates') ." (
					  	`id` int(11) NOT NULL AUTO_INCREMENT,
                                                `plan_id` int(11) NOT NULL,
                                                `company_id` int(11) NOT NULL,
                                                `zipcode` text NOT NULL,
                                                `preference` int(2) NOT NULL,
                                                `age` smallint(3) NOT NULL,
                                                `segment` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '0 = Age below 64 Disabled or Older than 64 | 1= Age below 64 Individual Plan'
                                                `amount` decimal(10,2) NOT NULL,
                                                `addon_amount` decimal(10,2) NOT NULL,
                                                `remarks` text,
                                                `created_on` int(11) NOT NULL,
                                                 `updated_on` int(11) NOT NULL DEFAULT '0',
                                                PRIMARY KEY (`id`)
                                              ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
					";
		
		$medicare_plan = "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('plan') ." (
					  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `code` varchar(30) NOT NULL,
					  `name` varchar(100) NOT NULL,
					  `status` int(2) NOT NULL COMMENT '0=Inactive, 1=Active',
                                          `basic_benefits` int(2) NOT NULL COMMENT '0=No, 1=Yes',
                                          `skilled_nursing` int(2) NOT NULL COMMENT '0=No, 1=Yes',
                                          `part_b_excess` int(2) NOT NULL COMMENT '0=No, 1=Yes',
                                          `part_a_deductible` int(2) NOT NULL COMMENT '0=No, 1=Yes',
                                          `part_b_deductible` int(2) NOT NULL COMMENT '0=No, 1=Yes',
                                          `foreign_travel` int(2) NOT NULL COMMENT '0=No, 1=Yes',
					  `created_on` int(11) NOT NULL DEFAULT '0',
                                          `updated_on` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
					";
		
		$medicare_company = "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('company') ." (
                                            `id` int(11) NOT NULL AUTO_INCREMENT,
                                            `code` varchar(30) NOT NULL,
                                            `name` varchar(100) NOT NULL,
                                            `address` text NULL,
                                            `contact` varchar(25) NULL,
                                            `email` varchar(50) NULL,
                                            `website` text NULL,
                                            `status` int(2) NOT NULL,
                                            `created_on` int(11) NOT NULL,
                                            `updated_on` int(11) NOT NULL,
                                            PRIMARY KEY (`id`)
                                          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
					";
                $medicare_zipcodes = "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('zipcode') ." (
                                            `id` int(11) NOT NULL AUTO_INCREMENT,
                                            `zip` char(5) NOT NULL,
                                            `city` varchar(25) NOT NULL,
                                            `state` char(5) NOT NULL,
                                            `latitude` decimal(18,15) DEFAULT NULL,
                                            `longitude` decimal(18,15) DEFAULT NULL,
                                            `timezone` tinyint(2) NOT NULL,
                                            `created_on` int(11) NOT NULL,
                                            PRIMARY KEY (`id`)
                                          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
					";
	
		if($this->db->query($medicare_rates) AND
			$this->db->query($medicare_plan) AND
			$this->db->query($medicare_company) AND
                        $this->db->query($medicare_zipcodes) AND
		   is_dir($this->upload_path.'medicare_data_importer') OR @mkdir($this->upload_path.'medicare_data_importer',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('rates');
                $this->dbforge->drop_table('plan');
		/*$this->dbforge->drop_table('company');
                $this->dbforge->drop_table('zipcode');
                 */
		return TRUE;
	
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
