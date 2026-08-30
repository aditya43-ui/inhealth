<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        #penjamin,
        #ruangan,
        #statusBayar {
            width: 250px;
        }

        #penjamin label.checkbox,
        #ruangan label.checkbox,
        #statusBayar label.checkbox {
            width: 150px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Jenis Kelompok', 'jenisobatalkes_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'lookup_name', LookupM::getItems('jnskelompok'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('Jenis Obat', 'jenisobatalkes_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData($model->getJenisobatalkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('Kategori', 'obatalkes_kategori', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_kategori',   LookupM::getItemsUrutan('obatalkes_kategori'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('Golongan', 'obatalkes_golongan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_golongan',   LookupM::getItemsUrutan('obatalkes_golongan'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Kode Obat Alkes', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'obatalkes_kode', array('placeholder' => 'Kode Obat Alkes', 'class' => 'span3')); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php echo CHtml::label('Nama Obat Alkes', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'obatalkes_nama', array('placeholder' => 'Nama Obat Alkes', 'class' => 'span3')); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Pilihan</label>
                <div class="controls">
                    <?php echo CHtml::checkBox('FAInfostokobatalkesruanganV[qtystok_in]', true, array('id' => 'qtystok_in', 'value' => 0)); ?>
                    <?php echo CHtml::label('Stok Masuk 0', 'qtystok_in'); ?>
                    <br>
                    <?php echo CHtml::checkBox('FAInfostokobatalkesruanganV[qtystok_out]', true, array('id' => 'qtystok_out', 'value' => 0)); ?>
                    <?php echo CHtml::label('Stok Keluar 0', 'qtystok_out'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
        );
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        myConfirm("Apakah Anda ingin me-refresh halaman?","Perhatian!",
        function(r){
            if(r){
                window.location.href="' . Yii::app()->createUrl($module . '/' . $controller . '/LaporanStockFarmasi', array('modul_id' => Yii::app()->session['modul_id'])) . '";
            }
        }); 
    }', CClientScript::POS_HEAD); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>