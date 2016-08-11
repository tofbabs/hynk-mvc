			<div class="subnav <?php echo ($title == 'dnd' || strtolower($title) == 'dashboard') ? '' : 'subnav-hidden' ?>">
				<div class="subnav-title">
					<a href="<?php echo $host?>/site/#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Full DND</span>
					</a>
				</div>

				<ul class="subnav-menu">
					<li>
						<a href="<?php echo $host?>/dnd/single">Add Single MSISDN</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnd/bulk">Add MSISDN | Bulk Upload</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnd/">View All DND</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnd/approve">Pending DND</a>
					</li>
                    <li>
                        <a href="<?php echo $host?>/dnd/history">Approved DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnd/filter">Filter MSISDN</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnd/download-all">Download Full DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnd/download-recent">Download Recent DND</a>
                    </li>
				</ul>
			</div>

			<div class="subnav <?php echo ($title == 'partialdnd') ? '' : 'subnav-hidden' ?>">
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
					<li>
						<a href="<?php echo $host?>/partialdnd">View All</a>
					</li>
					<li>
						<a href="<?php echo $host?>/partialdnd/approve">View Pending DND</a>
					</li>
					<li>
						<a href="<?php echo $host?>/partialdnd/download">Download Partial</a>
					</li>
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
                        <a href="<?php echo $host?>/dnc/history">Approved DNC</a>
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
			