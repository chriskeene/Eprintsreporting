
<p><?php print_r($schooltotals); //echo "Total live records: " . number_format($total[0]->total);  ?></p>

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
<td>Open Access items</td><td> blah </td>
</tr>


<table class="style1 stripe">
<thead>
	<tr>
		<th>type</th>
		<th>total</th>
		<th>school id </th>
		<th>oa </th>

	</tr>
</thead>
<tbody>
<?php foreach ($schooltotals as $schooltotal): ?>
	<?php //if (empty($oatotal->type)) { $oatotal->type = "total"; } ?>
	<tr>
	<td><?php echo '<a href="/library/sro/sro/school/' . $schooltotal['schoolid'] . '">' .
	$schooltotal['schoolname'] . '</a>' ?></td>
	<td><?php echo number_format($schooltotal['schooltotalrecords']) ?></td>
	<td><?php echo $schooltotal['schoolid'] ?></td>
	<td><?php echo $schooltotal['schooloatotal'] ?></td>

	</tr>
	<?php endforeach ?>
</tbody>
</table>