<?php include_once 'header.php';?>
<!-- VIEW BLACKLIST -->
	
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered">
				<div class="box-title">
					<h3>
						<i class="fa fa-file"></i><?php echo ucfirst($title)?> Bulk Update</h3>
				</div>
				<div class="box-content nopadding">

				<?php  

					if($title == 'dnd') {
						$list_type = 'DND';
					} elseif ($title == 'partialdnd') {
						$list_type = 'partialDND';	
					}else{
						$list_type = $title;
					}

				?>

					<form action="<?php echo $host . '/'. $list_type ?>/bulk" method="POST" enctype="multipart/form-data" class='form-horizontal form-striped'>
						
						<div class="form-group">
							<label for="file" class="control-label col-sm-2">File-input</label>
							<div class="col-sm-10">
								<input type="file" name="file" id="file" class="form-control">
								<span class="help-block"> (Max Size: 100MB)</span>
							</div>
						</div>

						<?php if ($title == 'partialdnd'): ?>
							
							<div class="form-group">
							    <label for="textfield" class="control-label col-sm-2">Select Category</label>
							    <div class="col-sm-10">


							        <select name="category" id="select" class='chosen-select form-control'>
							        	<option value='0'>No category</option>
							        	<?php foreach ($categories as $key => $cat): ?>
							        		<option value=<?php echo $cat->getId() ?>><?php echo $cat->getCatName() ?></option>
							        	<?php endforeach ?>
							        </select>
							    </div>
							</div>

						<?php endif ?>

						<div class="form-group">
							<label for="textarea" class="control-label col-sm-2">Comment</label>
							<div class="col-sm-10">
								<textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-actions col-sm-offset-2 col-sm-10">
							<button type="submit" name="addBulkListBtn" class="btn btn-primary">Submit Request</button>
							<button type="reset" class="btn">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
			

<?php include_once 'footer.php'; ?>