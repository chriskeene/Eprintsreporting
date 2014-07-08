<table class="style1 stripe">
<thead>
	<tr>
		<th>id</th>
		
		<th>date added</th>
		<th>date published</th>
		<th>published</th>
		<th>item type</th>
		<th>title</th>
		<th>publication title</th>
		<th>doi</th>
		<th>Vol / issue</th>
	</tr>
</thead>
<tbody>

<!-- select e.eprintid, concat(e.datestamp_year,"/",e.datestamp_month,"/",e.datestamp_day) AS livedate, e.title, e.ispublished, e.type, e.date_year as pubyear, e.date_month as pubmonth, e.publication -->

<?php foreach ($items as $sro_item): ?>
	<tr>
		<td><a href="https://sro.sussex.ac.uk/cgi/users/home?screen=EPrint::View&eprintid=<?php echo $sro_item['eprintid'] ?>">View item</a></td>
		
		<td><?php echo $sro_item['livedate'] ?> </td>
		<td><?php echo $sro_item['pubyear'] ?> / <?php echo $sro_item['pubmonth'] ?> </td>
		<td><?php echo $sro_item['ispublished'] ?> </td>
		<td><?php echo $sro_item['type'] ?> </td>
		<td><?php echo $sro_item['title'] ?> </td>
		<td><?php echo $sro_item['publication'] ?> </td>
		<td><?php echo $sro_item['id_number'] ?> </td>
		<td><?php echo $sro_item['volume'] ?> / <?php echo $sro_item['number'] ?> </td>
		
	</tr>
    
   

<?php endforeach ?>
</tbody>
</table>
<p>end</p>