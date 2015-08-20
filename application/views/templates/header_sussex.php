
<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml">  
    <head> 
        <title><?php echo $title . " : " . $this->config->item('eprints_name'); ?>  Reporting </title>
        <meta name="focus" content="internal" /> 
      
        <meta charset="UTF-8"/>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="copyright" href="/aboutus/website/disclaimer" title="Copyright and disclaimer" />
        <link rel="schema.dcterms" href="http://purl.org/dc/terms/" />
        <link rel="stylesheet" href="/assets/css/internal.full.css?1398342901" type="text/css" media="screen" />
        <style type="text/css">
		#page {
		width: 1200px;
		}
		</style>
		
		<!--[if IE 7]>
            <link rel="stylesheet" href="/assets/css/sussex.ie7.full.css?1360754122" type="text/css" media="screen" />
        <![endif]-->
        <!--[if lte IE 6]>
            <link rel="stylesheet" href="/assets/css/internal.ie6.full.css?1398342649" type="text/css" media="screen" />
        <![endif]-->
        <link rel="stylesheet" href="/assets/css/print.full.css?1395238225" type="text/css" media="print" />
         
        <link href="/assets/js/jquery/themes/sussex/ui-theme.css" media="screen" rel="stylesheet" type="text/css" />
        
        <script src="/assets/js/internal.full.js?1398350974" type="text/javascript"></script>
        
        <script type="text/javascript" src="/includes/js/jquery-ui.js"></script>    </head> 
    <body class="internal">
                <div id="page">
            <div id="header">
                <a href="/schoolsandservices"><img src="http://www.sussex.ac.uk/includes/images/internal/logo.gif" height="75" width="147" alt="Sussex Internal" /></a> 
                <a id="skip" href="#content" tabindex="1">Skip to content</a>
                <div>
                    <ul>
                        <li class="first"><a href="http://www.sussex.ac.uk/aboutus/website/accessibility">Accessibility</a></li><li><a href="http://www.sussex.ac.uk/az">A-Z</a></li><li><a href="http://www.sussex.ac.uk/profiles">Staff search</a></li><li><a href="http://www.sussex.ac.uk/contactus">Contact us</a></li><li><a href="https://webmail.sussex.ac.uk/">Email</a></li><li class="last"><a href="http://www.sussex.ac.uk">External website</a></li>
                    </ul>
                    <form action="http://www.sussex.ac.uk/search/" method="get"><fieldset>
                        <input id="search_site" type="radio" name="type" value="site" checked="checked" /><label for="search_site">Site</label>
                        <input id="search_people" type="radio" name="type" value="profile" /><label for="search_people">People (by surname)</label>
                        <input id="search_query" type="text" name="t" value="" placeholder="Search for…" aria-label="Search text" /><input id="search_submit" type="submit" value="" title="Search!" />
                        <input id="search_realm" type="hidden" name="realm" value="internal" />
                    </fieldset></form>
                </div>
            </div>
            <div id="topnav"> 
                <ul> 
                    <li class="first"><a href="http://www.sussex.ac.uk/students">Students</a></li><li><a href="http://www.sussex.ac.uk/staff">Staff</a></li><li class="longtab active"><a href="http://www.sussex.ac.uk/schoolsandservices" class="active">Schools &amp; services</a></li><li><a href="https://direct.sussex.ac.uk/">Sussex Direct</a></li><li><a href="https://studydirect.sussex.ac.uk/">Study Direct</a></li><li class="last"><a href="http://splash.sussex.ac.uk/" title="The Sussex social mash-up site ">SPLASH</a></li> 
                </ul> 
            </div> 
            <div id="subnav"> 
                <ul> 
                    <li class="first"><a href="http://www.sussex.ac.uk/schoolsandservices/schools">Schools</a></li><li><a href="http://www.sussex.ac.uk/its">ITS</a></li><li><a href="http://www.sussex.ac.uk/library">Library</a></li><li class="last"><a href="http://www.sussex.ac.uk/schoolsandservices/professionalservices">Professional services</a></li>
					<li class="active"><a href="http://www.sussex.ac.uk/library/reports/sro/sro/" class="active">SRO Reporting</a></li>
					<li class="clear" />
                </ul> 
            </div>
            <div id="breadcrumbs"> 
                <ul> 
                    <li class="first"><a href="/schoolsandservices">Schools and services</a></li><li><a href="/library">Library</a></li><li><a href="/library/reports/sro/eprintsreporting/">SRO Reporting</a></li><li class="last"><a href="/library/"><?php echo $title ?> </a></li> 
                </ul> 
            </div>
            <div id="columns" class="c"> 
				<div id="cccontent">
			
<h1><?php echo $title ?></h1> 
<?php if (isset($introtext)) {
			echo "<p>$introtext</p>";
	}
?>