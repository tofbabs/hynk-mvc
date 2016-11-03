<?php include_once 'header.php';?>

       <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">
                <div class="box-title">
                    <h3>
                        <i class="fa fa-bars"></i>
                        <?php echo strtoupper($title)?> Category Download 
                    </h3>
                </div>
                <div class="box-content nopadding">
                    <ul class="timeline">

                        <?php foreach ($categories as $key => $cat): ?>
                        <li>
                            <div class="timeline-content">
                                <div class="left">
                                    <div class="icon orange">
                                        <?php echo $key+1 ?> 
                                    </div>
                                </div>
                                <div class="activity">
                                    <div class="user">

                                        <?php echo strtoupper($cat->getCatName()) ?>

                                        <span><a href="<?php echo $host . '/partialDND/cat/'. $cat->getId() ?> ">
                                            View <i class="fa fa-eye"></i>
                                        </a></span>

                                        <span><a href="<?php echo $host . '/partialDND/download-cat/'. $cat->getId() ?> ">
                                            Download <i class="fa fa-download"></i>
                                        </a></span>

                                        
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="line"></div> -->
                        </li>
                        <?php endforeach?>
                    </ul>

                </div>

            </div>
        </div>
       </div>

<?php include_once 'footer.php'; ?>