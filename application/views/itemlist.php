
<table class="style1 stripe">
<thead>
	<tr>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		
		<th>Title </th>
		<th>published</th>
		<th>journal title / book</th>
		<th>Identifiers</th>
		<th>Type</th>
		
		<th>Date live</th>

	</tr>
</thead>
<tbody>
<?php foreach ($items as $item): ?>
	<tr>
	<td><a href="<?php echo $this->config->item('eprints_record_url') . $item->eprintid ?>" target="_blank">
	<?php echo $item->eprintid ?></a></td>
	
	<td><?php echo $item->title ?></td>
	<td><?php echo $item->published ?></td>
	<td><?php echo $item->publication ?><br />
		<?php echo $item->publisher ?></td>
	<td><?php echo $item->DOI ?><br />
		<?php echo $item->issn; echo $item->isbn;  ?></td>
	<td><?php echo $item->type ?></td>
	<td><?php echo $item->livedate ?></td>
	
	
	</tr>
<?php endforeach ?>
</tbody>
</table>
