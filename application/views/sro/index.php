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
<li><a href="summary">Summary</a></li>
<li><a href="getrecentoa">Records with OA metadata</a></li>
<li><a href="getrecentfunder">Records with funder metadata</a></li>
</ul>
<h3>Data issue reports</h3>
<ul>
<li><a href="notsetaspublished">items not set as published</a></li>
<li>articles with no: journal title, ISSN, DOI</li>
<li><a href="nojournaltitles"> articles with no journal title</a></li>
</ul>
<p>end</p>
