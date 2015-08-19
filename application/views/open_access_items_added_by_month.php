<?php
		// load a library for eprintsreporting common functions
		$this->load->library('ergeneral');
		// list of academic months
		$monthlist = $this->ergeneral->get_academicmonthlist();
?>



<h2>Open Access items added by month</h2>
<p>Open Access items counted here are those with a full text file available for download (either immediately or after an embargo period).</p>
<table class="style1 stripe table table-striped">
<thead>
	<tr>
		<th> </th>
		<?php foreach ($monthlist as $monthname): ?>
		<th><?php echo $monthname ?></th>
		<?php endforeach ?>
		<th>Total</th>

	</tr>
</thead>
<tbody>
<tr>
<td>Records added <?php echo $thisyearoa["name"] ?></td>
<?php 
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($thisyearoa["$monthname"])) {
					echo $thisyearoa["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo number_format($thisyearoa["Total"]) ?> </td>
</tr>
<tr>
<td>Records added <?php echo $previousyearoa["name"] ?></td>
<?php  
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($previousyearoa["$monthname"])) {
					echo $previousyearoa["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo number_format($previousyearoa["Total"]) ?> </td>
</tr>

<tr>
<td>Records added <?php echo $threeyearsagooa["name"] ?></td>
<?php 
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($threeyearsagooa["$monthname"])) {
					echo $threeyearsagooa["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo number_format($threeyearsagooa["Total"]) ?> </td>
</tr>

</tbody>
</table>
