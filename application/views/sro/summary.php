<?php // $tot = $total[0]; echo "one $tot->eprintid"; ?>
<h2>Total records in SRO</h2>
<p><?php echo "Total live records: " . number_format($total[0]->total); ?></p>

<?php //print_r($oatotals); ?>
<h2>Open Access public full text:</h2>
<table class="style1 stripe">
<thead>
	<tr>
		<th>type</th>
		<th>total</th>
		<th> </th>

	</tr>
</thead>
<tbody>
<?php foreach ($oatotals as $oatotal): ?>
	<?php if (empty($oatotal->type)) { $oatotal->type = "total"; } ?>
	<tr>
	<td><?php echo $oatotal->type ?></td>
	<td><?php echo number_format($oatotal->total) ?></td>
	<td> [<a href="listoa/type/<?php echo $oatotal->type ?>">show</a>] </td>
	</tr>
	<?php endforeach ?>
</tbody>
</table>

<p>New records per month:</p>
<ul>
<?php foreach ($monthtotals as $monthtotal): ?>
	<?php if (empty($monthtotal->monthadded)) { $monthtotal->monthadded = "Total"; } ?>
	<li><?php echo $monthtotal->monthadded ?>:  <?php echo $monthtotal->total ?></li>
<?php endforeach ?>
</ul>




