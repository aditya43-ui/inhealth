<style>
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }
</style>
<?php
    $dropDokter = PegawaiV::model()->findAll(" pegawai_aktif = true AND kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK." ORDER BY nama_pegawai ASC ");
    $dropPerawat = PegawairuanganV::model()->findAll(" pegawai_aktif = true AND kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN." AND ruangan_id = ".Yii::app()->user->getState('ruangan_id')." ORDER BY nama_pegawai ASC ");
?>
<div class="panel panel-success panel_choise" id="choise_neonatus" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 1, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Neonatus (< 30 Hari)</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmen_neonatus')); ?>
        <div class="formNeonatus">
            <?php $this->renderPartial($this->path_view.'_formNeonatus',array(
                'dropDokter'=>$dropDokter,
                'dropPerawat'=>$dropPerawat,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT)) ?>
        </div>
    </div>
</div>

<div class="panel panel-success panel_choise" id="choise_anak" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 2, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Anak</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmen_anak')); ?>
        <div class="formAnak">
            <?php $this->renderPartial($this->path_view.'_formAskepAnak',array(
                'dropDokter'=>$dropDokter,
                'dropPerawat'=>$dropPerawat,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs)) ?>
        </div>
    </div>
</div>

<div class="panel panel-success panel_choise" id="choise_dewasa" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 3, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Dewasa</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmen_dewasa')); ?>
        <div class="formDewasa">
            <?php $this->renderPartial($this->path_view.'_formAskepDewasa',array(
                'dropDokter'=>$dropDokter,
                'dropPerawat'=>$dropPerawat,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs, 'modAsesmenawalkeperawatanT'=>$modAsesmenawalkeperawatanT)) ?>
        </div>
    </div>
</div>

<div class="panel panel-success panel_choise" id="choise_obgyn" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 4, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Obgyn</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmen_obgyn')); ?>
        <div class="formObgyn">
            <?php $this->renderPartial($this->path_view.'_formAskepObgyn',array(
                'dropDokter'=>$dropDokter,
                'dropPerawat'=>$dropPerawat,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs, 'modRiwayatObstetrikPasien'=>$modRiwayatObstetrikPasien)) ?>
        </div>
    </div>
</div>
