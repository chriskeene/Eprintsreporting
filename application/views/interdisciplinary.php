<table class="style1 stripe" border="1">
<thead>
	<tr>
		<th>Other School(s)</th>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		
		<th>Title</th>
		<th>Type</th>
		<th>Year published</th>
		
		<th><?php echo $this->config->item('org_name'); ?> authors</th>
		<th>Publication</th>

		
	
		
		
		
		
	</tr>
</thead>
<tbody>

<?php foreach ($items as $sro_item): ?>
	<?php 	if (!empty($sro_item['id_number'])) {
				// if we have a doi, prepare some html to include it after the title
				$doi = '<br />(doi: <a href="http://dx.doi.org/' . $sro_item['id_number'] . '">' . $sro_item['id_number'] . '</a>)';
			}
	?>
	<tr>
	
		<td><?php echo $sro_item['Schools'] ?> </td>
		
		<td><a href="<?php echo $this->config->item('eprints_record_url') . $sro_item['eprintid'] ?>"><?php echo $sro_item['eprintid'] ?></a><br />
		</td>
		
		<td><?php echo $sro_item['title'] ?>
			<?php if (!empty($doi)) { echo $doi; } ?>
		</td>
		
		<td><?php echo $sro_item['type'] ?> </td>
		
		<td><?php echo $sro_item['datepublished'] ?> </td>
		
		<td><?php echo $sro_item['authors'] ?> </td>
		
		
		<td> 
		<?php echo $sro_item['journaltitle'], ". <br />", $sro_item['publisher'] ?> 
		</td>
		
		
		
		
		
	
		
		<?php $doi = ""; ?>
		
		

	</tr>
      

<?php endforeach ?>
</tbody>
</table>
