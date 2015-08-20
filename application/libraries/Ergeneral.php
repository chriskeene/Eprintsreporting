<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ergeneral {

	// return the first year of the current academic year 
	// Eg todays date April 2015 = 2014 (for 2014/15)
	// Eg todays date Oct 2015 = 2015 (for 2015/16)
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
	
	// return a list of academic month names in the right order.
	public function get_academicmonthlist()
	{
		return array("Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"); 
	}
	
	// return a list of item type names.
	public function get_itemtypelist()
	{
		return array(
			"article" => "Article",
			"book" => "Book",
			"book_section" => "Book Chapter",
			"composition" => "Composition",
			"conference_item" => "Conference item",
			"edited_book" => "Edited Book",
			"exhibition" => "Exhibition",
			"monograph" => "Project Report or paper",
			"other" => "Other",
			"patent" => "Patent",
			"performance" => "Performance",
			"thesis" => "Thesis",
			"total" => "Total"); 
	}

	
}

/* End of file eprintsreporting.php */