<? include_once('mvc/views/inc/header.php'); ?>

<div class="row-fluid">
	<a class="btn" href="#new-project" data-toggle="modal"><i class="icon-plus"></i> New Project</a>
</div>

<? if ($projects): ?>

<? else: ?>

<? endif; ?>

<div id="new-project" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>New Project</h3>
  </div>
  <form action="" method="POST">
	  <div class="modal-body">
	    <label>Project Name</label>
	    <input type="text" name="name" />
	    <label>Select Place</label>
	    <select>
	    	<option value="">--</option>
	    	<option value="new"><strong>Add New Place</strong></option>
	    	<? foreach ($places as $place): ?>
	    	<option value="<?=$place['place_id']?>"><?=$place['name']?></select>
	    	<? endforeach; ?>
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