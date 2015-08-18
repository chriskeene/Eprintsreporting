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
	
	
	///////////////////////////////
	// returns a list of item types, and for each the number of OA records.
	public function get_oatotal_bytype()
	{
		return $this->db->select('count(distinct e.eprintid) as total, e.type')
						->from('document f')
						->join('eprint e', 'e.eprintid = f.eprintid')
						->where('e.eprint_status', "archive")
						->where("(f.format like 'application%'
							OR f.format like 'text/html'
							OR f.format like 'audio%'
							OR f.format like 'video%')")
						->where("(f.date_embargo_year is not null OR f.security = 'public')")
						->group_by('type with rollup')
						->get()
                        ->result();
	}
	
	
	///////////////////////////////////////////
	// returns number of items added for each month in the current calendar year
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
	
	
	
	//////////////////////////////////////////////
	// get a list of recent OA items. requires a field and value to filter by.
	public function get_oalist($field, $value)
	{
		return $this->db->select('e.eprintid, concat(datestamp_year, "/", datestamp_month, "/", datestamp_day) as datelive, e.title, e.type, e.date_year', FALSE)
					->from('document f')
					->join('eprint e' , 'e.eprintid = f.eprintid')
					->where('e.eprint_status', "archive")
					->where("(f.format like 'application%'
						OR f.format like 'text/html'
						OR f.format like 'audio%'
						OR f.format like 'video%')")
					->where("(f.date_embargo_year is not null OR f.security = 'public')")
					->where($field,$value)
					->group_by('f.eprintid')
					->order_by('datelive')
					->get()
                    ->result();
	}
	
	
	// for all schools, return number of records added each month, and number of OA items for each month
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
					->where("(f.format like 'application%'
						OR f.format like 'text/html'
						OR f.format like 'audio%'
						OR f.format like 'video%')")
					->where("(f.date_embargo_year is not null OR f.security = 'public')")
					->where('a.pos', '1')
					->where('t.subjectid !=', 'd328')
					->group_by('t.subjectid')
					->get();
		foreach ($query->result() as $row) {
			$schoolsarray["$row->schoolid"]["schooloatotal"] = "$row->total";
			// now work out percentage of items that are OA.
			$schoolsarray["$row->schoolid"]["schoolpercentageoa"] = ($schoolsarray["$row->schoolid"]["schooloatotal"] / 
				$schoolsarray["$row->schoolid"]["schooltotalrecords"]) * 100;
		}
		
		return $schoolsarray;				
	}
	
	
	///////////////////////////////////////////////
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
					->where("(f.format like 'application%'
						OR f.format like 'text/html'
						OR f.format like 'audio%'
						OR f.format like 'video%')")
					->where("(f.date_embargo_year is not null OR f.security = 'public')")
					->where('a.pos', '1')
					->where('t.subjectid', $school)
					->group_by('t.subjectid')
					->get();
		foreach ($query->result() as $row) {
			$schoolarray["oatotal"] = "$row->total";
		}
		
		return $schoolarray;
	}
	
	
	////////////////////////////
	// return a list of schools, used by Schools summary.
	// note similar function further down.
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
	
	

	////////////////////////////////////////
	//get a list of most popular journals 
	public function get_topjournals($years="4", $school="")
	{
		$startdate = date("Y") - $years;
		$this->db->select('count(distinct e.eprintid) as total, publication, type, e.publisher, group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as "authors"', FALSE)
						->from('eprint e')
						->join('eprint_divisions d', 'e.eprintid = d.eprintid')
						->join('subject_ancestors a', 'd.divisions = a.subjectid')
						->join('subject_name_name t', 'a.ancestors = t.subjectid')
						->join('eprint_creators_id i', 'e.eprintid = i.eprintid')
						->join('eprint_creators_name n', 'n.eprintid = i.eprintid AND n.pos = i.pos')
						->where('e.eprint_status', "archive")
						->where('publication is not null')
						->where('a.pos', '1')
						->where('i.creators_id is not null')
						->where('e.date_year >', $startdate);
						if (!empty($school)) {			
							$this->db->where('t.subjectid', $school);
						}
						$this->db->where('i.creators_id is not null')
						->where('type', 'article')
						->group_by('upper(publication)')
						->order_by('count(distinct e.eprintid) desc')
						->limit('40');

		return $this->db->get()->result();
		//return $this->db->result();
		//return $query;
	
	}
	
	
	//////////////////////////////////////////////////
	// for a given journal and number of years, return all items
	public function get_topjournalitems($journalname,$years,$school)
	{
		$startdate = date("Y") - $years;
		$this->db->select('e.eprintid, e.type, concat_ws("/",e.date_day, e.date_month, e.date_year) as "published", concat(datestamp_day, "/", datestamp_month, "/", datestamp_year) as "livedate", e.title, e.ispublished, e.eprint_status, e.id_number as "DOI",e.issn, e.isbn, e.pagerange, e.pages, e.publication, e.publisher,
		group_concat(DISTINCT t.name_name SEPARATOR ", ")  as "schools",
		group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors',		FALSE)
			->from('eprint e')
			->join('eprint_divisions d', 'e.eprintid = d.eprintid')
			->join('subject_ancestors a', 'd.divisions = a.subjectid')
			->join('subject_name_name t', 'a.ancestors = t.subjectid')
			->join('eprint_creators_id i' , 'e.eprintid = i.eprintid')
			->join('eprint_creators_name n' , 'n.eprintid = i.eprintid AND n.pos = i.pos')
			->where('e.eprint_status', "archive")
			->where('i.creators_id is not null')
			->where('a.pos', '1')
			->where('e.date_year >', $startdate)
			->where('e.publication', $journalname);
			if (!empty($school)) {			
				$this->db->where('t.subjectid', $school);
			}
			$this->db->group_by('e.eprintid')
			->order_by('e.date_year DESC, e.date_month DESC, e.date_day DESC, e.eprintid DESC');

			return $this->db->get()->result();
	}
	
	
	/////////////////////////////////////////////////
	// Returns items which have the OA fields used. (not all OA items)
	public function get_recentoafielditems()
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

	
	////////////////////////////////////////////////
	// Return records with the funder fields used, order by most recent first
	public function get_recentfunderitems()
	{
		$query = $this->db->query('select e.eprintid, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS 	livedate, 
			date_year, e.oa_status, e.oa_embargo_length, e.oa_licence_type, 
			group_concat(DISTINCT ff.funder_information_funder SEPARATOR ", and ") As funder,
			group_concat(DISTINCT fr.funder_information_funder_ref SEPARATOR ", and ") As funderref,
			group_concat(DISTINCT fp.funder_information_project_name SEPARATOR ", and ") As projectname,
			group_concat(DISTINCT fn.funder_information_project_number SEPARATOR ", and ") As projectnum,
			e.title, e.publisher, e.ispublished, e.`type`, e.id_number,
			group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors,
			concat(u.name_given, " ", u.name_family) as depositname,
			f.main as filename,
			f.pos as filenum
			from eprint e
			left outer join eprint_funder_information_funder ff on ff.eprintid = e.eprintid
			left outer join eprint_funder_information_funder_ref fr on (fr.eprintid = ff.eprintid AND fr.pos = ff.pos)
			left outer join eprint_funder_information_project_name fp on (fp.eprintid = ff.eprintid AND fp.pos = ff.pos)
			left outer join eprint_funder_information_project_number fn on (fn.eprintid = ff.eprintid AND fn.pos = ff.pos)
			JOIN eprint_creators_id i on e.eprintid = i.eprintid
 			JOIN eprint_creators_name n on n.eprintid = i.eprintid AND n.pos = i.pos
			join user u on e.userid = u.userid
			left outer join document f on e.eprintid = f.eprintid
			Where (ff.funder_information_funder is not null
				OR fr.funder_information_funder_ref is not null
				OR fp.funder_information_project_name is not null
				OR fn.funder_information_project_number is not null
				)
			AND e.eprint_status = "archive"
			and i.creators_id is not null
			AND (f.format like "application%"
						OR f.format like "text/html"
						OR f.format like "audio%"
						OR f.format like "video%"
						OR f.format is null)
			GROUP BY e.eprintid
			ORDER BY e.datestamp_year desc, e.datestamp_month desc, e.datestamp_day desc
		');
		return $query->result_array();
	}
	
	
	
	/////////////////////////////////////////
	// return items with no journal title set
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
					->from('eprint e');
			if (!empty($school)) {			
					$this->db->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
					->join('subject_ancestors a' , 'd.divisions = a.subjectid')
					->join('subject_name_name t' , 'a.ancestors = t.subjectid')
					->where('t.subjectid', $school)
					->where('a.pos', '1');
			}
			$this->db->where("((e.datestamp_year = $endyear and e.datestamp_month < 8 )
						OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))")
					->where('e.eprint_status', "archive")
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
		// if we have no items, total has not been set, so set it
		if (empty($newitemsarray["Total"])) {
			$newitemsarray["Total"] = 0;
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
				->where("(f.format like 'application%'
						OR f.format like 'text/html'
						OR f.format like 'audio%'
						OR f.format like 'video%')")
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
		// if we have no items, total has not been set, so set it
		if (empty($oaitemsarray["Total"])) {
			$oaitemsarray["Total"] = 0;
		}
		$oaitemsarray["name"] = "$startyear/$endyear";
		return $oaitemsarray;		
		
	}
	
	// get list of full text items that will soon have an embargo expire
	public function get_embargoexpire()
	{
		return $this->db->select('e.eprintid, d.formatdesc, d.security, d.license, d.main, concat_ws("/",d.date_embargo_day, d.date_embargo_month, d.date_embargo_year) as embargodate, concat(e.lastmod_day, "/", e.lastmod_month, "/", e.lastmod_year) as "moddate", concat(e.datestamp_day,"/",e.datestamp_month,"/",e.datestamp_year) AS livedate, e.title, e.type, e.date_year as "Yearpublished", e.publication as "journaltitle", e.id_number, e.publisher,
		group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors,
		e.issn, concat_ws("/",e.date_month, e.date_year) as "datepublished"
		group_concat(DISTINCT t.name_name SEPARATOR ", ")  as "schools"', FALSE)
					->from('document d')
					->join('eprint e' , 'e.eprintid = d.eprintid')
					->join('eprint_creators_id i' , 'e.eprintid = i.eprintid')
					->join('eprint_creators_name n' , 'n.eprintid = i.eprintid AND n.pos = i.pos')
					->join('eprint_divisions dd' , 'e.eprintid = dd.eprintid')
					->join('subject_ancestors a' , 'dd.divisions = a.subjectid')
					->join('subject_name_name t' , 'a.ancestors = t.subjectid')
					->where('e.eprint_status', "archive")
					->where('a.pos', '1')
					->where('i.creators_id is not null')
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
	
	
	// Returns a list of School names and their ids.
	// used by interdisciplinary report, top journals.
	// note similar function further up.
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
	
	
	//////////////////////////////////////////////
	// Return a list of OA items, either open or with embargo, most recent first.
	public function get_recentoa ($school="",$offset="0") 
	{
		// need to put school first as that seems to be how pagination works.
		// but don't always have a school.
		if ($school == "none") {
			$school = "";
		}
		$this->db->select('e.eprintid, d.formatdesc, d.security, d.license, d.main, concat_ws("/",d.date_embargo_day, d.date_embargo_month, d.date_embargo_year) as embargodate, concat(e.lastmod_day, "/", e.lastmod_month, "/", e.lastmod_year) as "moddate", concat(e.datestamp_day,"/",e.datestamp_month,"/",e.datestamp_year) AS livedate, 
		e.title, e.type, e.date_year as "Yearpublished", e.publication as "journaltitle", e.id_number, e.publisher,
		group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors,
		e.issn, concat_ws("/",e.date_month, e.date_year) as "datepublished", 
		group_concat(DISTINCT t.name_name SEPARATOR ", ")  as "schools"', FALSE)
				->from('document d')
				->join('eprint e' , 'e.eprintid = d.eprintid')
				->join('eprint_creators_id i' , 'e.eprintid = i.eprintid')
				->join('eprint_creators_name n' , 'n.eprintid = i.eprintid AND n.pos = i.pos')
				->join('eprint_divisions dd' , 'e.eprintid = dd.eprintid')
				->join('subject_ancestors a' , 'dd.divisions = a.subjectid')
				->join('subject_name_name t' , 'a.ancestors = t.subjectid')
				->where('e.eprint_status', "archive")
				->where('a.pos', '1')
				->where('i.creators_id is not null')
				->where("(d.format like 'application%'
					OR d.format like 'text/html'
					OR d.format like 'audio%'
					OR d.format like 'video%')")
				->where("(d.date_embargo_year is not null OR d.security = 'public')");
				if (!empty($school)) {			
					$this->db->where('t.subjectid', $school);
				}
				$this->db->group_by('e.eprintid')
				->order_by('e.datestamp_year DESC, e.datestamp_month DESC, e.datestamp_day DESC')
				->limit(100, $offset);

			return $this->db->get()->result();
	
	
	}
	
	
	///////////////////////////////////////
	// getauthoritems
	//returns a list of items for an author
	public function get_authoritems ($author) 
	{
		$this->db->select('e.eprintid, e.type, concat_ws("/",e.date_day, e.date_month, e.date_year) as "published", concat(datestamp_day, "/", datestamp_month, "/", datestamp_year) as "livedate", e.title, e.ispublished, e.eprint_status, e.id_number as "DOI",e.issn, e.isbn, e.pagerange, e.pages, e.publication, e.publisher,
		group_concat(DISTINCT t.name_name SEPARATOR ", ")  as "schools",
		group_concat(DISTINCT n.creators_name_given, " ", n.creators_name_family SEPARATOR ", ") as authors
		', FALSE)
				->from('eprint e')
				->join('eprint_creators_id i' , 'e.eprintid = i.eprintid')
				->join('eprint_creators_name n' , 'n.eprintid = i.eprintid AND n.pos = i.pos')
				->join('eprint_divisions dd' , 'e.eprintid = dd.eprintid')
				->join('subject_ancestors a' , 'dd.divisions = a.subjectid')
				->join('subject_name_name t' , 'a.ancestors = t.subjectid')
				->where('e.eprint_status', "archive")
				->where('a.pos', '1')
				->where('i.creators_id',$author)
				->group_by('e.eprintid')
				->order_by('e.datestamp_year DESC, e.datestamp_month DESC, e.datestamp_day DESC');

			return $this->db->get()->result();
	}
	
	
	///////////////////////////////////////
	// get_topauthors
	//returns a list authors, ordered by those with the most items, limited optionally by School, and years
	// note, does not include edited books. would require using eprint_editors_id table
	// also note, due to the way schools are mapped to eprints not people, this will often return many 
	// schools per person. (also why we use a like clause to select if author is connected to school)
	public function get_topauthors ($years="5", $school) 
	{
		$this->db->select('count(distinct i.eprintid) as total, i.creators_id as personid, 
		concat(u.name_given, " ", u.name_family) as author, 
		group_concat(DISTINCT(t.name_name)) as "school", 
		group_concat(distinct(t.subjectid)) as "schoolid"
		', FALSE)
			->from('eprint_creators_id i')
			->join('user u' , 'u.person_id = i.creators_id')
			->join('eprint e' , 'e.eprintid = i.eprintid')
			->join('eprint_divisions dd' , 'e.eprintid = dd.eprintid')
			->join('subject_ancestors a' , 'dd.divisions = a.subjectid')
			->join('subject_name_name t' , 'a.ancestors = t.subjectid')
			->where('i.creators_id is not null')
			->where('i.creators_id != ""')
			->where('creators_id < 900000')
			->where('a.pos', '1')
			->where('e.eprint_status', "archive");
			if (!empty($school)) {			
				$this->db->like('t.subjectid', $school);
			}
			$this->db->group_by('i.creators_id')
			->order_by('count(distinct i.eprintid) desc')
			->limit(200);
		return $this->db->get()->result();
		
	
	}
	
	
	
	///////////////////////////////////////
	// get_totalsbytype
	// returns a list of totals by school and item type.
	public function get_totalsbytype ($year="",$school="")
	{
		if (empty($year)) {
			$startyear = date("Y",strtotime("-1 year"));
		}
		else {
			$startyear = $year;
		}
		$endyear = $startyear + 1;
		
		$this->db->select('t.subjectid, e.type, COUNT(*) AS  "total", t.name_name as "school"', FALSE)
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
					OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))");
			$this->db->group_by('t.subjectid, e.type');
			return $this->db->get()->result();
			
	
	
	}
	
	
	///////////////////////////////////////
	// get_oasummary
	//returns a list of totals, total items for a year, total OA, total articles, total oa artices.
	//
	public function get_oasummary ($year="", $school="") 
	{
		if (empty($year)) {
			// if no year set, presume current year
			$startyear = date("Y",strtotime("-1 year"));
		}
		else {
			$startyear = $year;
		}
		$endyear = $startyear + 1; 
		$returnarray=array();
		// total items for year and school.
		$query = $this->db->select('count(*) as total')
                        ->from('eprint e');
						if (!empty($school)) {			
							$this->db->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
							->join('subject_ancestors a' , 'd.divisions = a.subjectid')
							->join('subject_name_name t' , 'a.ancestors = t.subjectid')
							->where('t.subjectid', $school)
							->where('a.pos', '1');
						}
						$this->db->where('eprint_status', "archive");
						$this->db->where("((e.datestamp_year = $endyear and e.datestamp_month < 8 )
							OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))");
                        $query =  $this->db->get();
		foreach ($query->result() as $row) {
			// add results to multi-dem array. use schoolid as id 
			$returnarray["totalitems"]= "$row->total";

		}	
		// get number of OA items for year and school
		$this->db->select('Count(distinct e.eprintid) as "oatotal"')
                        ->from('eprint e')
						->join('document f', 'e.eprintid = f.eprintid');
						if (!empty($school)) {			
							$this->db->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
							->join('subject_ancestors a' , 'd.divisions = a.subjectid')
							->join('subject_name_name t' , 'a.ancestors = t.subjectid')
							->where('t.subjectid', $school)
							->where('a.pos', '1');
						}
                        $this->db->where('eprint_status', "archive")
						->where("(f.format like 'application%'
							OR f.format like 'text/html'
							OR f.format like 'audio%'
							OR f.format like 'video%')")
						->where("(f.date_embargo_year is not null OR f.security = 'public')");
						$this->db->where("((e.datestamp_year = $endyear and e.datestamp_month < 8 )
							OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))");
                        $query = $this->db->get();
		foreach ($query->result() as $row) {
			// add results to multi-dem array. use schoolid as id 
			$returnarray["totaloaitems"]= "$row->oatotal";
		}	
		// get number of articles for current year and school
		$query = $this->db->select('count(*) as total')
                        ->from('eprint e');
						if (!empty($school)) {			
							$this->db->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
							->join('subject_ancestors a' , 'd.divisions = a.subjectid')
							->join('subject_name_name t' , 'a.ancestors = t.subjectid')
							->where('t.subjectid', $school)
							->where('a.pos', '1');
						}
						$this->db->where('eprint_status', "archive")
						->where('type', 'article');
						$this->db->where("((e.datestamp_year = $endyear and e.datestamp_month < 8 )
							OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))");
                        $query =  $this->db->get();
		foreach ($query->result() as $row) {
			// add results to multi-dem array. use schoolid as id 
			$returnarray["totalarticles"]= "$row->total";

		}	
		// get number of OA articles for current year and school
		$this->db->select('Count(distinct e.eprintid) as "oatotal"')
                        ->from('eprint e')
						->join('document f', 'e.eprintid = f.eprintid');
						if (!empty($school)) {			
							$this->db->join('eprint_divisions d' , 'e.eprintid = d.eprintid')
							->join('subject_ancestors a' , 'd.divisions = a.subjectid')
							->join('subject_name_name t' , 'a.ancestors = t.subjectid')
							->where('t.subjectid', $school)
							->where('a.pos', '1');
						}
                        $this->db->where('eprint_status', "archive")
						->where('e.type', 'article')
						->where("(f.format like 'application%'
							OR f.format like 'text/html'
							OR f.format like 'audio%'
							OR f.format like 'video%')")
						->where("(f.date_embargo_year is not null OR f.security = 'public')");
						$this->db->where("((e.datestamp_year = $endyear and e.datestamp_month < 8 )
							OR (e.datestamp_year = $startyear and e.datestamp_month > 7 ))");
                        $query = $this->db->get();
		foreach ($query->result() as $row) {
			// add results to multi-dem array. use schoolid as id 
			$returnarray["totaloaarticles"]= "$row->oatotal";
		}	
		
		$returnarray["name"] = "$startyear/$endyear"; // set the current year in the array to use as a name
		return $returnarray;
			
	}
	
}