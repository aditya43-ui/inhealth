<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'petunjuk-penggunaan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    // 'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    // 'focus' => '#' . CHtml::activeId($model, 'sumberdana_nama'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Menu <span class="required">*</span></label>
            <div class="controls">
                <?php //echo $form->dropDownList($model,'modul_id', CHtml::listData(ModulK::model()->findAll('modul_aktif = true order by modul_nama asc'),'modul_id','modul_nama'),array('empty'=>'-- Pilih --','onchange'=>'setModul(this)')) ?>
                <?php echo $form->dropDownList($model,'menu_id',CHtml::listData(MenumodulK::model()->findAll('modul_id = '.Yii::app()->user->getState('modul_id').' and menu_aktif = true order by menu_nama asc'),'menu_id','menu_nama'),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'petunjukpenggunaan_versi');?>
        <?php //echo $form->textAreaRow($model,'petunjukpenggunaan_deskripsi');?>
        <div class="control-group">
            <label class="control-label">Deskripsi Petunjuk Penggunaan</label>
            <div class="controls">
                <?php //echo $form->dropDownList($model,'modul_id', CHtml::listData(ModulK::model()->findAll('modul_aktif = true order by modul_nama asc'),'modul_id','modul_nama'),array('empty'=>'-- Pilih --','onchange'=>'setModul(this)')) ?>
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'petunjukpenggunaan_deskripsi', 'toolbar' => 'mini', 'height' => '150px'));?>
            </div>
        </div>
        
    </div> 
    <div class="col-sm-6">
        <!-- <div class="control-group">
            <?php //echo $form->labelEx($model, 'petunjukpenggunaan_image', array('class' => 'control-label')) ?>
            <?php //if (!empty($model->petunjukpenggunaan_image)) { ?>
                <img src="<?php //echo Params::urlProfilRSDirectory() . $model->petunjukpenggunaan_image ?> " style="width: 20%;padding:10px;display: block;">
            <?php //} else {
                //echo "<span style='padding:10px 25px;'> Gambar belum di-set</span>";
            //} ?>
            <div class="controls">
                <?php //echo Chtml::activeFileField($model, 'petunjukpenggunaan_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Gambar')); ?>
            </div>

        </div> -->
        <div class='control-group'>
            <?php echo $form->labelEx($model,'petunjukpenggunaan_video', array('class'=>'control-label')) ?>
            <div class="controls">  
                <?php echo Chtml::activeFileField($model,'petunjukpenggunaan_video',array('maxlength'=>254,'hint'=>'Isi Jika Akan Menambahkan  Video')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Aktif', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'petunjukpenggunaan_aktif', array('checked' => 'petunjukpenggunaan_aktif')); ?>
                <label for="SAPetunjukpenggunaanM_petunjukpenggunaan_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Petunjuk Penggunaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function setModul(obj){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetMenuByModul'); ?>',
            data: {modul_id:$(obj).val()},//
            dataType: "json",
            success:function(data){
            console.log(data)
            //    $("#KUTandabuktikeluarT_bank_id").html(data.option);
            
            $("#SAPetunjukpenggunaanM_menu_id").html(data.option);
            // $('#KUPengeluaranumumT_nopengeluaran').val(data.no)
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });

    }
</script>