<?php
		$this->load->library('ergeneral');
		// list of item types
		$itemtypelist = $this->ergeneral->get_itemtypelist();
?>

<table class="style1 stripe table table-striped" border="1">
<thead>
	<tr>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		<th>title</th>
		<th><?php echo $this->config->item('org_name'); ?> authors</th>
		<th>date added</th>
		<th>date published</th>
		<th>funder(s)</th>
		<th>funder code(s)</th>
		<th>project name</th>
		<th>project number</th>
		<th>OA status /licence</th>
		<th>Depositor name</th>
		
		
		
		
		
	</tr>
</thead>
<tbody>

<?php foreach ($items as $sro_item): ?>
	<?php 	if (!empty($sro_item['id_number'])) {
				// if we have a doi, prepare some html to include it after the title
				$doi = '(doi: <a href="http://dx.doi.org/' . $sro_item['id_number'] . '">' . $sro_item['id_number'] . '</a>)';
			}
	?>
	<?php  // use nice item type names.
			if (isset($itemtypelist[$sro_item['type']])) {
				$type = $itemtypelist[$sro_item['type']];
			} else {
				$type = $sro_item['type'];
			} 
	?>
	
	<tr>
		<td><a href="<?php echo $this->config->item('eprints_edit_record_url') . $sro_item['eprintid'] ?>" target="_blank"><?php echo $sro_item['eprintid'] ?></a><br />
		<?php echo $type; ?></td>
		<td><?php echo $sro_item['title'] ?> 
		<?php if (!empty($doi)) { echo $doi; } ?> </td>
		<td><?php echo $sro_item['authors'] ?> </td>
		<td><?php echo $sro_item['livedate'] ?> </td>
		<td><?php echo $sro_item['date_year'] ?> </td>
		<td><?php echo $sro_item['funder'] ?> </td>
		<td><?php echo $sro_item['funderref'] ?> </td>
		<td><?php echo $sro_item['projectname'] ?> </td>
		<td><?php echo $sro_item['projectnum'] ?> </td>
		<td><?php echo $sro_item['oa_status'] ?> <?php echo $sro_item['oa_licence_type'] ?>
		<?php 	if (!empty($sro_item['filenum'])) {
					echo "<br /><a href=\"" . $this->config->item('eprints_record_url') . $sro_item['eprintid'] . "/" . $sro_item['filenum'] . "/" . $sro_item['filename'] . "\" target=\"_blank\">file</a>";
				}
		?>
		</td>
		<td><?php echo $sro_item['depositname'] ?> </td>
		<td> </td>
		
		<?php $doi = ""; ?>
		
		

	</tr>
      

<?php endforeach ?>
</tbody>
</table>
