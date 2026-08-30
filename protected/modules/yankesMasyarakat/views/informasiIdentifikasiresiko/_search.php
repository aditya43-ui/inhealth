<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasiae-r-search',
    'type' => 'horizontal',
        ));
?>
<style>
    .listtanggal{
        float: left;
    }
    .listtanggal1{
        padding-left:2px;
        font-size:11.5px;
        float: left;
        font-weight: normal;
        line-height:18px;

    }
</style>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">	

            <div class="control-group">
                <?php echo CHtml::label('Periode Manajemen Resiko', '', array('class' => 'control-label ')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'perioderiskregister_id', CHtml::listData(PerioderiskregisterM::model()->findAllByAttributes(array(), array('order' => 'periode_akhir desc')), 'perioderiskregister_id', 'nama_perioderiskregister'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Risk Management', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php 
                    echo $form->dropDownList($model, 'jenisriskmanajemen', LookupM::getItems("jenisriskmanajemen"), array('class' => 'span3', 'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sumber Resiko ', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'sumber_resiko', LookupM::getItems("sumber_riskregister"), array('class' => 'span3 ', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Unit Kerja", '', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'unitkerja_id', Chtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --', 'class' => 'span3')) ?>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Tipe Manajemen Resiko <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'tiperesiko_id', CHtml::listData($model->getTipeResikoItems(), 'tiperesiko_id', 'tiperesiko_nama'), array('class' => 'span3',
                    'ajax' => array('type' => 'POST',
                        'dataType' => "json",
                        'url' => $this->createUrl('/actionDynamic/GetSubTipe', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "subtiperesiko_id") . '").html(data.drop);}',
                    ),
                    'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sub Tipe Manajemen Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'subtiperesiko_id', CHtml::listData($model->getSubTipeResikoItems($model->tiperesiko_id, 'wajib'), 'subtiperesiko_id', 'subtiperesiko_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('InformasiIdentifikasiresiko/index'), array('class' => 'btn btn-danger',
        'onclick' => 'return refreshForm(this);'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Petunjuk', array('{icon}' => '<i class="entypo-info-circled"></i>')), $this->createUrl('InformasiIdentifikasiresiko/lihatPetunjuk'), array('class' => 'btn btn-info',
        'target' => 'blank'));
    ?>
   

</div>


<?php
$this->endWidget();
?>