<table class="style1 stripe" border="1">
<thead>
	<tr>
		<th><?php echo $this->config->item('eprints_name') ?> id</th>
		
		<th>title</th>
		<th>journal / publisher</th>
		<th>Sussex authors</th>
		
		<th>date added</th>
		<th>date published</th>
		<th>Embargo expiry</th>
		<th>Fulltext file</th>
		
	
		
		
		
		
	</tr>
</thead>
<tbody>

<?php foreach ($items as $sro_item): ?>
	<?php 	if (!empty($sro_item->id_number)) {
				// if we have a doi, prepare some html to include it after the title
				$doi = '(doi: <a href="http://dx.doi.org/' . $sro_item->id_number . '">' . $sro_item->id_number . '</a>)';
			}
	?>
	<tr>
		<td><a href="<?php echo $this->config->item('eprints_edit_record_url') . $sro_item->eprintid ?>" target="_blank"><?php echo $sro_item->eprintid ?></a><br />
		<?php echo $sro_item->type; ?></td>
		<td><?php echo $sro_item->title ?> 
		
		<?php if (!empty($doi)) { echo $doi; } ?> </td>
		<td><?php echo $sro_item->publisher, ". <br />", $sro_item->journaltitle ?> 
		<?php if (!empty($sro_item->issn)) {
			echo "<a href='http://www.sherpa.ac.uk/romeo/search.php?issn=" . $sro_item->issn . "'>Romeo</a>";
		}
		?>
		
		</td>
		<td><?php echo $sro_item->authors ?> </td>
		<td><?php echo $sro_item->livedate ?> </td>
		<td><?php echo $sro_item->datepublished ?> </td>
		<td><?php echo $sro_item->embargodate ?> </td>
		<td><?php echo $sro_item->main ?> 
		<br />Security: <?php echo $sro_item->security ?>
		<br /><?php echo $sro_item->license ?>
		</td>
		
		
	
		
		<?php $doi = ""; ?>
		
		

	</tr>
      

<?php endforeach ?>
</tbody>
</table>
