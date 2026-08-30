<style>
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }
</style>
<br><br>
<p>
    <b>Pilih Sistem Skoring yang digunakan</b>
</p>
<?php
    if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_DEWASA || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_LANSIA){
?>
<div class="panel panel-success panel_choise" id="choise_ews" >
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($model, 'is_jenisews', array('onclick' => 'choiseEws(this)', 'value' => 1, 'class'=>'pilih_ews', 'uncheckValue'=>null)); ?> Early Warning Score (EWS)</div>
        </div>
        <div class="panel-body" >
            <?php echo CHtml::activeHiddenField($model, 'jenisews', array('value'=>'ews')); ?>
            <div class="formEws">
                <?php $this->renderPartial($this->path_view.'_formEws',array('model'=>$model,'modDetail'=>$modDetail)) ?>
            </div>
        </div>
    </div>
<?php   
    }
    
    if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BALITA || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){
?>

    <div class="panel panel-success panel_choise" id="choise_pews" >
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($model, 'is_jenisews', array('onclick' => 'choiseEws(this)', 'value' => 2, 'class'=>'pilih_ews', 'uncheckValue'=>null)); ?> Pediatric Early Warning Score (PEWS)</div>
        </div>
        <div class="panel-body" >
            <?php echo CHtml::activeHiddenField($model, 'jenisews', array('value'=>'pews')); ?>
             <div class="formPews">
                <?php $this->renderPartial($this->path_view.'_formPews',array('model'=>$model,'modDetail'=>$modDetail)) ?>
            </div>
        </div>
    </div>
<?php   
    }
    
    if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BALITA || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){
?>
    <div class="panel panel-success panel_choise" id="choise_news" >
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($model, 'is_jenisews', array('onclick' => 'choiseEws(this)', 'value' => 3, 'class'=>'pilih_ews', 'uncheckValue'=>null)); ?> Newborn Early Warning Score (NEWS)</div>
        </div>
        <div class="panel-body" >
            <?php echo CHtml::activeHiddenField($model, 'jenisews', array('value'=>'newborn ews')); ?>
            
             <div class="formNews">
                <?php $this->renderPartial($this->path_view.'_formNews',array('model'=>$model,'modDetail'=>$modDetail)) ?>
            </div>
        </div>
    </div>
<?php   
    }
    
    if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BALITA || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_DEWASA || $modPasien->kelompokumur_id == Params::KELOMPOKUMUR_LANSIA){
?>
    <div class="panel panel-success panel_choise" id="choise_moews" >
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($model, 'is_jenisews', array('onclick' => 'choiseEws(this)', 'value' => 4, 'class'=>'pilih_ews', 'uncheckValue'=>null)); ?> Modified Obstetric Early Warning System (MOEWS)</div>
        </div>
        <div class="panel-body" >
            <?php echo CHtml::activeHiddenField($model, 'jenisews', array('value'=>'moews')); ?>
            
             <div class="formMoews">
                <?php $this->renderPartial($this->path_view.'_formMoews',array('model'=>$model,'modDetail'=>$modDetail)) ?>
            </div>
        </div>
    </div>
<?php   
    }
?>




