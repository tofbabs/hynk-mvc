			<div class="subnav <?php echo ($title == 'dnd' || $title == 'dashboard') ? '' : 'subnav-hidden' ?>">
				<div class="subnav-title">
					<a href="<?php echo $host?>/site/#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Full DND</span>
					</a>
				</div>

				<ul class="subnav-menu">
					<!-- <li>
						<a href="<?php echo $host?>/DND/single">Add MSISDN | Single</a>
					</li>
					<li>
						<a href="<?php echo $host?>/DND/bulk">Add MSISDN | Bulk Upload</a>
					</li> -->
					<li>
						<a href="<?php echo $host?>/DND/">View All DND</a>
					</li>
                    <li>
                        <a href="<?php echo $host?>/DND/history">Approved DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/DND/filter">DND Filter MSISDN</a>
                    </li>
										<li>
												<a href="<?php echo $host?>/DND/whitelist">Whitelist MSISDN</a>
										</li>
                    <li>
                        <a href="<?php echo $host?>/DND/download-all">Download Entire Full DND</a>
                    </li>
                    <li>
                        <a href="<?php echo $host?>/DND/download-all">Download Most Recent Full DND</a>
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
						<a href="<?php echo $host?>/partialDND/">View All</a>
					</li>
					<li>
						<a href="<?php echo $host?>/partialDND/download">Download Partial</a>
					</li>
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
					<!-- <li>
						<a href="<?php echo $host?>/dnc/single">Add Single MSISDN</a>
					</li>
					<li>
						<a href="<?php echo $host?>/dnc/bulk">Add MSISDN | Bulk Upload</a>
					</li> -->
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
