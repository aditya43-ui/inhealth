<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-list"></i><b> KELENGKAPAN DATA PASIEN PULANG</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view . '_checklistBerkas._dokumen_1', array('model' => $model, 'form' => $form));?>
        </div>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view . '_checklistBerkas._dokumen_2', array('model' => $model, 'form' => $form));?>
        </div>
    </div>
</div>