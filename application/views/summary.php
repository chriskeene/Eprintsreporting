<h2>Total records in <?php echo $this->config->item('eprints_name') ?></h2>

<table class="style1 stripe">
<thead>
	<tr>
		<th> </th>
		<th>Total</th>
	

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
	<td>Records added this academic year</td>
	<td><?php echo number_format($thisyear["Total"]); // 
	 ?>
	 </td>
	</tr>
		
		<tr>
	<td>Records added this calendar year</td>
	<td><?php echo number_format(end($monthtotals)->total); // 
	 ?>
	 </td>
	</tr>
	
			<tr>
	<td>OA items added this academic year</td>
	<td><?php echo number_format($thisyearoa["Total"]); // 
	 ?>
	 </td>
	</tr>
	
			<tr>
	<td>Percentage of OA (all time)</td>
	<td><?php echo number_format(end($oatotals)->total / $total[0]->total * 100, 0) . "%"; // do the maths
	 ?>
	 </td>
	</tr>
	
				<tr>
	<td>Percentage of OA this academic year</td>
	<td><?php echo number_format($thisyearoa["Total"] / $thisyear["Total"] * 100, 0) . "%"; // 
	 ?>
	 </td>
	</tr>
		
	</tbody>
	</table>
	


