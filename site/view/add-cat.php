<?php include_once 'header.php'; ?>
<!-- VIEW BLACKLIST -->

<div class="row">
    <div class="col-sm-6">
        <div class="box no-border box-color">
            <div class="box-title">
                <h3><i class="fa fa-files-o"></i><?php echo $isEdit ? 'Edit' : 'Add' ?> Category</h3>
            </div>
            <div class="box-content nopadding pre-scrollable">

                <form action="<?php echo $isEdit ? $host.'/category/add/'. $cat->getId() : $host.'/category/add/' ?>" method="POST" class='form-horizontal form-striped'>

                    <?php if ($isEdit): ?>
                        <input type="hidden" name="category_id" value="<?php echo $cat->getId() ?>">
                    <?php endif ?>

                    <div class="form-group">
                        <label for="textfield" class="control-label col-sm-2">Category Name</label>	
                        <div class="col-sm-10">
                            <input type="text" name="category_name" placeholder="Category Name" class="form-control" value="<?php echo $isEdit ? $cat->getCatName() : '' ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                    <label for="textfield" class="control-label col-sm-2">Category Description</label>
                        <div class="col-sm-10">
                            <textarea name="category_description" id="cat_desc" rows="3" class="form-control"><?php echo $isEdit ? $cat->getCatDesc() : '' ?></textarea>
                        </div>
                    </div>

                    <div class="form-actions col-sm-offset-2 col-sm-10">
                        <button type="submit" name="addNewCatBtn" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-color no-border green">
            <div class="box-title">
                <h3><i class="fa fa-pie-chart"></i>Category - Analysis</h3>
            </div>
            <div class="box-content" data-height="400" data-visible="true">
                <div id="category" class="flot"> </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // data = [{ label: "Series1",  data: 10},
    //     { label: "Series2",  data: 3},
    //     { label: "Series3",  data: 9},
    //     { label: "Series4",  data: 7},
    //     { label: "Series5",  data: 8},
    //     { label: "Series6",  data: 17}];

    data = <?php echo json_encode($pie_data); ?>

    $.plot('#category', data, {
        series: {
            pie: {
                show: true
            }
        }
    });
</script>




<?php include_once 'footer.php'; ?>