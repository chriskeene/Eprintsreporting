<?php
class eprintsreporting_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		// load a library for eprintsreporting common functions
		//$this->load->library('ergeneral');
	}

	
	// total number of records live in the system
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
		return $this->db->select('count(distinct e.eprintid) as total, e.type')
						->from('document f')
						->join('eprint e', 'e.eprintid = f.eprintid')
						->where('e.eprint_status', "archive")
						->where('format like "application%"')
						->where('security', 'public')
						->group_by('type with rollup')
						->get()
                        ->result();
	}
	
	// very simple 
	public function get_newrecords_bymonth()
	{
		$currentyear = date("Y");
		return $this->db->select('count(*) as total, concat(datestamp_month,"/",datestamp_year) as "monthadded"', FALSE)
						->from('eprint')
						->where('eprint_status', 'archive')
						->where('datestamp_year', "$currentyear")
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
					->like('f.format', 'application', 'after')
					->where('f.security', 'public')
					->where($field,$value)
					->group_by('f.eprintid')
					->order_by('datelive')
					->get()
                    ->result();
	}
	
	// this shows data for ALL schools
	public function get_schools_year()
	{
		// we're returning more than one query, so chuck it all in an array
		$schoolsarray=array();
		// first get total records for each School
		$query = $this->db->select('COUNT( * ) AS  "total", t.name_name as "school", t.subjectid as "schoolid"', FALSE)
					->from('eprint e')
					->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
					->join('subject_ancestors a' , 'd.divisions = a.subjectid')
					->join('subject_name_name t' , 'a.ancestors = t.subjectid')
					->where('e.eprint_status', "archive")
					->where('a.pos', '1')
					->group_by('t.name_name')
					->order_by('t.name_name')
					->get();
		foreach ($query->result() as $row) {
			// add results to multi-dem array. use schoolid as id 
			$schoolsarray["$row->schoolid"]["schoolid"] = "$row->schoolid";
			$schoolsarray["$row->schoolid"]["schoolname"] = "$row->school";
			$schoolsarray["$row->schoolid"]["schooltotalrecords"] = "$row->total";
		}
		
		// now add oa totals to each school
		$query = $this->db->select('count(distinct e.eprintid) as "total", t.name_name as "school", t.subjectid as "schoolid"', FALSE)
					->from('document f')
					->join('eprint e' , 'e.eprintid = f.eprintid')
					->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
					->join('subject_ancestors a' , 'd.divisions = a.subjectid')
					->join('subject_name_name t' , 'a.ancestors = t.subjectid')
					->where('e.eprint_status', "archive")
					->like('f.format', 'application', 'after')
					->where('f.security', 'public')
					->where('a.pos', '1')
					->where('t.subjectid !=', 'd328')
					->group_by('t.subjectid')
					->get();
		foreach ($query->result() as $row) {
			$schoolsarray["$row->schoolid"]["schooloatotal"] = "$row->total";
		}
		
		return $schoolsarray;
					
	}
	
	// show data for just one school - as specified.
	public function get_school_summary($school)
	{
		$schoolarray=array();
		$query = $this->db->select('COUNT( * ) AS  "total", t.name_name as "school", t.subjectid as "schoolid"', FALSE)
					->from('eprint e')
					->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
					->join('subject_ancestors a' , 'd.divisions = a.subjectid')
					->join('subject_name_name t' , 'a.ancestors = t.subjectid')
					->where('e.eprint_status', "archive")
					->where('a.pos', '1')
					->where('t.subjectid', $school)
					->group_by('t.name_name')
					->order_by('t.name_name')
					->get();
		foreach ($query->result() as $row) {
			$schoolarray["schoolid"] = "$row->schoolid";
			$schoolarray["schoolname"] = "$row->school";
			$schoolarray["totalrecords"] = "$row->total";
		}
		// now get oa data.
		$query = $this->db->select('count(distinct e.eprintid) as "total", t.name_name as "school", t.subjectid as "schoolid"', FALSE)
					->from('document f')
					->join('eprint e' , 'e.eprintid = f.eprintid')
					->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
					->join('subject_ancestors a' , 'd.divisions = a.subjectid')
					->join('subject_name_name t' , 'a.ancestors = t.subjectid')
					->where('e.eprint_status', "archive")
					->like('f.format', 'application', 'after')
					->where('f.security', 'public')
					->where('a.pos', '1')
					->where('t.subjectid', $school)
					->group_by('t.subjectid')
					->get();
		foreach ($query->result() as $row) {
			$schoolarray["oatotal"] = "$row->total";
		}
		
		return $schoolarray;
	}
	
	//get a list of schools 
	public function get_schoollist()
	{
		return $this->db->select('t.subjectid as "schoolid", t.name_name as "schoolname"')
						->from('eprint e')
						->join('eprint_divisions d', 'e.eprintid = d.eprintid')
						->join('subject_ancestors a', 'd.divisions = a.subjectid')
						->join('subject_name_name t', 'a.ancestors = t.subjectid')
						->where('e.eprint_status', "archive")
						->where('t.subjectid not like "d%"')
						->where('a.pos', '1')
						->group_by('t.name_name')
						->order_by('t.name_name')
						->get()
                        ->result();
	
	}
	
	//get a list of most popular journals 
	public function get_topjournals($years="4", $school="")
	{
		$startdate = date("Y") - $years;
		return $this->db->select('count(distinct e.eprintid) as total, publication, type, e.publisher, group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as "authors"', FALSE)
						->from('eprint e')
						->join('eprint_divisions d', 'e.eprintid = d.eprintid')
						->join('subject_ancestors a', 'd.divisions = a.subjectid')
						->join('subject_name_name t', 'a.ancestors = t.subjectid')
						->join('eprint_creators_id i', 'e.eprintid = i.eprintid')
						->join('eprint_creators_name n', 'n.eprintid = i.eprintid AND n.pos = i.pos')
						->where('e.eprint_status', "archive")
						->where('publication is not null')
						->where('a.pos', '1')
						->where('e.date_year >', $startdate)
						->where('t.subjectid', $school)
						->where('i.creators_id is not null')
						->where('type', 'article')
						->group_by('upper(publication)')
						->order_by('count(distinct e.eprintid) desc')
						->limit('20')
						->get()
                        ->result();
	
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
	
	public function get_recentfunderitems()
	{
		$query = $this->db->query('select e.eprintid, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS 	livedate, 
			date_year, e.oa_status, e.oa_embargo_length, e.oa_licence_type, 
			group_concat(DISTINCT ff.funder_information_funder SEPARATOR ", and ") As funder,
			group_concat(DISTINCT fr.funder_information_funder_ref SEPARATOR ", and ") As funderref,
			group_concat(DISTINCT fp.funder_information_project_name SEPARATOR ", and ") As projectname,
			group_concat(DISTINCT fn.funder_information_project_number SEPARATOR ", and ") As projectnum,
			e.title, e.publisher, e.ispublished, e.`type`, e.id_number,
			group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors
			from eprint e
			left outer join eprint_funder_information_funder ff on ff.eprintid = e.eprintid
			left outer join eprint_funder_information_funder_ref fr on (fr.eprintid = ff.eprintid AND fr.pos = ff.pos)
			left outer join eprint_funder_information_project_name fp on (fp.eprintid = ff.eprintid AND fp.pos = ff.pos)
			left outer join eprint_funder_information_project_number fn on (fn.eprintid = ff.eprintid AND fn.pos = ff.pos)
			JOIN eprint_creators_id i on e.eprintid = i.eprintid
 			JOIN eprint_creators_name n on n.eprintid = i.eprintid AND n.pos = i.pos
			Where (ff.funder_information_funder is not null
				OR fr.funder_information_funder_ref is not null
				OR fp.funder_information_project_name is not null
				OR fn.funder_information_project_number is not null
				)
			AND e.eprint_status = "archive"
			and i.creators_id is not null
			GROUP BY e.eprintid
			ORDER BY e.datestamp_year desc, e.datestamp_month desc, e.datestamp_day desc
		');
		return $query->result_array();
	}
	
	
		public function get_items()
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
	

	public function get_notsetaspublished($months="0")
	{
		// find out the year we want, based on number of months we are going back
		$getyear = date('Y', strtotime("-$months month"));
		// find out the month we want based on the number of months we are going back
		$getmonth = date('m', strtotime("-$months month"));
		// so if 12 and today is 1/sept/2014 the get stuff from BEFORE 2013
		// OR ON or BEFORE 2013 AND ON or BEFORE 9
		$query = $this->db->query('
			select e.eprintid, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS livedate, e.title, e.ispublished, e.type, e.date_year as pubyear, e.date_month as pubmonth, e.publication,
			e.id_number, e.volume, e.number
			from eprint e
			where e.ispublished != "pub"
			and e.eprintid > 10000
			and e.eprint_status = "archive"
			and (e.datestamp_year < ' . $getyear . '
				OR e.datestamp_year <= ' . $getyear . ' AND e.datestamp_month <= ' . $getmonth . ')
			and e.`type` != "thesis"
			order by e.type, e.datestamp_year desc, e.datestamp_month desc, e.datestamp_day desc
		');
		return $query->result_array();
		
		
	}
	
	
	
	
	// get total number of new records per month for one given academic year
	// for a specific school if given.
	public function get_year_new_records($year="",$school="")
	{
		if (empty($year)) {
			$startyear = date("Y",strtotime("-1 year"));
		}
		else {
			$startyear = $year;
		}
		$endyear = $startyear + 1;
		$newitemsarray=array();
		// get deposits for each month
		// some slightly fancy stuff to get the date back in various ways, including three digit month
		// only (jan, feb) as nicemonth and year month, which includes a 0 before single digit months, 
		// ensuring their sort correctly. (which may or may not be important later)
		$this->db->select('Count(*) as "total", e.datestamp_year as year, 
			DATE_FORMAT(concat(e.datestamp_year, "-", e.datestamp_month, "-1 09:00:00"), \'%Y/%m\') as yearmonth,
			DATE_FORMAT(concat(e.datestamp_year, "-", e.datestamp_month, "-1 09:00:00"), \'%b\') as nicemonth', FALSE)
					->from('eprint e')
					->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
					->join('subject_ancestors a' , 'd.divisions = a.subjectid')
					->join('subject_name_name t' , 'a.ancestors = t.subjectid')
					->where('e.eprint_status', "archive")
					->where('a.pos', '1');
		if (!empty($school)) {			
			$this->db->where('t.subjectid', $school);
		}
		$this->db->where("((e.datestamp_year = $endyear and e.datestamp_month < 8 )
						OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))")
					->group_by('yearmonth with rollup');
					
		$query = $this->db->get();
		// using 'with rollup' means the row with the total will have NILL in yearmonth, 
		// so we need to test for this and set this manually to total. ELSE act normally
		foreach ($query->result() as $row) {
			if (empty($row->yearmonth)) {
				$newitemsarray["Total"] = "$row->total";
			}
			else {
				$newitemsarray["$row->nicemonth"] = "$row->total";
			}
		}
		$newitemsarray["name"] = "$startyear/$endyear";
		return $newitemsarray;		
	}

	
	// get number of OA items for each month in an academic year.
	// optionally for a given school.
	public function get_year_monthly_oa($year="",$school="")
	{
		if (empty($year)) {
			$startyear = date("Y",strtotime("-1 year"));
		}
		else {
			$startyear = $year;
		}
		$endyear = $startyear + 1;
		$oaitemsarray=array();
		// get deposits for each month
		// some slightly fancy stuff to get the date back in various ways, including three digit month
		// only (jan, feb) as nicemonth and year month, which includes a 0 before single digit months, 
		// ensuring their sort correctly. (which may or may not be important later)
		$query = $this->db->select('Count(distinct e.eprintid) as "total", e.datestamp_year as year, 
			DATE_FORMAT(concat(e.datestamp_year, "-", e.datestamp_month, "-1 09:00:00"), \'%Y/%m\') as yearmonth,
			DATE_FORMAT(concat(e.datestamp_year, "-", e.datestamp_month, "-1 09:00:00"), \'%b\') as nicemonth', FALSE)
				->from('document f')
				->join('eprint e' , 'e.eprintid = f.eprintid')
				->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
				->join('subject_ancestors a' , 'd.divisions = a.subjectid')
				->join('subject_name_name t' , 'a.ancestors = t.subjectid')
				->where('e.eprint_status', "archive")
				->like('f.format', 'application', 'after')
				->where('(f.security = "public" OR f.date_embargo_year is not null)')
				->where('a.pos', '1');
		if (!empty($school)) {			
			$this->db->where('t.subjectid', $school);
		}
		$this->db->where("((e.datestamp_year = $endyear and e.datestamp_month < 8 )
					OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))")
					->group_by('yearmonth with rollup');
		$query = $this->db->get();
		// that was the SQL, now add each total to an array.			
		foreach ($query->result() as $row) {
			if (empty($row->yearmonth)) {
				$oaitemsarray["Total"] = "$row->total";
			}
			else {
				$oaitemsarray["$row->nicemonth"] = "$row->total";
			}
		}
		$oaitemsarray["name"] = "$startyear/$endyear";
		return $oaitemsarray;		
		
	}
	
	// get list of full text items that will soon have an embargo expire
	public function get_embargoexpire()
	{
		return $this->db->select('e.eprintid, d.formatdesc, d.security, d.license, d.main, concat_ws("/",d.date_embargo_day, d.date_embargo_month, d.date_embargo_year) as embargodate, concat(e.lastmod_day, "/", e.lastmod_month, "/", e.lastmod_year) as "moddate", concat(e.datestamp_day,"/",e.datestamp_month,"/",e.datestamp_year) AS livedate, e.title, e.type, e.date_year as "Yearpublished", e.publication as "journaltitle", e.id_number, e.publisher,
		group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors,
		e.issn, concat_ws("/",e.date_month, e.date_year) as "datepublished"', FALSE)
					->from('document d')
					->join('eprint e' , 'e.eprintid = d.eprintid')
					->join('eprint_creators_id i' , 'e.eprintid = i.eprintid')
					->join('eprint_creators_name n' , 'n.eprintid = i.eprintid AND n.pos = i.pos')
					->where('e.eprint_status', "archive")
					->where('d.date_embargo_year is not null')
					->where('curdate() >', 'concat(d.date_embargo_year, d.date_embargo_month, d.date_embargo_day)', FALSE)
					->group_by('e.eprintid')
					->order_by('d.date_embargo_year, d.date_embargo_month, d.date_embargo_day')
					->get()
                    ->result();
					
	}
	
	// Show items that involved another school, for a given school, i.e. interdisciplinary research
	public function get_interdisciplinary($school="s921")
	{

		$query = $this->db->query('
			Select e.eprintid, group_concat(DISTINCT t.name_name) As "Schools", e.title, e.`type`, e.date_year as datepublished, 
			group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors,
			e.id_number, e.publisher, e.publication as "journaltitle"
			 from eprint e 
			 JOIN eprint_divisions d ON e.eprintid = d.eprintid
			 JOIN subject_name_name s ON d.divisions = s.subjectid
			 JOIN subject_ancestors a ON d.divisions = a.subjectid
			 JOIN subject_name_name t ON a.ancestors = t.subjectid
			 JOIN eprint_creators_id i on e.eprintid = i.eprintid
			 JOIN eprint_creators_name n on n.eprintid = i.eprintid AND n.pos = i.pos

			 where e.eprintid in (
			 
					 SELECT  d.eprintid
					 from eprint_divisions d
					 JOIN subject_name_name s ON d.divisions = s.subjectid
					 JOIN subject_ancestors a ON d.divisions = a.subjectid
					 JOIN subject_name_name t ON a.ancestors = t.subjectid
					 where a.pos = 1
					 and t.subjectid = "' . $school . '"
					 
			 )
			and a.pos = 1
			and t.subjectid != "' . $school . '"
			and e.eprint_status = "archive"
			and i.creators_id is not null
			and e.date_year > 2010
			group by e.eprintid
			order by e.date_year desc');
			return $query->result_array();
	}
	
	// get list schoolnames
	public function get_schoolnames()
	{
		$query = $this->db->select('subjectid as schoolid, name_name as schoolname')
					->from('subject_name_name')
					->where('subjectid like "s%"')
					->where('subjectid != "subjects"' )
					->order_by('name_name');
					$query = $this->db->get();
		// that was the SQL, now add each total to an array.			
		foreach ($query->result() as $row) {
			$schools["$row->schoolid"] = "$row->schoolname";
		}
        return $schools;         
					
	}
	
	// get info on a author
	public function get_authorinfo($author)
	{
		return $this->db->select('u.userid, u.username, u.email, concat(u.name_given, " ", u.name_family) as name,
		u.person_id',FALSE)
					->from('user u')
					->where('u.person_id', $author)
					->limit(1)
					->get()
                    ->result();				
	}
	
}