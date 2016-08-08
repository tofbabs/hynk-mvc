<?php include_once 'header.php';?>
<!-- VIEW BLACKLIST -->
		
	<div class="row">

		<div class="col-sm-12">
		<?php if ($notFound): ?>
			<div class="pull-left">
				<h4 class="pull-left">Search Entire List Again</h4>

				<form action="<?php echo $host ?>/list/search" method="post" class='search-form form-horizontal pull-left'>
					<div class="search-pane">
						<input type="text" name="msisdn" value="<?php echo $msisdn?>">
						<button type="submit" name="searchBtn">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</form>
			</div>
		<?php endif ?>
		</div>

		<div class="col-sm-12">



		<script type="text/javascript">
		    $(document).ready(function () {

		    	_delete = function(cid) {

		    	  if(confirm('Do you wish to delete user')){

		    	    url = options.host + 'user/_delete/' + cid;
		    	    console.log(url);
		    	    $.ajax({
		    	      url: url,
		    	      type: 'post',
		    	      success: function (data) {
		    	          // body...
		    	          console.log('Return Data' + data);
		    	          $('#user-'+cid).remove();
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
					<?php if ($title=='blacklist'): ?>
						<h3><?php echo $blacklist_count . ' '?> Blacklisted MSISDNs</h3>
					<?php elseif ($title=='dnc'): ?>
						<h3><?php echo $dnc_count . ' '?> Do-Not-Charge MSISDNs</h3>
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
					<tr>
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
							<a href="<?php echo $host . "/list/approve/" . $entity->getMsisdn() ?>" class="btn" rel="tooltip" title="Approve">
								<i class="fa fa-check"></i>
							</a>
							<a href="<?php echo $host . "/list/delete/" . $entity->getMsisdn() ?>" class="btn" rel="tooltip" title="Delete">
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