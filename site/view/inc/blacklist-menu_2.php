			<div class="subnav <?php echo ($title == 'blacklist' || $title == 'Dashboard') ? '' : 'subnav-hidden' ?>">
				<div class="subnav-title">
					<a href="<?php echo $host?>/site/#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Full DND</span>
					</a>
				</div>

				<ul class="subnav-menu">
					<li>
						<a href="<?php echo $host?>/dnd/single">Add MSISDN | Single</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnd/bulk">Add MSISDN | Bulk Upload</a>
					</li>l>
					</li>
					<li>
						<a href="<?php echo $host?>/dnd/">View All DND</a>
					</li>
                    <li>
                        <a href="<?php echo $host?>/dnd/history">Approved DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnd/filter">DND Filter MSISDN</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnd/download-all">Download Entire Full DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnd/download-all">Download Most Recent Full DND</a>
                    </li>
				</ul>
			</div>

			<div class="subnav <?php echo ($title == 'blacklist' || $title == 'dashboard') ? '' : 'subnav-hidden' ?>">
				<div class="subnav-title">
					<a href="<?php echo $host?>/site/#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Partial DND</span>
					</a>
				</div>

				<ul class="subnav-menu">

					<li>
						<a href="<?php echo $host?>/partialdnd/single">Add Single MSISDN</a>
					</li>
					<li>
						<a href="<?php echo $host?>/partialdnd/bulk">Add MSISDN | Bulk Upload</a>
					</li>

					<?php foreach ($categories as $key => $cat): ?>
						<li>
							<a href="<?php echo $host . '/dnd/cat/'. $cat->getId() ?> ">
								<?php echo $cat->getCatName() ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>


			<div class="subnav <?php echo ($title == 'dnc') ? '' : 'subnav-hidden' ?>">
				<div class="subnav-title">
					<a href="<?php echo $host?>/site/#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>DoNotCharge List</span>
					</a>
				</div>

				<ul class="subnav-menu">
					<li>
						<a href="<?php echo $host?>/dnc/single">Add Single MSISDN</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnc/bulk">Add MSISDN | Bulk Upload</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnc/view">View DNC</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnc/approve">Pending DNC</a>
					</li>
                    <li>
                        <a href="<?php echo $host?>/dnc/history">Approved DNC</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/filter">Filter MSISDN</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/download-all">Download Entire DNC List</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/download-all">Download Most Recent DNC List</a>
                    </li>
				</ul>
			</div>