			<div class="subnav <?php echo ($title == 'blacklist' || strtolower($title) == 'dashboard') ? '' : 'subnav-hidden' ?>">
				<div class="subnav-title">
					<a href="<?php echo $host?>/site/#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Full DND</span>
					</a>
				</div>

				<ul class="subnav-menu">
					<li>
						<a href="<?php echo $host?>/list/single">Add Single MSISDN</a>
					</li>
					<li>
						<a href="<?php echo $host?>/list/bulk">Add MSISDN | Bulk Upload</a>
					</li>
					<li>
						<a href="<?php echo $host?>/list/" data-toggle="dropdown">View All BlackList</a>
					</li>
					<li>
						<a href="<?php echo $host?>/list/approve">Pending</a>
					</li>
                    <li>
                        <a href="<?php echo $host?>/list/history">Approved</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/list/filter">Filter MSISDN</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/list/download-all">Download Full DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/list/download-recent">Download Recent DND</a>
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
					<?php foreach ($categories as $key => $cat): ?>
						<li>
							<a href="<?php echo $host . '/list/cat/'. $cat->getId() ?> ">
								<?php echo $cat->getCatName() ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>


			<div class="subnav <?php echo (strtolower($title) == 'dnc') ? '' : 'subnav-hidden' ?>">
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
						<a href="<?php echo $host?>/dnc/view">View All DNC</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnc/approve">Pending DNC</a>
					</li>
                    <li>
                        <a href="<?php echo $host?>/dnc/history">Approval History</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/filter">Filter MSISDN</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/download-all">Download All DNC</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/download-recent">Download Recent DNC</a>
                    </li>
				</ul>
			</div>

			