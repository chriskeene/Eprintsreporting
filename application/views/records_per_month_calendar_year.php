<h2>New records per month this calendar year:</h2>
<table class="style1 stripe table table-striped">
<thead>
	<tr>
		<th>month</th>
		<th>total</th>
	

	</tr>
</thead>
<tbody>
<?php foreach ($monthtotals as $total): ?>
	<?php if (empty($total->monthadded)) { $total->monthadded = "total"; } ?>
	<tr>
	<td><?php echo $total->monthadded ?></td>
	<td><?php echo number_format($total->total) ?></td>
	</tr>
	<?php endforeach ?>
</tbody>
</table>
