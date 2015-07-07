<?php echo $this->pagination->create_links(); ?>
<?php
		$this->load->library('ergeneral');
		// list of item types
		$itemtypelist = $this->ergeneral->get_itemtypelist();
?>

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
	<?php $filename = mb_strimwidth($sro_item->main, 0, 30, "..."); // reduce long filenames ?>
	<?php  // use nice item type names.
			if (isset($itemtypelist[$sro_item->type])) {
				$type = $itemtypelist[$sro_item->type];
			} else {
				$type = $sro_item->type;
			} 
	?>
	
	<tr>
		<td>
		<a href="<?php echo $this->config->item('eprints_record_url') . $sro_item->eprintid ?>"><?php echo $sro_item->eprintid ?></a> (<a href="<?php echo $this->config->item('eprints_edit_record_url') . $sro_item->eprintid ?>" target="_blank">edit</a>)<br />
		<?php echo $type; ?></td>
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
		<td><?php echo $filename ?> 
		<br />Security: <?php echo $sro_item->security ?>
		<br /><?php echo $sro_item->license ?>
		</td>
		
		
	
		
		<?php $doi = ""; ?>
		
		

	</tr>
      

<?php endforeach ?>
</tbody>
</table>
<?php echo $this->pagination->create_links(); ?>