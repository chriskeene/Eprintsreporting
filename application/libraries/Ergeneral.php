<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ergeneral {

    public function some_function()
    {
		echo "hello";
    }
	
	public function get_academicyear()
	{
		// find FIRST calendar year for current academic year: 
		// if aug-dec then current year (eg Oct2013 = 2013/14)
		// if jan-jul it is the year before (eg Feb2013 = 2013/14)
		$currentyear = date("Y");
		$currentmonth = date("m");
		if ($currentmonth > 7) {
			$academicyear = $currentyear;
		}
		else {
			$academicyear = $currentyear - 1;
		}
		return $academicyear;
	}
	
	public function get_academicmonthlist()
	{
		return array("Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"); 
	}
	
}

/* End of file eprintsreporting.php */