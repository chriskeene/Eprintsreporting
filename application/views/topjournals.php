<?php $this->load->helper('url'); ?>
<h2>Journals most published in</h2>
<p><?php echo $topjournalstext; ?></p>

<table class="style1 stripe">
<thead>
	<tr>
		<th>Number of articles</th>
		<th>Journal title</th>
		<th>Publisher</th>
		<th><?php echo $this->config->item('org_name'); ?> authors (in no order)</th>

	</tr>
</thead>
<tbody>
<?php foreach ($topjournals as $journal): ?>
	<tr>
	<?php $url=site_url('eprintsreporting/getitemsforjournal/' . urlencode($journal->publication) . '/' . $yearsback); ?>
	<td><a href="<?php echo $url; ?>"><?php echo $journal->total ?></a></td>
	<td><?php echo $journal->publication ?></td>
	<td><?php echo $journal->publisher ?></td>
	<td><?php echo $journal->authors ?></td>
	
	</tr>
<?php endforeach ?>
</tbody>
</table>
