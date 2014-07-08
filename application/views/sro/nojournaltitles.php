<?php //print_r($items); ?>
<table class="style1 stripe">
<thead>
	<tr>
		<th>id</th>
		<th>title</th>
		<th>date added</th>
		<th>date published</th>
		<th>doi</th>
		<th>ISSN</th>
		<th>published</th>
	</tr>
</thead>
<tbody>

<?php foreach ($items as $sro_item): ?>
	<tr>
		<td><a href="<?php echo $this->config->item('eprints_edit_record_url') . $sro_item['eprintid'] ?>" target="_blank">View item</a></td>
		<td><?php echo $sro_item['title'] ?> </td>
		<td><?php echo $sro_item['livedate'] ?> </td>
		<td><?php echo $sro_item['date_year'] ?> </td>
		<td><a href="http://dx.doi.org/<?php echo $sro_item['id_number'] ?>" target="_blank"><?php echo $sro_item['id_number'] ?> </td>
		<td><?php echo $sro_item['issn'] ?> </td>
		<td><?php echo $sro_item['ispublished'] ?> </td>
	</tr>
    
   

<?php endforeach ?>
</tbody>
</table>
<p>end</p>