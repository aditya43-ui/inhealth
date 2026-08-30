<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'search-laporan',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'noterima'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::hiddenField('filter_tab', 'rekap'); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($model, 'jnskelompok', array('class' => 'control-label', 'label' => 'Jenis Kelompok')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jnskelompok', LookupM::getItems('jnskelompok'), array('multiple' => 'multiple')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($model, 'jenisobatalkes_id', array('class' => 'control-label', 'label' => 'Jenis Obat Alkes')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenisobatalkes_id', JenisobatalkesM::model()->listItem(), array('multiple' => 'multiple')); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($model, 'obatalkes_kategori', array('class' => 'control-label', 'label' => 'Kategori')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_kategori', ObatAlkesKategori::items(), array('multiple' => 'multiple')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($model, 'obatalkes_golongan', array('class' => 'control-label', 'label' => 'Golongan')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_golongan', ObatAlkesGolongan::items(), array('multiple' => 'multiple')); ?>
                </div>
            </div>

            <?php // echo $form->textFieldRow($model, 'noterima', array('placeholder' => 'No. Penerimaan', 'class' => 'numberOnly')); 
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">


            <?php /*$modSup = new GFSupplierM(); ?>
			<div class="control-group">
                <?php echo CHtml::label('Supplier','supplier_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'supplier_id', CHtml::listData($modSup->getSupplierItems(), 'supplier_id', 'supplier_nama'),array(
                                        'class'=>'form-control', 'multiple'=>'multiple')); 
                    ?>											
                </div>
            </div>
			
			<?php
				//echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData($modSup->getSupplierItems(), 'supplier_id', 'supplier_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                //'empty' => '-- Pilih --',));
             * 
             */
            ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array(
                'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    function resetForm() {
        setTimeout(function() {
            $('#search-laporan').submit();
        }, 500);
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>