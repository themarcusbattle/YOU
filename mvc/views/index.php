<? include_once('mvc/views/inc/header.php'); ?>

<div class="row-fluid">
	<a class="btn" href="#new-project" data-toggle="modal"><i class="icon-plus"></i> New Project</a>
</div>
<p>&nbsp;</p>

<table class="table">
<? if ($projects): ?>
	<!--<thead>
		<th>Project</th>
		<th></th>
	</thead>-->
	<tbody>
	<? foreach ($projects as $project): ?>
		<tr>
			<td><h4><?=$project['project_name']?> <br /><small><?=$project['place_name']?></small></h4></td>
			<td style="text-align: right; vertical-align: middle;"><a class="btn" href="projects/view/<?=$project['project_id']?>">View</a></td>
		</tr>
	<? endforeach; ?>
	</tbody>
<? else: ?>
	<tbody>
		<tr>
			<td><a class="btn btn-mini" href="#new-project" data-toggle="modal">New Project</a></td>
		</tr>
	</tbody>
<? endif; ?>
</table>

<div id="new-project" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>New Project</h3>
  </div>
  <form action="api/<?=$this->registry->server[$_SERVER['HTTP_HOST']]['api']?>/projects.json" method="POST">
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
$(document).ready(function() { 
	$('select[name="place_id"]').live('change', function() { 
		if ( $(this).val() == 'new' ) $('#custom-place').show();
		else $('#custom-place').hide();
	});
});
</script>