<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Approval Menu Farmasi
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_table', ['modMenuModul' => $modMenuModul]); ?>
            </div>
        </div>
    </div>
   
    
</div>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>