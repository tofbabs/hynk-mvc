			<div class="subnav <?php echo ($title == 'dnd' || $title == 'dashboard') ? '' : 'subnav-hidden' ?>">
				<div class="subnav-title">
					<a href="<?php echo $host?>/site/#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Full DND</span>
					</a>
				</div>

				<ul class="subnav-menu">
					<li>
						<a href="<?php echo $host?>/dnd/" data-toggle="dropdown">View All DND</a>
					</li>
                   <!--  <li>
                        <a href="<?php echo $host?>/list/history">Approval History</a>
                    </li> -->
                    <li>
                        <!-- <a href="<?php echo $host?>/list/filter">Filter MSISDN</a> -->
                    </li>
                    <!-- <li>
                        <a href="<?php echo $host?>/list/download-all">Download Entire Full DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/list/download-all">Download Most Recent Full DND</a>
                    </li> -->
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
						<a href="<?php echo $host?>/partialdnd">View All</a>
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
						<a href="<?php echo $host?>/dnc/view">View DNC</a>
					</li>
                   <!--  <li>
                        <a href="<?php echo $host?>/dnc/history">Approval History</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/filter">Filter MSISDN</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/download-all">Download Entire DNC List</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/dnc/download-all">Download Most Recent DNC List</a> -->
                    </li>
				</ul>
			</div>