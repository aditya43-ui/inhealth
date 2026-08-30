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
    
    echo CHtml::hiddenField('formDiagnosa','');
?>
<?php //if(Yii::app()->user->getState("ruangan_id") != Params::RUANGAN_ID_PERSALINAN){ ?>
<div class="panel panel-success panel_choise" id="choise_neonatus" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 1, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Neonatus (< 30 Hari)</div>
    </div>
    <div class="panel-body" >
        <?php echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmenri_neonatus')); ?>
        <div class="formNeonatus">
            <?php 
            $this->renderPartial($this->path_view.'_formNeonatus',array(
                'dropPerawat'=>$dropPerawat,
                'dropDokter'=>$dropDokter,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT,'modPeriksaFisikNeonatusRI'=>$modPeriksaFisikNeonatusRI, 'modBarthelindex'=>$modBarthelindex, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs)) ?>
        </div>
    </div>
</div>
<div class="panel panel-success panel_choise" id="choise_anak" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 2, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Anak</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmenri_anak')); ?>
        <div class="formAnak">
            <?php 
            $this->renderPartial($this->path_view.'_formAskepAnak',array(
                'dropPerawat'=>$dropPerawat,
                'dropDokter'=>$dropDokter,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs, 'modBarthelindex'=>$modBarthelindex)) ?>
        </div>
    </div>
</div>
<div class="panel panel-success panel_choise" id="choise_dewasa" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 3, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Dewasa</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmenri_dewasa')); ?>
        <div class="formDewasa">
            <?php 
            $this->renderPartial($this->path_view.'_formAskepDewasa',array(
                'dropPerawat'=>$dropPerawat,
                'dropDokter'=>$dropDokter,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs, 'modBarthelindex'=>$modBarthelindex)) ?>
        </div>
    </div>
</div>
<?php //} ?>
<div class="panel panel-success panel_choise" id="choise_obgyn" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 4, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Obgyn</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmenri_obgyn')); ?>
        <div class="formObgyn">
            <?php 
            $this->renderPartial($this->path_view.'_formAskepObgyn',array(
                'dropPerawat'=>$dropPerawat,
                'dropDokter'=>$dropDokter,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs, 'modBarthelindex'=>$modBarthelindex)) ?>
        </div>
    </div>
</div>

<?php if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_PI){ ?>
<div class="panel panel-success panel_choise" id="choise_geriatri" >
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::activeRadioButton($model,'isasesmenawalkep', array('onclick' => 'choiseAskep(this)', 'value' => 5, 'class'=>'pilih_aswkep', 'uncheckValue'=>null)); ?> Asesmen Awal Keperawatan Geriatri</div>
    </div>
    <div class="panel-body" >
        <?php  echo CHtml::activeHiddenField($model, 'jenisasesmen', array('value'=>'asesmenri_geriatri')); ?>
        <div class="formGeriatri">
            <?php 
            $this->renderPartial($this->path_view.'_formAskepGeriatri',array(
                'dropPerawat'=>$dropPerawat,
                'dropDokter'=>$dropDokter,
                'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien, 'modAskepgeriatriT'=>$modAskepgeriatriT, 'modBarthelindex'=>$modBarthelindex, 'modPenilaianRenPulang'=>$modPenilaianRenPulang,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT, 'modMinimentalexampasienT'=>$modMinimentalexampasienT, 'modMinimentalexampasiendetT'=>$modMinimentalexampasiendetT)) ?>
        </div>
    </div>
</div>
<?php } 

$this->renderPartial($this->path_view.'_dialog',[]);
?>
