<h1><?php echo $title; ?></h1>

<ul class="nav nav-tabs nav-stacked">
<?php 
	foreach ($text as $row) {
		echo "<li><a href='/pages/".$row[0]."'>".$row[1]."</a></li>";
	}
?>
</ul>

<div class="pagination pagination-small">
	<ul>
	<?php for ($i=1; $i<=$num_pages; $i++)
	{
		echo "<li><a href='/".$i."'>".$i."</a></li>";
	}
	?>
	</ul>
 </div>