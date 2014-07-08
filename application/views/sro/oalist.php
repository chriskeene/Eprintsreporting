<?php //print_r($oaitems); ?>
<table class="style1 stripe">
<thead>
	<tr>
		<th>SRO id</th>
		<th>Date live</th>
		<th>Title </th>
		<th>Type</th>
		<th>year published</th>

	</tr>
</thead>
<tbody>
<?php foreach ($oaitems as $oaitem): ?>
	<tr>
	<td><?php echo $oaitem->eprintid ?></td>
	<td><?php echo $oaitem->datelive ?></td>
	<td><?php echo $oaitem->title ?></td>
	<td><?php echo $oaitem->type ?></td>
	<td><?php echo $oaitem->date_year ?></td>
	
	</tr>
<?php endforeach ?>
</tbody>
</table>




e.eprintid, concat(datestamp_year, " / ", datestamp_month, " / ", datestamp_day) as datelive, e.title, e.type  