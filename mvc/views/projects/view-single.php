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


<table class="table">
<? if ($tasks): ?>
	<!--<thead>
		<th>Project</th>
		<th></th>
	</thead>-->
	<tbody>
	<? foreach ($tasks as $task): ?>
		<tr>
			<td><input type="checkbox" /></td>
			<td>
				<a class="task" 
					href="#view-task" 
					data-toggle="modal" 
					data-task_id="<?=$task['task_id']?>"
					data-milestone="<?=$task['is_milestone']?>"
					>
					<?=$task['task']?>
				</a>
			</td>
		</tr>
	<? endforeach; ?>
	</tbody>
<? else: ?>
	<tbody>
		<tr>
			<td><a class="btn btn-mini" href="#new-task" data-toggle="modal">New Task</a></td>
		</tr>
	</tbody>
<? endif; ?>
</table>

<!-- NEW TASK MODAL -->
<div id="new-task" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>New Task</h3>
  </div>
  <form action="api/<?=$this->registry->server[$_SERVER['HTTP_HOST']]['api']?>/tasks.json" method="POST">
	  <div class="modal-body">
	  	<input type="hidden" name="project_id" value="<?=$project['project_id']?>" />
	  	
	    <textarea name="task" placeholder="Enter task"></textarea>
	    <label>Is Milestone</label>
	    <select name="is_milestone">
	    	<option value="">--</option>
	    	<option value="1">Yes</option>
	    	<option value="0">No</option>
	    </select>
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal">Close</button>
	    <button type="submit" class="btn btn-primary">Create Project</button>
	  </div>
  </form>
</div>

<!-- VIEW/EDIT TASK MODAL -->
<div id="view-task" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>Task</h3>
  </div>
  <form action="api/<?=$this->registry->server[$_SERVER['HTTP_HOST']]['api']?>/tasks.json" method="PUT">
	  <div class="modal-body">
	  	<input type="hidden" name="project_id" value="<?=$project['project_id']?>" />
	  	
	    <textarea name="task" placeholder="Enter task"></textarea>
	    <label>Is Milestone</label>
	    <select name="is_milestone">
	    	<option value="">--</option>
	    	<option value="1">Yes</option>
	    	<option value="0">No</option>
	    </select>
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