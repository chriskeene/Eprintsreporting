<?php
class eprintsreporting extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// load model
		$this->load->model('eprintsreporting_model');
		// load a library for eprintsreporting common functions
		$this->load->library('ergeneral');
	}

	public function index()
	{
		// needed for itemtype links
		$data['academicyear'] = $this->ergeneral->get_academicyear();
	
		$data['total'] = $this->eprintsreporting_model->get_total();
		$data['oatotals'] = $this->eprintsreporting_model->get_oatotal_bytype();
		$data['monthtotals'] = $this->eprintsreporting_model->get_newrecords_bymonth();
		$data['title'] = 'SRO Reporting';

		$this->load->view('templates/header', $data);
		$this->load->view('index', $data);
		$this->load->view('templates/footer');
	}
	
		public function admin()
	{
		$data['total'] = $this->eprintsreporting_model->get_total();
		$data['oatotals'] = $this->eprintsreporting_model->get_oatotal_bytype();
		$data['monthtotals'] = $this->eprintsreporting_model->get_newrecords_bymonth();
		$data['title'] = 'SRO Reporting';

		$this->load->view('templates/header', $data);
		$this->load->view('backoffice', $data);
		$this->load->view('templates/footer');
	}
	
	//////////////////////////////////////////////
	// Show recent items where the OA fields have been used.
	public function getrecentoafield()
	{
		$data['items'] = $this->eprintsreporting_model->get_recentoafielditems();
		$data['title'] = $this->config->item('eprints_name'). ' Recent items with OA fields used';
		$this->load->view('templates/header', $data);
		$this->load->view('recentoaitems', $data);
		$this->load->view('templates/footer');
	}
	
	public function getrecentfunder()
	{
		$data['items'] = $this->eprintsreporting_model->get_recentfunderitems();
		$data['title'] = $this->config->item('eprints_name'). ' recent funder items';
		$this->load->view('templates/header', $data);
		$this->load->view('recentfunderitems', $data);
		$this->load->view('templates/footer');
	}

	
	public function nojournaltitles()
	{
		$data['items'] = $this->eprintsreporting_model->get_nojournaltitle();
		$data['title'] = $this->config->item('eprints_name'). ' articles with no journal title';

		$this->load->view('templates/header', $data);
		$this->load->view('nojournaltitles', $data);
		$this->load->view('templates/footer');
	}
	
	public function notsetaspublished($months="0")
	{
		$data['items'] = $this->eprintsreporting_model->get_notsetaspublished($months);
		$data['title'] = $this->config->item('eprints_name'). ' items not set as published';
		$data['months'] = $months;

		$this->load->view('templates/header', $data);
		$this->load->view('notsetaspublished', $data);
		$this->load->view('templates/footer');
	}
	
	public function summary()
	{
		//find out current academic year (which starts in august).
		$academicyear = $this->ergeneral->get_academicyear();
		
		$data['total'] = $this->eprintsreporting_model->get_total();
		$data['oatotals'] = $this->eprintsreporting_model->get_oatotal_bytype();
		$data['monthtotals'] = $this->eprintsreporting_model->get_newrecords_bymonth();
		$data['title'] = $this->config->item('eprints_name'). ' Summary';
		// ***************************************************
		// get current academic year records
		$data['thisyear'] = $this->eprintsreporting_model->get_year_new_records($academicyear);
		$previousyear = $academicyear - 1; // get previous academic year
		$data['previousyear'] = $this->eprintsreporting_model->get_year_new_records($previousyear);
		// and year before that
		$threeyearsago = $previousyear - 1;
		$data['threeyearsago'] = $this->eprintsreporting_model->get_year_new_records($threeyearsago);
		//*******************************************************
		// OA by month
		$data['thisyearoa'] = $this->eprintsreporting_model->get_year_monthly_oa($academicyear);
		$previousyear = $academicyear - 1; // get previous academic year
		$data['previousyearoa'] = $this->eprintsreporting_model->get_year_monthly_oa($previousyear);
		// and OA year before that
		$threeyearsago = $previousyear - 1;
		$data['threeyearsagooa'] = $this->eprintsreporting_model->get_year_monthly_oa($threeyearsago);
		//*******************************************************
		// OA summary
		$data['thisyearoasummary'] = $this->eprintsreporting_model->get_oasummary($academicyear);
		$data['previousyearoasummary'] = $this->eprintsreporting_model->get_oasummary($previousyear);
		$data['threeyearoasummary'] = $this->eprintsreporting_model->get_oasummary($threeyearsago);
		// ***************************************************************
		// Views
		$this->load->view('templates/header', $data);
		$this->load->view('summary', $data);
		$this->load->view('records_per_month', $data);
		$this->load->view('open_access_items_added_by_month', $data);
		$this->load->view('oasummary', $data);
		$this->load->view('oa_by_type', $data);
		$this->load->view('records_per_month_calendar_year', $data);
		$this->load->view('templates/footer');
		
	}	
	
	// for public statistics page
	public function briefsummarynoheaders()
	{
		//find out current academic year (which starts in august).
		$academicyear = $this->ergeneral->get_academicyear();
		
		$data['total'] = $this->eprintsreporting_model->get_total();
		$data['oatotals'] = $this->eprintsreporting_model->get_oatotal_bytype();
		$data['monthtotals'] = $this->eprintsreporting_model->get_newrecords_bymonth();
		$data['title'] = $this->config->item('eprints_name'). ' Summary';
		$data['thisyear'] = $this->eprintsreporting_model->get_year_new_records($academicyear);
		
		//*******************************************************
		// Views
		$this->load->view('summary', $data);

	}	
		
	////////////////////////////////////////////////	
	// show a list of OA, filtered by a specified field. eg 'type' 'article'
	public function listoa($field, $value)
	{
		$data['oaitems'] = $this->eprintsreporting_model->get_oalist($field, $value);
		$data['title'] = $this->config->item('eprints_name'). ' Open Access items list';

		$this->load->view('templates/header', $data);
		$this->load->view('oalist', $data);
		$this->load->view('templates/footer');
	}
	
	
	
	public function school($school="")
	{
		//find out current academic year (which starts in august).
		$academicyear = $this->ergeneral->get_academicyear();
		
		// a summary of all schools, unless we have been passed a school code.
		if ($school) {
			$data['schooltotals'] = $this->eprintsreporting_model->get_school_summary($school);
			// name 
			$schoolname = $data['schooltotals']['schoolname'];
			$data['title'] = $this->config->item('eprints_name'). " " . $schoolname . ' summary';
			
			//***********************
			// get current academic year records for each month
			$data['thisyear'] = $this->eprintsreporting_model->get_year_new_records($academicyear, $school);
			$previousyear = $academicyear - 1; // get previous academic year
			$data['previousyear'] = $this->eprintsreporting_model->get_year_new_records($previousyear, $school);
			// and year before that
			$threeyearsago = $previousyear - 1;
			$data['threeyearsago'] = $this->eprintsreporting_model->get_year_new_records($threeyearsago, $school);
			//*************************************
			// OA by month
			$data['thisyearoa'] = $this->eprintsreporting_model->get_year_monthly_oa($academicyear, $school);
			$previousyear = $academicyear - 1; // get previous academic year
			$data['previousyearoa'] = $this->eprintsreporting_model->get_year_monthly_oa($previousyear, $school);
			// and year before that
			$threeyearsago = $previousyear - 1;
			$data['threeyearsagooa'] = $this->eprintsreporting_model->get_year_monthly_oa($threeyearsago, $school);
			// OA summary
			$data['thisyearoasummary'] = $this->eprintsreporting_model->get_oasummary($academicyear, $school);
			$data['previousyearoasummary'] = $this->eprintsreporting_model->get_oasummary($previousyear, $school);
			$data['threeyearoasummary'] = $this->eprintsreporting_model->get_oasummary($threeyearsago, $school);
			// Views
			$this->load->view('templates/header', $data);
			$this->load->view('schoolsummary', $data);
			$this->load->view('records_per_month', $data);
			$this->load->view('open_access_items_added_by_month', $data);
			$this->load->view('oasummary', $data);
			$this->load->view('templates/footer');
		}
		else {
			$data['schooltotals'] = $this->eprintsreporting_model->get_schools_year();
			$data['title'] = $this->config->item('eprints_name'). ' Schools summary';
			// get list of schools
			$data['schoollist'] = $this->eprintsreporting_model->get_schoollist();
			// for each school get total of monthly add items
			foreach ($data['schoollist'] as $oneschool) {
				// for this school, get the number of records added for this academic year
				$data['schoolrecords'][$oneschool->schoolid] = $this->eprintsreporting_model->get_year_new_records($academicyear, $oneschool->schoolid);
				// for this school, get the number of oa items added this academic year
				$data['schooloa'][$oneschool->schoolid] = $this->eprintsreporting_model->get_year_monthly_oa($academicyear, $oneschool->schoolid);
				//$data['schooloa'][$oneschool->schoolid]['schoolname'] = $oneschool->schoolname;
			}
			
			$this->load->view('templates/header', $data);
			$this->load->view('schoolssummary', $data);
			$this->load->view('templates/footer');
	
		
		}
		
	}
	
	// show list of full text items which have an embargo which is soon to expire.
	public function embargoexpire()
	{
		$data['items'] = $this->eprintsreporting_model->get_embargoexpire();
		$data['title'] = $this->config->item('eprints_name'). ' Full text items with embargo expiring';
		
		$this->load->helper('url');
		$this->load->library('pagination');

		$config['base_url'] = site_url('eprintsreporting/embargoexpire/');
		$config['total_rows'] = 5000;
		$config['per_page'] = 100;
		$config['uri_segment'] = 4;

		$this->load->view('templates/header', $data);
		$this->load->view('embargoitems', $data);
		$this->load->view('templates/footer');

	}
	
	// show list items for a school that have an author from another School. interdisciplinary
	public function interdisciplinary($school="s921")
	{
		$data['items'] = $this->eprintsreporting_model->get_interdisciplinary($school);
		$schoolnames = $this->eprintsreporting_model->get_schoolnames();
		$data['title'] = $this->config->item('eprints_name'). ': ' . $schoolnames[$school] . ' interdisciplinary research';
	

		$this->load->view('templates/header', $data);
		$this->load->view('interdisciplinary', $data);
		$this->load->view('templates/footer');

	}
	
	public function author($author="150000")
	{
		$data['author'] = $this->eprintsreporting_model->get_authorinfo($author);
		$data['items'] = $this->eprintsreporting_model->get_authoritems($author);
		
		$data['title'] = $this->config->item('eprints_name'). ' author info';
		$this->load->view('templates/header', $data);
		$this->load->view('authorbasicinfo', $data);
		$this->load->view('itemlist', $data);
		$this->load->view('templates/footer');
	
	}
	
	public function gettopjournals($yearsback="5", $school="")
	{
		$data['topjournals'] = $this->eprintsreporting_model->get_topjournals($yearsback,$school);
		// Add one to years back. ie people expect 'last 1 year' to be this year. 
		// Yet 2015 - 1 - 2014, so would show current year and previous year.
		// adding one fixes this.
		$realstartyear = date("Y") - $yearsback + 1; // because we don't include the year that's actually given
		
		if ($school) {
			$schoolnames = $this->eprintsreporting_model->get_schoolnames();
			$data['topjournalstext'] = 'The journals most frequently published in by the' . 
			$schoolnames[$school] . ' since ' . $realstartyear . '. Including articles yet to be published.';
		}
		else {
			$data['topjournalstext'] = 'The journals most frequently published in since ' . 
				$realstartyear . ', including articles yet to be published.';
		}
		
		// for the link to the list of actual items
		$data['yearsback'] = $yearsback;
	
		$data['title'] = $this->config->item('eprints_name'). ' Journals most published in';
		
		$this->load->view('templates/header', $data);
		$this->load->view('topjournals', $data);
		$this->load->view('templates/footer');
	
	}
	
	
	///////////////////////////////////////////////////
	// for a journal listed in the top journals list, display the items that were counted for that journal
	// (for the time period given)
	public function getitemsforjournal($journalname, $yearsback="5", $school="")
	{
		$journalname = urldecode($journalname);
		$data['items'] = $this->eprintsreporting_model->get_topjournalitems($journalname,$yearsback,$school);
		$realstartyear = date("Y") - $yearsback + 1; // because we don't include the year that's actually given
		
	
		$data['title'] = $this->config->item('eprints_name'). ' Items published in ' . $journalname . ' since ' . $realstartyear;
		$this->load->view('templates/header', $data);
		$this->load->view('itemlist', $data);
		$this->load->view('templates/footer');
	}
	
	
	///////////////////////////////////////////////
	// 
	public function recentoa($school="none", $offset="0")
	{
		$data['items'] = $this->eprintsreporting_model->get_recentoa($school,$offset);
		$tmp = count ($data['items']);

		$data['title'] = $this->config->item('eprints_name'). ' Recently added OA items (open or under embargo)';
		
		$this->load->helper('url');
		$this->load->library('pagination');

		$config['base_url'] = site_url('eprintsreporting/recentoa/' . $school .'/');
		$config['total_rows'] = 5000;
		$config['per_page'] = 100;
		$config['uri_segment'] = 4;

		$this->pagination->initialize($config); 
		
		
		$this->load->view('templates/header', $data);
		$this->load->view('embargoitems', $data);
		$this->load->view('templates/footer');
	}
	
	
	/////////////////////////////////////////////
	// show a list of authors, order by those who have published the most
	public function topauthors($yearsback="5", $school="")
	{
		$data['items'] = $this->eprintsreporting_model->get_topauthors($yearsback, $school);
		$data['title'] = 'Authors with the most items in ' .$this->config->item('eprints_name');
		$this->load->view('templates/header', $data);
		$this->load->view('authorlist', $data);
		$this->load->view('templates/footer');
	}
	
	
	/////////////////////////////////////////////
	// show a list of authors, order by those who have published the most
	public function itemtype($year="")
	{
		if (empty($year)) {
			//find out current academic year (which starts in august).
			$year = $this->ergeneral->get_academicyear();
		}
	
		// get list of schools
		$schoollist = $this->eprintsreporting_model->get_schoollist();
		$itemtypetotals = $this->eprintsreporting_model->get_totalsbytype($year, "");

		$schools=array();
		
		foreach ($schoollist as $school) {
			$schools[$school->schoolid]['schoolid'] = $school->schoolid;
			$schools[$school->schoolid]['schoolname'] = $school->schoolname;
		}

		foreach ($itemtypetotals as $currenttotal) {
			if (isset($currenttotal->total)) {
				$schools[$currenttotal->subjectid][$currenttotal->type] = $currenttotal->total;
			} 
			else {
				$schools[$currenttotal->subjectid][$currenttotal->type] = "0";
			}
		}
		//print_r($schools);
		$data['schools'] = $schools;
		
		$data['title'] = $this->config->item('eprints_name'). ' Number of items by item type';
		$data['introtext'] = "Number of items by type for " . $year . "/" . ($year+1);
		$this->load->view('templates/header', $data);
		$this->load->view('itemtype', $data);
		$this->load->view('templates/footer');
	}
	
	
	/////////////////////////////////////////////
	// show a list of recent articles which have no file attached, ie not oa
	public function notoaarticles($year="", $school="")
	{
		$lastyear = date("Y",strtotime("-1 year"));
		if (empty($year) || $year =="0" ) {
			$year = $lastyear;
		}	
	
		$data['items'] = $this->eprintsreporting_model->get_nooaarticles($year, $school);
		$data['title'] = $this->config->item('eprints_name'). ' articles with that are not OA';
		$data['introtext'] = 'Recent article records with no file attached at all. (only includes articles published since ' . $year . ').';
		$this->load->view('templates/header', $data);
		$this->load->view('itemlist', $data);
		$this->load->view('templates/footer');
	}
	
	
	//to do...
	// page per year
	// author page, show month records and full text tables
	// top oa authors
	
}