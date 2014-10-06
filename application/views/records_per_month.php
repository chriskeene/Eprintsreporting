<?php $monthlist = array("Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"); ?>

<h2>Records added by month</h2>
<table class="style1 stripe">
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
<td>Records added <?php echo $thisyear["name"] ?></td>
<?php //$thisyear = $schooltotals['monthlytotals']; 
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($thisyear["$monthname"])) {
					echo $thisyear["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo number_format($thisyear["Total"]) ?> </td>
</tr>
<tr>
<td>Records added <?php echo $previousyear["name"] ?></td>
<?php //$thisyear = $schooltotals['monthlytotals']; 
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($previousyear["$monthname"])) {
					echo $previousyear["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo number_format($previousyear["Total"]) ?> </td>
</tr>

<tr>
<td>Records added <?php echo $threeyearsago["name"] ?></td>
<?php 
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($threeyearsago["$monthname"])) {
					echo $threeyearsago["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo number_format($threeyearsago["Total"]) ?> </td>
</tr>

</tbody>
</table>

