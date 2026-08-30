<?php
$this->breadcrumbs = array(
    'Laporan Penggajian',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#laporan-search').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Selisih Komponen Gaji</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                            'id' => 'laporan-search',
                            'type' => 'horizontal',
                        )); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo CHtml::hiddenField('type', ''); ?>
                                <div class="control-group">
                                    <?php echo CHtml::label("Sampai Dengan", 'bln_awal', array('class' => 'control-label')) ?>
                                    <div class="controls">



                                        <?php

                                        $model2 = clone $model;
                                        $model2->bln_awal = MyFormatter::formatMonthForUser($model->bln_awal);
                                        $model2->bln_akhir = MyFormatter::formatMonthForUser($model->bln_akhir);

                                        $this->widget('MyMonthPicker', array(
                                            'model' => $model2,
                                            'attribute' => 'bln_awal',
                                            'options' => array(
                                                'dateFormat' => Params::MONTH_FORMAT,
                                                'yearRange' => "-100y:+0y",
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'class' => "span2 periode_gaji",
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                        ));

                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Periode Gaji", 'bln_awal', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php


                                        $this->widget('MyMonthPicker', array(
                                            'model' => $model2,
                                            'attribute' => 'bln_akhir',
                                            'options' => array(
                                                'dateFormat' => Params::MONTH_FORMAT,
                                                'yearRange' => "-100y:+0y",
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'class' => "span2 periode_gaji",
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                        ));


                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($model, 'nama_pegawai', array('class' => 'span3', 'maxlength' => 30)); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')); ?>
                                <div class="control-group">
                                    <?php echo CHtml::label('Jabatan', 'jabatan_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList($model, 'jabatan_id', CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), array(
                                            'class' => 'form-control', 'multiple' => 'multiple'
                                        )); ?>
                                    </div>
                                </div>
                                <?php
                                /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
										'id' => 'jabatan',
										'slide' => true,
										'content' => array(
											'content2' => array(
												'multi' => 'multi',
												'header' => 'Berdasarkan Jabatan',
												'isi' => CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')) . 
													'<div class="control-group">
														'.CHtml::label('Jabatan','jabatan_id', array('class' => 'control-label')).' 
														<div class="controls">
															'.$form->dropDownList($model,'jabatan_id',CHtml::listData($model->getJabatanItems(),'jabatan_id','jabatan_nama'),array(
															'class'=>'form-control', 'multiple'=>'multiple')).'											
														</div>
													</div>',
												'active' => true,
											),
										),
									));*/
                                ?>
                                <?php //echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData($model->getJabatanItems(),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); 
                                ?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
                            <?php echo CHtml::link(
                                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                                Yii::app()->createUrl($this->module->id . '/Laporan/selisihGaji'),
                                array('class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
                            ); ?>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Selisih Komponen Gaji</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial($this->path_view_lap . 'selisihGaji/_table', array('model' => $model)); ?>
                        <?php
                        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanSelisihGaji');
                        $url = ""; //?
                        ?>
                    </div>
                </div>
                <?php $this->renderPartial($this->path_view_lap . '_footerWithoutgrafik', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
            </div>
        </div>
    </div>
</div>
<?php //$this->renderPartial('penggajian.views.laporan._jsFunction', array('model'=>$model)); 
?>
<?php $this->renderPartial($this->path_view_lap . '_jsFunctions', array('model' => $model)); ?>