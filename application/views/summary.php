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
	<td>Total public Open Access Records</td>
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
	


