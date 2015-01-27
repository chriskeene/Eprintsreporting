
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
</tbody>
</table>

<p><a href="../interdisciplinary/<?php echo $schooltotals['schoolid']; ?>">List of interdisciplinary research</a>.</p>




