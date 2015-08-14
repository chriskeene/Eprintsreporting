<?php $this->load->helper('url'); ?>
<?php
		// load a library for eprintsreporting common functions
		$this->load->library('ergeneral');
		// list of item types
		$itemtypelist = $this->ergeneral->get_itemtypelist();
?>
<table class="style1 stripe">
<thead>
	<tr>
		<th>School</th>
		<th>Articles</th>
		<th>Conf. Reports</th>
		<th>Book Chapters</th>
		<th>Books</th>
		<th>Edited Books</th>
		<th>Theses</th>
		<th>Other</th>

	


	</tr>
</thead>
<tbody>
<?php foreach ($schoollist as $school): ?>
	<?php print_r ($school); ?>
	<tr>
	<td>
	<?php echo $school->schoolname . $school->schoolid ?></td>
	<td>
	<?php //echo $items->item . $school->schoolid
	?>
	</td>

	
	
	
	</tr>
	
<?php endforeach // school list each school ?> 
</tbody>
</table>

	<?php print_r($items); ?>
<table class="style1 stripe">
<thead>
	<tr>
		<th>School</th>
		

		<th>Articles</th>
		<th>Conf. Reports</th>
		<th>Book Chapters</th>
		<th>Books</th>
		<th>Edited Books</th>
		<th>Theses</th>
		<th>Other</th>


	</tr>
</thead>
<tbody>
<?php foreach ($items as $item): ?>
	<?php //print_r($item); ?>
	<tr>
	<td>
	<?php echo $item->school . $item->subjectid ?></td>
	<td><?php echo $item->total ?></td>
	<td><?php echo $item->type ?></td>
	
	
	
	</tr>
<?php endforeach ?>
</tbody>
</table>
