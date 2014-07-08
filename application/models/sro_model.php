<?php
class Sro_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}


	public function get_items($eprintid = "10000")
	{
		
		$query = $this->db->query('Select eprintid, title, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS livedate, date_year, publication, id_number, ispublished
			from eprint e
			where e.eprintid = "10000"
			AND eprint_status = "archive"
			AND type = "article"
			ORDER BY e.datestamp_year desc, e.datestamp_month
			');
		return $query->row_array();
	}
	
	public function get_nojournaltitle()
	{
			$query = $this->db->query('Select eprintid, title, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS livedate, date_year, publication, id_number, ispublished, e.issn
			from eprint e
			where (publication is null or publication = "")
			AND eprint_status = "archive"
			AND type = "article"
			ORDER BY e.datestamp_year desc, e.datestamp_month
			');
			return $query->result_array();
	}
	
	public function get_recentoaitems()
	{
		$query = $this->db->query('select e.eprintid, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS livedate, 
		date_year, e.oa_status, e.oa_embargo_length, e.oa_licence_type, 
		group_concat(DISTINCT ff.funder_information_funder SEPARATOR ", and ") As funder,  
			e.title, e.publisher, e.ispublished, e.`type`, e.id_number,
			group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors
			from eprint e
			left outer join eprint_funder_information_funder ff on ff.eprintid = e.eprintid
			left outer join eprint_funder_information_funder_ref fr on (fr.eprintid = ff.eprintid AND fr.pos = ff.pos)
			JOIN eprint_creators_id i on e.eprintid = i.eprintid
 			JOIN eprint_creators_name n on n.eprintid = i.eprintid AND n.pos = i.pos
			Where (e.oa_status is not null
				OR e.oa_embargo_length is not null
				OR e.oa_licence_type is not null)
			AND e.eprint_status = "archive"
			and i.creators_id is not null
			GROUP BY e.eprintid
			ORDER BY e.datestamp_year desc, e.datestamp_month desc, e.datestamp_day desc
		');
		return $query->result_array();
	}

	public function get_notsetaspublished()
	{		
		$query = $this->db->query('
			select e.eprintid, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS livedate, e.title, e.ispublished, e.type, e.date_year as pubyear, e.date_month as pubmonth, e.publication,
			e.id_number, e.volume, e.number
			from eprint e
			where e.ispublished != "pub"
			and e.eprintid > 10000
			and e.eprint_status = "archive"
			and e.datestamp_year < 2014
			and e.`type` != "thesis"
			order by e.type, e.datestamp_year, e.datestamp_month, e.datestamp_day
		');
		return $query->result_array();
		
		
	}
	
	public function get_total()
	{
		return $this->db->select('count(*) as total')
                        ->from('eprint')
                        ->where('eprint_status', "archive")
                        ->get()
                        ->result();
	}
	
	public function get_oatotal_bytype()
	{
		return $this->db->select('count(*) as total, e.type')
						->from('document f')
						->join('eprint e', 'e.eprintid = f.eprintid')
						->where('e.eprint_status', "archive")
						->where('format like "application%"')
						->where('security', 'public')
						->group_by('type with rollup')
						->get()
                        ->result();
	}
	
	// need to work out current year
	public function get_newrecords_bymonth()
	{
		return $this->db->select('count(*) as total, concat(datestamp_month,"/",datestamp_year) as "monthadded"', FALSE)
						->from('eprint')
						->where('eprint_status', 'archive')
						->where('datestamp_year', '2014')
						->group_by('datestamp_month with rollup')
						->get()
                        ->result();
	}
	
	public function get_oalist($field, $value)
	{
		return $this->db->select('e.eprintid, concat(datestamp_year, "/", datestamp_month, "/", datestamp_day) as datelive, e.title, e.type, e.date_year', FALSE)
					->from('document f')
					->join('eprint e' , 'e.eprintid = f.eprintid')
					->where('e.eprint_status', "archive")
					->where('f.format like "application%"')
					->where('f.security', 'public')
					->where($field,$value)
					->group_by('f.eprintid')
					->order_by('datelive')
					->get()
                    ->result();
	}

}