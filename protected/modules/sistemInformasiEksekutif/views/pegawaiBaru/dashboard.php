<link rel="stylesheet" href="themes/neon18/assets/css/sidebar/custom-sidebar-green.css">
<link rel="stylesheet" href="themes/neon18/assets/css/sidebar/neon-forms-green.css">
<link rel="stylesheet" href="themes/neon18/assets/css/sidebar/inovastyle.css">
<style>
    .panel-success:not(:first-of-type) {
        margin-top: 17px;
    }

    .main-content {
        margin: 0;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view.'_table', array('model' => $model, 'dataTable' => $dataTable)); ?>