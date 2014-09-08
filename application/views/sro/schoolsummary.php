
<p><?php //print_r($schooltotals);  ?></p>

<?php $monthlist = array("Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"); ?>

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
<td>records added 13/14</td>
<?php $monthtotals = $schooltotals['monthlytotals']; 
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($monthtotals["$monthname"])) {
					echo $monthtotals["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo $monthtotals["Total"] ?> </td>
	</tr>
	</tbody>
</table>

<p>todo top journals, top publishers, departments, oa by month, by type.