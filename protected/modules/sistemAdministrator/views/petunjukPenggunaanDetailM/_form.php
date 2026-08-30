<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'petunjuk-penggunaan-detail-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    // 'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    // 'focus' => '#' . CHtml::activeId($model, 'sumberdana_nama'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Petunjuk Pengguna <span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->dropDownList($model,'petunjukpenggunaan_id', CHtml::listData(PetunjukpenggunaanM::model()->findAll('petunjukpenggunaan_aktif = true'),'petunjukpenggunaan_id','namaMenu'),array('empty'=>'-- Pilih --')) ?>
                
            </div>
        </div>
        
    </div> 
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'petunjukpenggunaandetail_image', array('class' => 'control-label')) ?>
            <?php if (!empty($model->petunjukpenggunaandetail_image)) { ?>
                <img src="<?php echo Params::urlPetunjukPenggunaanDirectory() . $model->petunjukpenggunaandetail_image ?> " style="width: 20%;padding:10px;display: block;">
            <?php } else {
                echo "<span style='padding:10px 25px;'> Gambar belum di-set</span>";
            } ?>
            <div class="controls">
                <?php echo Chtml::activeFileField($model, 'petunjukpenggunaandetail_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Gambar')); ?>
            </div>

        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Aktif', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'petunjukpenggunaandetail_aktif', array('checked' => 'petunjukpenggunaandetail_aktif')); ?>
                <label for="SAPetunjukpenggunaanM_petunjukpenggunaandetail_aktif">Aktif</label>
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
        Yii::t('mds', '{icon} Pengaturan Petunjuk Penggunaan Detail', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
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