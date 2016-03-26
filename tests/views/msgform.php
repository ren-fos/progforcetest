<h1>Обратная связь</h1>
<?php if(isset($err_mes)) { ?>
<div class="alert alert-error">
<?php echo $err_mes; ?>
</div>
<?php }?>
<form class=".form-horizontal" name="mes" method="post" action="/send">
	<div class="control-group">
		<label class="control-label">Тема письма*</label>
		<input name="title" type="text">
	</div>
	<div class="control-group">
		<label class="control-label">От кого*</label>
		<input name="author" type="text">
	</div>	
	<div class="control-group">	
		<label class="control-label">Текст письма*</label>
		<textarea name="text"></textarea>
	</div>
	<div class="controls">
		<input class="btn btn-success" label="Отправить" name="" type="submit">
	</div>
</form>