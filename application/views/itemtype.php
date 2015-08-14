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
		<th>Project/<br />working paper</th>

	</tr>
</thead>
<tbody>
<?php foreach ($schools as $school): ?>
	<?php 
		if (!isset($school['schoolname'])) {
			continue;
		}
	?>
	<tr>
	<td>
	<?php echo $school['schoolname']  ?></td>
	<td><?php if (isset($school['article'])) { echo $school['article']; }?></td>
	<td><?php if (isset($school['conference_item'])) { echo $school['conference_item']; } else { echo "0"; }?></td>
	<td><?php if (isset($school['book_section'])) { echo $school['book_section']; } else { echo "0"; }?></td>
	<td><?php if (isset($school['book'])) { echo $school['book']; } else { echo "0"; }?></td>
	<td><?php if (isset($school['edited_book'])) { echo $school['edited_book']; } else { echo "0"; }?></td>
	<td><?php if (isset($school['thesis'])) { echo $school['thesis']; } else { echo "0"; }?></td>
	<td><?php if (isset($school['monograph'])) { echo $school['monograph']; } else { echo "0"; }?></td>
	
	</tr>
	
<?php endforeach // school list each school ?> 
</tbody>
</table>

