<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Plan extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Plan Module'
			),
			'description' => array(
				'en' => 'This module will provide the main features of the application for searching and quotation of plan'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'Plan Users' // You can also place modules in their top level menu. For example try: 'menu' => 'Sample',
		);
	}

	public function install()
	{
					
		$plan_users = "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('plan_users') ." (
					  `uid` int(11) NOT NULL AUTO_INCREMENT,
                                            `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `age_bracket` tinyint(2) NOT NULL DEFAULT '0',
                                            `segment` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0= Age below 64 but disabled or Above 64 | 1 = Age below 64 Individual Plan',
                                            `zip_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                                            `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `county` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `state` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `start_coverage` int(9) DEFAULT NULL,
                                            `enrolled_in` tinyint(2) NOT NULL DEFAULT '0',
                                            `birth_date` int(9) DEFAULT NULL,
                                            `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
                                            `preference` tinyint(2) NOT NULL DEFAULT '0',
                                            `student` tinyint(2) NOT NULL DEFAULT '0',
                                            `contact` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
                                            `status` tinyint(2) NOT NULL DEFAULT '0',
                                            `created_date` mediumint(9) DEFAULT NULL,
                                            `created_on` int(11) DEFAULT NULL,
                                            `updated_on` int(11) DEFAULT NULL,
                                            PRIMARY KEY (`uid`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
					";		
		
                $plan_dependants = "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('plan_dependants') ." (
					`id` int(11) NOT NULL AUTO_INCREMENT,
                                        `uid` int(11) NOT NULL,
                                        `type` varchar(15) NOT NULL DEFAULT '0',
                                        `birth_date` int(9) DEFAULT NULL,
                                        `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
                                        `preference` tinyint(2) NOT NULL DEFAULT '0',
                                        `student` tinyint(2) NOT NULL DEFAULT '0',
                                        `created_on` int(11) NOT NULL,
                                        `updated_on` int(11) NOT NULL,
                                          PRIMARY KEY (`id`)
                                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
		
		$selected_plan = "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('selected_plan') ." (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uid` int(11) NOT NULL,
					  `rate_id` int(11) NOT NULL,
					  `status` tinyint(2) NOT NULL DEFAULT '0',
					  `created_on` int(11) NOT NULL,
                                          `updated_on` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
		
                $zipcode_checker = array('slug' => 'zipcode-checker','title' => 'Zip Code Checker');
	
		if( $this->db->insert('widget_areas', $zipcode_checker) AND
                    $this->db->query($plan_users) AND
                    $this->db->query($plan_dependants) AND
                    $this->db->query($selected_plan) AND
		   is_dir($this->upload_path.'plan') OR @mkdir($this->upload_path.'plan',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		/*$this->db->delete('widget_areas', array('slug' => 'zipcode-checker'));
		$this->dbforge->drop_table('plan_users');
        $this->dbforge->drop_table('plan_dependants');
		$this->dbforge->drop_table('selected_plan');
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
		return "No documentation has been added for this module.<br />Contact us at <a href='mailto:help@appsbomb.com'>help@appsbomb.com </a> for assistance.";
	}
}
/* End of file details.php */
