<?php 

echo '<p>Showing items not set as published added before '. date('F Y', strtotime("-$months month")) ."\n"; 
echo " (" . count($items) . " items)</p>\n"; 
?>

<table class="style1 stripe table table-striped">
<thead>
	<tr>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		
		<th>date added</th>
		<th>date published</th>
		<th>published</th>
		<th>item type</th>
		<th>title</th>
		<th>publication title</th>
		<th>doi</th>
		<th>Vol / issue</th>
	</tr>
</thead>
<tbody>

<?php foreach ($items as $sro_item): ?>
	<tr>
		<td><a href="<?php echo $this->config->item('eprints_edit_record_url') . $sro_item['eprintid'] ?>" target="_blank"><?php echo $sro_item['eprintid'] ?></a></td>
		
		
		<td><?php echo $sro_item['livedate'] ?> </td>
		<td><?php echo $sro_item['pubyear'] ?> / <?php echo $sro_item['pubmonth'] ?> </td>
		<td><?php echo $sro_item['ispublished'] ?> </td>
		<td><?php echo $sro_item['type'] ?> </td>
		<td><?php echo $sro_item['title'] ?> </td>
		<td><?php echo $sro_item['publication'] ?> </td>
		<td><?php echo $sro_item['id_number'] ?> </td>
		<td><?php echo $sro_item['volume'] ?> / <?php echo $sro_item['number'] ?> </td>
		
	</tr>
    
   

<?php endforeach ?>
</tbody>
</table>
