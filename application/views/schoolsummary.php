<?php $this->load->helper('url'); ?>

<?php
		$this->load->library('ergeneral');
		$monthlist = $this->ergeneral->get_academicmonthlist();
?>

<table class="style1 stripe">
<thead>
	<tr>
		<th><?php echo $schooltotals['schoolname'] ?></th>
		<th>total</th>
		

	</tr>
</thead>
<tbody>
<tr>
<td>Total items</td><td><?php echo $schooltotals['totalrecords'] ?></td>
</tr>
<tr>
<td>Open Access items</td><td> <?php echo $schooltotals['oatotal'] ?> </td>
</tr>
</tbody>
</table>

<ul>
<li>
<?php $url=site_url('eprintsreporting/gettopjournals/5/' . $schooltotals['schoolid']); ?>
<a href="<?php echo $url; ?>">Journals most published in by <?php echo $schooltotals['schoolname'] ?> in last 5 years </a>.</li>

<?php $url=site_url('eprintsreporting/interdisciplinary/' . $schooltotals['schoolid']); ?>
<li><a href="<?php echo $url; ?>">List of interdisciplinary research</a>.</li>

<?php $url=site_url('eprintsreporting/recentoa/' . $schooltotals['schoolid']); ?>
<li><a href="<?php echo $url; ?>">Recent Open Access items (including those under embargo)</a>.</li>

<?php $url=site_url('eprintsreporting/topauthors/5/' . $schooltotals['schoolid']); ?>
<li><a href="<?php echo $url; ?>">Authors with most items on SRO</a>.</li>

</ul>


