<?php include_once 'header.php';?>
<!-- VIEW BLACKLIST -->
		
	<div class="row">

		<p class="col-sm-12">
		<?php if ($isSingle && $notFound): ?>
			<div class="text-center col-sm-4">
				<form action="<?php echo $host . $title ?>/search" method="post" class='search-form form-horizontal'>
					<div class="search-panel">
						<label>Search Again</label>
						<input type="text" name="msisdn" value="<?php echo $msisdn?>">
						<button type="submit" name="searchBtn">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</form>
			</div>
		<?php endif ?>
		</p>

		<div class="col-sm-12">

		<script type="text/javascript">
		    $(document).ready(function () {

		    	_delete = function(msisdn) {

		    	  if(confirm('Do you wish to remove MSISDN from <?php echo $title ?>')){

		    	    url = options.host + '<?php echo $title ?>/delete/' + msisdn;
		    	    console.log(url);
		    	    $.ajax({
		    	      url: url,
		    	      type: 'post',
		    	      success: function (data) {
		    	          // body...
		    	          console.log('Return Data' + data);
		    	          $('#list-'+ msisdn).remove();
		    	          // window.location.replace(options.host + '/user');
		    	      }
		    	    });
		    	  }
		    	}

		    	// $('table').dataTable({bFilter: false, bInfo: false});

		        // $('#users').DataTable({
		        //     "columns": [
		        //         {"data": "id"},
		        //         {"data": "msisdn"},
		        //         {"data": "comment"},
		        //         {"data": "update_time"},
		        //         {"data": "upload_set"},
		        //         {"data": "category"},
		        //         {"data": "accumulator_id"},
		        //         {"data": "status"},
		        //         {"data": "list_type"}
		        //     ],
		        //     "processing": true,
		        //     "serverSide": true,
		        //     "ajax": {
		        //         url: 'localhost/blacklist/list/__processDatabales',
		        //         type: 'POST',
		        //         success: function(data) {alert(data)}
		        //     }
		        // });
		    });
		</script>

			<div class="box box-color box-bordered">
				<div class="box-title">
				<?php if (!$isSingle) : ?>
					<?php if ($title === 'dnd'): ?>
						<h3><?php echo $blacklist_count . ' '?> DND MSISDNs</h3>
					<?php elseif ($title === 'dnc'): ?>
						<h3><?php echo $dnc_count . ' '?> Do-Not-Charge MSISDNs</h3>
					<?php elseif ($title === 'partialdnd'): ?>
						<h3>Partial DND MSISDNs</h3>
					<?php endif ?>
				<?php else: ?>
					<h3><?php echo 'Search Result: ' . $msisdn ?></h3>
				<?php endif ?>
				</div>
				<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-bordered dataTable " data-column_filter_types="null,select,text,select,daterange,null" data-column_filter_dateformat="dd-mm-yy"  >
					<thead>
					<tr>
						<th class='with-checkbox'>
							<input type="checkbox" name="check_all" class="dataTable-checkall">
						</th>
						<th>Accumulator</th>
						<th>MSISDN</th>
						<th class='hidden-350'>Status</th>
						<th class='hidden-1024'>Date Added</th>
						<th>Comments</th>
						<?php if($_SESSION['company']->getPrivilege() == 1): ?>
						<th class='hidden-240'>Options</th>
						<?php endif ?>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($blacklist as $entity) : ?>
					<tr id="list-<?php echo $entity->getMsisdn() ?>">
						<td class="with-checkbox">
							<input type="checkbox" name="check" value="1">
						</td>
						<td><?php echo $entity->getAccumulator() ?></td>
						<td><?php echo $entity->getMsisdn() ?></td>

						<td class='hidden-350'>
							<?php echo ($entity->getStatus() == 0) ? 'pending' : 'published' ?>
						</td>
						
						<td class='hidden-1024'><?php $old = strtotime($entity->getUpdateTime()); echo date('d-m-Y', $old ) ?></td>
						<td><?php echo $entity->getComment() ?></td>
						<?php if($_SESSION['company']->getPrivilege() == 1): ?>
						<td class='hidden-480'>
							<a href="<?php echo $host . $title . '/approve/' . $entity->getMsisdn() ?>" class="btn" rel="tooltip" title="Approve">
								<i class="fa fa-check"></i>
							</a>
							<a href="<?php echo $host . $title . '/delete/' . $entity->getMsisdn() ?>" class="btn" rel="tooltip" title="Delete">
								<i class="fa fa-times"></i>
							</a>
						</td>
						<?php endif ;?>
					</tr>
				<?php endforeach ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>


			

<?php include_once 'footer.php'; ?>