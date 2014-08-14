<table class="style1 stripe" border="1">
<thead>
	<tr>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		<th>title</th>
		<th>Sussex authors</th>
		<th>date added</th>
		<th>date published</th>
		<th>funder(s)</th>
		<th>funder code(s)</th>
		<th>project name</th>
		<th>project number</th>
		<th>OA status /licence</th>
		
		
		
		
	</tr>
</thead>
<tbody>

<?php foreach ($items as $sro_item): ?>
	<?php 	if (!empty($sro_item['id_number'])) {
				// if we have a doi, prepare some html to include it after the title
				$doi = '(doi: <a href="http://dx.doi.org/' . $sro_item['id_number'] . '">' . $sro_item['id_number'] . '</a>)';
			}
	?>
	<tr>
		<td><a href="<?php echo $this->config->item('eprints_edit_record_url') . $sro_item['eprintid'] ?>" target="_blank"><?php echo $sro_item['eprintid'] ?></a><br />
		<?php echo $sro_item['type']; ?></td>
		<td><?php echo $sro_item['title'] ?> 
		<?php if (!empty($doi)) { echo $doi; } ?> </td>
		<td><?php echo $sro_item['authors'] ?> </td>
		<td><?php echo $sro_item['livedate'] ?> </td>
		<td><?php echo $sro_item['date_year'] ?> </td>
		<td><?php echo $sro_item['funder'] ?> </td>
		<td><?php echo $sro_item['funderref'] ?> </td>
		<td><?php echo $sro_item['projectname'] ?> </td>
		<td><?php echo $sro_item['projectnum'] ?> </td>
		<td><?php echo $sro_item['oa_status'] ?> <?php echo $sro_item['oa_licence_type'] ?> </td>
		
		
		
		

	</tr>
      

<?php endforeach ?>
</tbody>
</table>
