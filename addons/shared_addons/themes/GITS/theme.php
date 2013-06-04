<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_GITS extends Theme {

    public $name = 'GITS';
    public $author = 'Robert Roth';
    public $author_website = 'http://www.groundupsolutions.com/';
    public $website = 'http://www.groundupsolutions.com/';
    public $description = 'GITS template for MedicarePlace';
    public $version = '1.0';
    public $options = array(
        'include_nav_fix' => array(
                            'title' => 'Include Navigation Fix',
                            'description'   => 'Would you like to include a fix for the navigation bar?',
                            'default'       => 'yes',
                            'type'          => 'radio',
                            'options'       => 'yes=Yes|no=No',
                            'is_required'   => TRUE
                        ),
        'navigation_layout' =>  array('title' => 'Navigation layout',
                                'description'   => 'How would you like the navigation displayed?',
                                'default'       => 'bar',
                                'type'          => 'select',
                                'options'       => 'bar=Bar|navbar-fixed-top=Fixed to top|navbar-fixed-bottom=Fixed to bottom',
                                'is_required'   => TRUE),
        );
}

/* End of file theme.php */