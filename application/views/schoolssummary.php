<?php $this->load->helper('url'); ?>
<?php
		// load a library for eprintsreporting common functions
		$this->load->library('ergeneral');
		// list of academic months
		$monthlist = $this->ergeneral->get_academicmonthlist();
?>

<table class="style1 stripe">
<thead>
	<tr>
		<th>School</th>
		<th>Total records</th>

		<th>Total Open Access items</th>

	</tr>
</thead>
<tbody>
<?php foreach ($schooltotals as $schooltotal): ?>
	<?php //if (empty($oatotal->type)) { $oatotal->type = "total"; } ?>
	<tr>
	<?php $url=site_url('eprintsreporting/school/' . $schooltotal['schoolid']); ?>
	<td><?php echo '<a href="' . $url . '">' .
	$schooltotal['schoolname'] . '</a>' ?></td>
	<td><?php echo number_format($schooltotal['schooltotalrecords']) ?></td>
	<td><?php echo $schooltotal['schooloatotal'] ?></td>

	</tr>
	<?php endforeach ?>
</tbody>
</table>


<h3>Records added per month</h3>
<table class="style1 stripe">
<thead>
	<tr>
		<th>School</th>
		<?php foreach ($monthlist as $monthname): ?>
		<th><?php echo $monthname ?></th>
		<?php endforeach ?>
		<th>Total records added this year</th>

	</tr>
</thead>
<tbody>
<?php foreach ($schoollist as $school): ?>
	<tr>
	<td><?php echo '<a href="school/' . $school->schoolid . '">' .
	$school->schoolname . '</a> ('. $school->schoolid . ')' ?></td>

	<?php 
    foreach ($monthlist as $monthname): ?>
			<td><?php if (!empty($schoolrecords[$school->schoolid]["$monthname"])) {
					echo $schoolrecords[$school->schoolid]["$monthname"]; 
				} ?>
		</td>	
	<?php endforeach // end of each month for this school. ?>
	
	<td> <?php 	if ($schoolrecords[$school->schoolid]["Total"]) {
					echo number_format($schoolrecords[$school->schoolid]["Total"]);
				} 
		?> 
	</td>
	</tr>
	<?php endforeach // school list each school ?> 
</tbody>
</table>


<h3>Open Access added per month</h3>
<table class="style1 stripe">
<thead>
	<tr>
		<th>School</th>
		<?php foreach ($monthlist as $monthname): ?>
		<th><?php echo $monthname ?></th>
		<?php endforeach ?>
		<th>Total Open Access added</th>

	</tr>
</thead>
<tbody>
<?php foreach ($schoollist as $school): ?>
	<tr>
	<td><?php echo '<a href="school/' . $school->schoolid . '">' .
	$school->schoolname . '</a> ('. $school->schoolid . ')' ?></td>

	<?php 
    foreach ($monthlist as $monthname): ?>
			<td><?php if (!empty($schooloa[$school->schoolid]["$monthname"])) {
					echo $schooloa[$school->schoolid]["$monthname"]; 
				} ?>
		</td>	
	<?php endforeach ?>
	
	<td> <?php echo number_format($schooloa[$school->schoolid]["Total"]) ?> </td>
	


	</tr>
	<?php endforeach ?>
</tbody>
</table>

