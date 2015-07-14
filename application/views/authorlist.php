<?php $this->load->helper('url'); ?>
<table class="style1 stripe">
<thead>
	<tr>
		<th>Author</th>
		

		<th>Total items</th>
		<th>books</th>


	</tr>
</thead>
<tbody>
<?php foreach ($items as $item): ?>
	<tr>
	<td><?php $url=site_url('eprintsreporting/author/' . urlencode($item->personid)); ?>
	<a href="<?php echo $url; ?>">
	<?php echo $item->author ?></a></td>
	
	<td></td>
	<td><?php echo $item->total ?></td>
	
	
	
	</tr>
<?php endforeach ?>
</tbody>
</table>
