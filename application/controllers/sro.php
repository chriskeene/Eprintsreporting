<?php
class Sro extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sro_model');
	}

	public function index()
	{
		//$data['items'] = $this->sro_model->get_nojournaltitle();
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
		$data['title'] = 'SRO recent oa items';
		$this->load->view('templates/header', $data);
		$this->load->view('sro/recentoaitems', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug)
	{
		$eprintid = '10000';
		$data['items'] = $this->sro_model->get_recentoaitems();
		$data['title'] = 'SRO item';
		$this->load->view('templates/header', $data);
		$this->load->view('sro/item', $data);
		$this->load->view('templates/footer');
	}
	
	public function nojournaltitles()
	{
		$data['items'] = $this->sro_model->get_nojournaltitle();
		$data['title'] = 'SRO articles with no journal title';

		$this->load->view('templates/header', $data);
		$this->load->view('sro/nojournaltitles', $data);
		$this->load->view('templates/footer');
	}
	
	public function notsetaspublished()
	{
		$data['items'] = $this->sro_model->get_notsetaspublished();
		$data['title'] = 'SRO items not set as published';

		$this->load->view('templates/header', $data);
		$this->load->view('sro/notsetaspublished', $data);
		$this->load->view('templates/footer');
	}
	
	public function summary()
	{
		$data['total'] = $this->sro_model->get_total();
		$data['oatotals'] = $this->sro_model->get_oatotal_bytype();
		$data['monthtotals'] = $this->sro_model->get_newrecords_bymonth();
		$data['title'] = 'SRO Summary';
		$this->load->view('templates/header', $data);
		$this->load->view('sro/summary', $data);
		$this->load->view('templates/footer');
		
	}	
		
	public function listoa($field, $value)
	{
		$data['oaitems'] = $this->sro_model->get_oalist($field, $value);
		$data['title'] = 'SRO Open Access items list';

		$this->load->view('templates/header', $data);
		$this->load->view('sro/oalist', $data);
		$this->load->view('templates/footer');
	}
}