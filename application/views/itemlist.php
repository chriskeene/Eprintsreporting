<?php
		$this->load->library('ergeneral');
		// list of item types
		$itemtypelist = $this->ergeneral->get_itemtypelist();
?>
<table class="style1 stripe">
<thead>
	<tr>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		
		<th>Title </th>
		<th>Sussex authors</th>
		<th>published</th>
		<th>journal title / book</th>
		<th>Identifiers</th>
		<th>Type</th>
		
		<th>Date live</th>
		<th>School(s)</th>

	</tr>
</thead>
<tbody>
<?php foreach ($items as $item): ?>
	<tr>
	<td><a href="<?php echo $this->config->item('eprints_record_url') . $item->eprintid ?>" target="_blank">
	<?php echo $item->eprintid ?></a></td>
	
	<td><?php echo $item->title ?></td>
	<td><?php echo $item->authors ?></td>
	<td><?php echo $item->published ?></td>
	<td><?php echo $item->publication ?><br />
		<?php echo $item->publisher ?></td>
	<td><?php echo $item->DOI ?><br />
		<?php echo $item->issn; echo $item->isbn;  ?></td>
	<td><?php  // use nice item type names.
			if (isset($itemtypelist[$item->type])) {
				$type = $itemtypelist[$item->type];
			} else {
				$type = $item->type;
			} 
			echo $type;
	?>
	</td>
	<td><?php echo $item->livedate ?></td>
	<td><?php echo $item->schools ?> </td>
	
	
	</tr>
<?php endforeach ?>
</tbody>
</table>
