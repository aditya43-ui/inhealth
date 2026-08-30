<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Berita Acara Kemajuan Hasil Pekerjaan</span></div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formKemajuanHasilPekerjaan', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form)); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Lampiran</span></div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formLampiran', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form)); ?>
    </div>
</div>