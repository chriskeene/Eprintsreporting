<?php $this->load->helper('url'); ?>

<div class="feature palette4 swatch6 right half" style="float:right">
<h4 class="palette3 swatch6">Summary</h4>

<?php // $tot = $total[0]; echo "one $tot->eprintid"; ?>
<p><?php echo "Total live records: " . number_format($total[0]->total); ?></p>
<?php //print_r($oatotals); ?>
<p>Open Access public full text:</p>
<ul>
<?php foreach ($oatotals as $oatotal): ?>
	<?php if (empty($oatotal->type)) { $oatotal->type = "total"; } ?>
	<li><?php echo $oatotal->type ?>:  <?php echo number_format($oatotal->total) ?></li>
<?php endforeach ?>
</ul>


<p>New records per month:</p>
<ul>
<?php foreach ($monthtotals as $monthtotal): ?>
	<?php if (empty($monthtotal->monthadded)) { $monthtotal->monthadded = "Total"; } ?>
	<li><?php echo $monthtotal->monthadded ?>:  <?php echo $monthtotal->total ?></li>
<?php endforeach ?>
</ul>


</div>


<h3>Reports</h3>
<ul>
<li><a href="<?php echo site_url('eprintsreporting/summary/'); ?>">Summary</a></li>
<li><a href="<?php echo site_url('eprintsreporting/school/'); ?>">Schools statistics</a></li>
<li><a href="<?php echo site_url('eprintsreporting/recentoa/'); ?>">Recent OA items (open or under embargo)</a></li>
<li>Journals with the most items in SRO 
	[<a href="gettopjournals/1">This year</a>] [<a href="gettopjournals/3">last 3 years</a>] [<a href="gettopjournals/5">last 5 years</a>] [<a href="gettopjournals/10">last 10 years</a>]</li>

<li><a href="<?php echo site_url('eprintsreporting/getrecentoafields/'); ?>">Records with OA metadata</a></li>
<li><a href="<?php echo site_url('eprintsreporting/getrecentfunder/'); ?>">Records with funder metadata</a></li>

</ul>




<p>&nbsp;</p>
<iframe src="http://sro.sussex.ac.uk/cgi/irstats.cgi?page=get_view2&IRS_epchoice=All&divisionss=dummy&subjectss=dummy&creators_names=dummy&eprint=&IRS_datechoice=period&period=-12m&start_day=1&start_month=1&start_year=2005&end_day=31&end_month=1&end_year=2005&view=MonthlyDownloadsGraph" width="530" height="330">

</iframe>
<p>&nbsp;</p>
<a class="twitter-timeline" href="https://twitter.com/search?q=sro.sussex.ac.uk%20OR%20%22sussex%20research%20online%22" data-widget-id="534659132922413056">Tweets about sro.sussex.ac.uk OR "sussex research online"</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>