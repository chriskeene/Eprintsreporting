<table class="style1 stripe" border="1">
<thead>
	<tr>
		<th>id</th>
		<th>title</th>
		<th>Sussex authors</th>
		<th>date added</th>
		<th>date published</th>
		<th>OA status</th>
		<th>OA embargo length</th>
		<th>OA licence</th>
		<th>publisher</th>
		<th>funder(s)</th>
	</tr>
</thead>
<tbody>

<?php foreach ($items as $sro_item): ?>
	<?php 	if ($sro_item['id_number'] != "") {
				$doi = $sro_item['id_number'];
			}
	?>
	<tr>
		<!-- <td><a href="sro/<?php echo $sro_item['eprintid'] ?>"><?php echo $sro_item['eprintid'] ?></a></td> -->
		<td><a href="https://sro.sussex.ac.uk/cgi/users/home?screen=EPrint::View&eprintid=<?php echo $sro_item['eprintid'] ?>"><?php echo $sro_item['eprintid'] ?></a><br />
		<?php echo $sro_item['type']; ?></td>
		<td><?php echo $sro_item['title'] ?> 
		(doi: <a href="http://dx.doi.org/<?php echo $doi ?>"><?php echo $doi ?></a>)</td>
		<td><?php echo $sro_item['authors'] ?> </td>
		<td><?php echo $sro_item['livedate'] ?> </td>
		<td><?php echo $sro_item['date_year'] ?> </td>
		<td><?php echo $sro_item['oa_status'] ?> </td>
		<td><?php echo $sro_item['oa_embargo_length'] ?> </td>
		<td><?php echo $sro_item['oa_licence_type'] ?> </td>
		<td><?php echo $sro_item['publisher'] ?> </td>
		<td><?php echo $sro_item['funder'] ?> </td>

	</tr>
    
   

<?php endforeach ?>
</tbody>
</table>
<p>end</p>