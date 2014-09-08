<?php //print_r($thisyear); // $tot = $total[0]; echo "one $tot->eprintid"; ?>
<?php $monthlist = array("Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"); ?>
<h2>Total records in SRO</h2>

<table class="style1 stripe">
<thead>
	<tr>
		<th> </th>
		<th>total</th>
	

	</tr>
	<tbody>
	<tr>
	<td>Total live records</td>
	<td><?php echo number_format($total[0]->total); ?></td>
	</tr>
	
	<tr>
	<td>Total OA Records</td>
	<td><?php echo number_format(end($oatotals)->total); // total comes as last array elment
	 ?>
	 </td>
	</tr>	
		
		<tr>
	<td>Records added this calendar year</td>
	<td><?php echo number_format(end($monthtotals)->total); // total comes as last array elment
	 ?>
	 </td>
	</tr>
	
		<tr>
	<td>Records added this academic year</td>
	<td><?php echo number_format($thisyear["Total"]); // total comes as last array elment
	 ?>
	 </td>
	</tr>
	

	
	</tbody>
	</table>
	





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
<td>records added <?php echo $thisyear["name"] ?></td>
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
<td>records added <?php echo $previousyear["name"] ?></td>
<?php //$thisyear = $schooltotals['monthlytotals']; 
    foreach ($monthlist as $monthname): ?>
		<td><?php if (!empty($previousyear["$monthname"])) {
					echo $previousyear["$monthname"]; 
				} ?>
		</td>
	<?php endforeach ?>
	<td> <?php echo number_format($previousyear["Total"]) ?> </td>
</tr>


</tbody>
</table>



<h2>Open Access public full text by type:</h2>
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

<h2>New records per month this calendar year:</h2>
<table class="style1 stripe">
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
