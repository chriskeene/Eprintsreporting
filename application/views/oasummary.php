<h2>OA summary</h2>
<p>Open Access items counted here are those with a full text file available for download (either immediately or after an embargo period).</p>
<table class="style1 stripe table table-striped">
<thead>
	<tr>
		<th> </th>
		<th>Total items</th>
		<th>Total OA</th>
		<th>Percentage OA</th>
		<th> | </th>
		<th>Total articles</th>
		<th>Total OA articles</th>
		<th>Percentage article OA</th>
	

	</tr>
	<tbody>
	<?php foreach (array('thisyearoasummary', 'previousyearoasummary', 'threeyearoasummary') as $currentyear) { 
			$currentdata = ${$currentyear}; ?>
	<tr>
	<td><?php echo $currentdata["name"] ?></td>
	<td><?php echo number_format($currentdata["totalitems"]) ?> </td>
	<td><?php echo number_format($currentdata["totaloaitems"]) ?> </td>
	<td><?php echo number_format($currentdata["totaloaitems"] / $currentdata["totalitems"] * 100) . "%"; ?></td>
	<td> | </td>
	<td><?php echo number_format($currentdata["totalarticles"]) ?> </td>
	<td><?php echo number_format($currentdata["totaloaarticles"]) ?> </td>
	<td><?php echo number_format($currentdata["totaloaarticles"] / $currentdata["totalarticles"] * 100) . "%"; ?></td>
	</tr>
	
	
	
	<?php } // end of foreach ?>
	
	</tbody>
	</table>
	


