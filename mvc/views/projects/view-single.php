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

<div id="new-task" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>New Task</h3>
  </div>
  <form action="api/<?=$this->registry->server[$_SERVER['HTTP_HOST']]['api']?>/tasks.json" method="POST">
	  <div class="modal-body">
	    <label>Project Name</label>
	    <input type="text" name="project_name" />
	    <label>Place</label>
	    <select name="place_id">
	    	<option value="">--</option>
	    	<option value="new"><strong>Add New Place</strong></option>
	    	<option value="" disabled="true">--</option>
	    	<? foreach ($places as $place): ?>
	    	<option value="<?=$place['place_id']?>"><?=$place['place_name']?></option>
	    	<? endforeach; ?>
	    </select>
	    <div id="custom-place" style="display: none;">
	    	<label>Enter Place</label>
	    	<input type="text" name="place_name" />
	    </div>
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal">Close</button>
	    <button type="submit" class="btn btn-primary">Create Project</button>
	  </div>
  </form>
</div>

<? include_once('mvc/views/inc/footer.php'); ?>

<script>
</script>