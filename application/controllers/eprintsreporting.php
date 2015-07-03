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
	
	public function getrecentoa()
	{
		$data['items'] = $this->eprintsreporting_model->get_recentoaitems();
		$data['title'] = $this->config->item('eprints_name'). ' recent oa items';
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

	public function view($slug)
	{
		$eprintid = '10000';
		$data['items'] = $this->eprintsreporting_model->get_recentoaitems();
		$data['title'] = $this->config->item('eprints_name'). ' item';
		$this->load->view('templates/header', $data);
		$this->load->view('item', $data);
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
		// Views
		$this->load->view('templates/header', $data);
		$this->load->view('summary', $data);
		$this->load->view('records_per_month', $data);
		$this->load->view('open_access_items_added_by_month', $data);
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
			//**********************************************
			// top journals
			$yearsback = "5";
			$realstartyear = date("Y") - $yearsback + 1; // because we don't include the year that's actually given
			$data['topjournals'] = $this->eprintsreporting_model->get_topjournals($yearsback, $school);
			$data['topjournalstext'] = 'The journals most frequently published since ' . 
			$realstartyear . ' including articles yet to be published.';
			// Views
			$this->load->view('templates/header', $data);
			$this->load->view('schoolsummary', $data);
			$this->load->view('records_per_month', $data);
			$this->load->view('open_access_items_added_by_month', $data);
			$this->load->view('topjournals', $data);
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
		$data['title'] = $this->config->item('eprints_name'). ' author info';
		$this->load->view('templates/header', $data);
		$this->load->view('authorbasicinfo', $data);
		$this->load->view('templates/footer');
	
	}
	
	public function gettopjournals($yearsback="5")
	{
		$data['topjournals'] = $this->eprintsreporting_model->get_topjournals($yearsback);
		$realstartyear = date("Y") - $yearsback + 1; // because we don't include the year that's actually given
		$data['topjournalstext'] = 'The journals most frequently published since ' . 
		$realstartyear . ' including articles yet to be published.';
	
		$data['title'] = $this->config->item('eprints_name'). ' Journals most published in';
		$this->load->view('templates/header', $data);
		$this->load->view('topjournals', $data);
		$this->load->view('templates/footer');
	
	}
	
	
	///////////////////////////////////////////////////
	// for a journal listed in the top journals list, display the items that were counted for that journal
	// (for the time period given)
	public function getitemsforjournal($journalname, $yearsback="5")
	{
		$data['items'] = $this->eprintsreporting_model->get_topjournalitems($journalname,$yearsback);
		$realstartyear = date("Y") - $yearsback + 1; // because we don't include the year that's actually given
		$data['topjournalstext'] = 'The journals most frequently published since ' . 
		$realstartyear . ' including articles yet to be published.';
	
		$data['title'] = $this->config->item('eprints_name'). ' Items published in ' . $journalname . ' since ' . $realstartyear;
		$this->load->view('templates/header', $data);
		$this->load->view('itemlist', $data);
		$this->load->view('templates/footer');
	}
	
	
	
}