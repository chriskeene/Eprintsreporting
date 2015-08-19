<?php $monthlist = array("Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"); ?>

<?php
		// load a library for eprintsreporting common functions
		$this->load->library('ergeneral');
		// list of item types
		$itemtypelist = $this->ergeneral->get_itemtypelist();
?>

<h2>Open Access public full text by type:</h2>
<p>Open Access items counted here are those with a full text file available for download (either immediately or after an embargo period).</p>
<table class="style1 stripe table table-striped">
<thead>
	<tr>
		<th>type</th>
		<th>total</th>
		<th> </th>

	</tr>
</thead>
<tbody>
<?php foreach ($oatotals as $oatotal): ?>
	<?php if (empty($oatotal->type)) { $oatotal->type = "total"; } ?>
	<tr>
	<td><?php if (isset($itemtypelist[$oatotal->type])) {
				$type = $itemtypelist[$oatotal->type];
			} else {
				$type = $oatotal->type;
			}
			echo $type; ?></td>
	<td><?php echo number_format($oatotal->total) ?></td>
	<td> [<a href="listoa/type/<?php echo $oatotal->type ?>">show</a>] </td>
	</tr>
	<?php endforeach ?>
</tbody>
</table>
