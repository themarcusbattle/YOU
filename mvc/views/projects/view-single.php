<? include_once('mvc/views/inc/header.php'); ?>

<div class="row-fluid">
	<a class="btn" href="#new-task" data-toggle="modal"><i class="icon-plus"></i> New Task</a>
</div>
<hr />

<h1><?=$project['project_name']?></h1>
<form action="api/<?=$this->registry->server[$_SERVER['HTTP_HOST']]['api']?>/projects.json" method="DELETE">
	<input type="hidden" name="project_id" value="<?=$project['project_id']?>" />
	<button class="btn btn-mini confirm">Archive Project</button>
</form>
<hr />

<? include_once('mvc/views/inc/footer.php'); ?>

<script>
</script>