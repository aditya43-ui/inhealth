<div class="row-fluid" id="faskes">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pencarian</div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view . '_formPencarian', array('form' => $form)); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel Diagnosa <b>(ICD-10)</b></div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view . '_tabelDiagnosa', array()); ?>
        </div>
    </div>
</div>