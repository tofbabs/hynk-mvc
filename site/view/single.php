<?php include_once 'header.php'; global $host;?>
<!-- VIEW BLACKLIST -->
	
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-bordered">
				<div class="box-title">
					<h3>
						<i class="fa fa-th-list"></i><?php echo ucfirst($title)?> MSISDN</h3>
				</div>
				<?php  

					if($title == 'dnd') {
						$list_type = 'DND';
					} elseif ($title == 'partialdnd') {
						$list_type = 'partialDND';	
					}else{
						$list_type = $title;
					}

				?>
				<div class="box-content nopadding">
					<form action="<?php echo $host . '/'.$list_type.'/single' ?>" method="POST" class='form-horizontal form-striped'>
						
						
						<div class="form-group">
							<label for="textfield" class="control-label col-sm-2">MSISDN(s)<small>Separate Multiple by comma</small></label>	
							<div class="col-sm-10">
								<input type="text" name="msisdn" id="msisdn" placeholder="23480.." class="form-control" required>
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
								<textarea id="comment" name="comment" rows="5" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-actions col-sm-offset-2 col-sm-10">
							<button type="submit" name="addSingleBtn" class="btn btn-primary">Submit</button>
							<button type="reset" class="btn">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
			

<?php include_once 'footer.php'; ?>