<?php
echo $this->renderPartial($this->path_view . '_checklistBerkas._headerPrint', array());
?>
<div class="panel panel-gradient">
    <div class="panel-body">

        <div class="panel-body" id="form-datakunjungan">
            <div class="row-fluid">
                <?php $this->renderPartial($this->path_view . '_checklistBerkas._formDataPasienPrint', array('modPendaftaran' => $modPendaftaran));?>
            </div>
            <div class="row-fluid">
                <?php $this->renderPartial($this->path_view . '_checklistBerkas._dokumen_1Print', array('modPendaftaran' => $modPendaftaran, 'model' => $model));?>
            </div>
        </div>
    </div>
</div>