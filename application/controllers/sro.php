<?php
class Sro extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sro_model');
	}

	public function index()
	{
		$data['total'] = $this->sro_model->get_total();
		$data['oatotals'] = $this->sro_model->get_oatotal_bytype();
		$data['monthtotals'] = $this->sro_model->get_newrecords_bymonth();
		$data['title'] = 'SRO Reporting';

		$this->load->view('templates/header', $data);
		$this->load->view('sro/index', $data);
		$this->load->view('templates/footer');
	}
	
	public function getrecentoa()
	{
		$data['items'] = $this->sro_model->get_recentoaitems();
		$data['title'] = $this->config->item('eprints_name'). ' recent oa items';
		$this->load->view('templates/header', $data);
		$this->load->view('sro/recentoaitems', $data);
		$this->load->view('templates/footer');
	}
	
	public function getrecentfunder()
	{
		$data['items'] = $this->sro_model->get_recentfunderitems();
		$data['title'] = $this->config->item('eprints_name'). ' recent funder items';
		$this->load->view('templates/header', $data);
		$this->load->view('sro/recentfunderitems', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug)
	{
		$eprintid = '10000';
		$data['items'] = $this->sro_model->get_recentoaitems();
		$data['title'] = $this->config->item('eprints_name'). ' item';
		$this->load->view('templates/header', $data);
		$this->load->view('sro/item', $data);
		$this->load->view('templates/footer');
	}
	
	public function nojournaltitles()
	{
		$data['items'] = $this->sro_model->get_nojournaltitle();
		$data['title'] = $this->config->item('eprints_name'). ' articles with no journal title';

		$this->load->view('templates/header', $data);
		$this->load->view('sro/nojournaltitles', $data);
		$this->load->view('templates/footer');
	}
	
	public function notsetaspublished()
	{
		$data['items'] = $this->sro_model->get_notsetaspublished();
		$data['title'] = $this->config->item('eprints_name'). ' items not set as published';

		$this->load->view('templates/header', $data);
		$this->load->view('sro/notsetaspublished', $data);
		$this->load->view('templates/footer');
	}
	
	public function summary()
	{
		$data['total'] = $this->sro_model->get_total();
		$data['oatotals'] = $this->sro_model->get_oatotal_bytype();
		$data['monthtotals'] = $this->sro_model->get_newrecords_bymonth();
		$data['title'] = $this->config->item('eprints_name'). ' Summary';
		$this->load->view('templates/header', $data);
		$this->load->view('sro/summary', $data);
		$this->load->view('templates/footer');
		
	}	
		
	public function listoa($field, $value)
	{
		$data['oaitems'] = $this->sro_model->get_oalist($field, $value);
		$data['title'] = $this->config->item('eprints_name'). ' Open Access items list';

		$this->load->view('templates/header', $data);
		$this->load->view('sro/oalist', $data);
		$this->load->view('templates/footer');
	}
	
	public function school()
	{
		
	}
}