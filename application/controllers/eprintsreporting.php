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
	public function summarynoheaders()
	{
		//find out current academic year (which starts in august).
		$academicyear = $this->ergeneral->getacademicyear();
		
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
		$this->load->view('summary', $data);
		$this->load->view('records_per_month', $data);
		$this->load->view('open_access_items_added_by_month', $data);
		//$this->load->view('oa_by_type', $data);
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
			// Views
			$this->load->view('templates/header', $data);
			$this->load->view('schoolsummary', $data);
			$this->load->view('records_per_month', $data);
			$this->load->view('open_access_items_added_by_month', $data);
			$this->load->view('templates/footer');
		}
		else {
			$data['schooltotals'] = $this->eprintsreporting_model->get_schools_year();
			$data['title'] = $this->config->item('eprints_name'). ' Schools summary';
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
	
	
	
	
}