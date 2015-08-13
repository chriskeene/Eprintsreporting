<p>Open Access items counted here are those with a full text file available for download (either immediately or after an embargo period).</p>
<table class="style1 stripe">
<thead>
	<tr>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		<th>Date live</th>
		<th>Title </th>
		<th>Type</th>
		<th>year published</th>

	</tr>
</thead>
<tbody>
<?php foreach ($oaitems as $oaitem): ?>
	<tr>
	<td><a href="<?php echo $this->config->item('eprints_record_url') . $oaitem->eprintid ?>" target="_blank">
	<?php echo $oaitem->eprintid ?></a></td>
	<td><?php echo $oaitem->datelive ?></td>
	<td><?php echo $oaitem->title ?></td>
	<td><?php echo $oaitem->type ?></td>
	<td><?php echo $oaitem->date_year ?></td>
	
	</tr>
<?php endforeach ?>
</tbody>
</table>
