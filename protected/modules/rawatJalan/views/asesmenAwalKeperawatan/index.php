<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }

    .dotRed {
  height: 10px;
  width: 10px;
  background-color: red;
  border-radius: 50%;
  display: inline-block;
}

.tablecustom td, .tablecustom th{
  padding: 5px;
  color: black;
}
.bit-box {
    z-index: 1 !important;
}
</style>

<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat Asesmen Awal Keperawatan</div>
    </div>
    <div class="panel-body" style="overflow-x: auto; max-width: 100%;">
        <div class="block-tabel">
                <?php $this->renderPartial($this->path_view.'_riwayatTable',array('model'=>$model)) ?>
        </div>
    </div>
</div>
<p class="help-block"><?php echo Yii::t('mds', 'Pilih Jenis Asesmen Awal Keperawatan') ?></p>
<?php $this->renderPartial($this->path_view.'_form',array('modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien, 'modAsesmenkebutuhanEdukasiT'=>$modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT'=>$modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT,'dataFlaCcs'=>$dataFlaCcs, 'getFlaCcs'=>$getFlaCcs,'modRiwayatObstetrikPasien'=>$modRiwayatObstetrikPasien, 'modAsesmenawalkeperawatanT'=>$model)) ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs)); ?>
<script src="themes/neon/assets/js/jquery.bootstrap.wizard.min.js"></script>
