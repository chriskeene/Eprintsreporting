
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
	<td><?php echo '<a href="school/' . $schooltotal['schoolid'] . '">' .
	$schooltotal['schoolname'] . '</a>' ?></td>
	<td><?php echo number_format($schooltotal['schooltotalrecords']) ?></td>
	<td><?php echo $schooltotal['schoolid'] ?></td>
	<td><?php echo $schooltotal['schooloatotal'] ?></td>

	</tr>
	<?php endforeach ?>
</tbody>
</table>