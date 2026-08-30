<div class="search-form">
    <?php
    $this->breadcrumbs = array(
        'Laporan Sensus Harian',
    );
    $url = Yii::app()->createUrl('mcu/laporanMC/frameGrafikSensusHarianMC&id=1');
    Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
    ");
    ?>

    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-newspaper"></i> Laporan <b>Sensus Harian</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="panel panel-success" style="margin-top: 0 !important;">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'type' => 'horizontal',
                        'id' => 'searchLaporan',
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                    ));
                    ?>

                    <div class="row">
                        <div class="col-sm-6">
                            <?php //$format = new MyFormatter(); 
                            ?>
                            <?php echo CHtml::hiddenField('type', ''); ?>
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
                            <div id='searching'>
                                <?php
                                echo CHtml::hiddenField('filter', 'wilayah') .
                                    '<div class="control-group">
                                            ' . CHtml::label('Provinsi', 'carabayar_id', array('class' => 'control-label')) . ' 
                                            <div class="controls">
                                                ' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                                        'class' => 'form-control', 'multiple' => 'multiple'
                                    )) . '
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            ' . CHtml::label('Kabupaten', 'penjamin_id', array('class' => 'control-label')) . ' 
                                            <div class="controls">												 
                                                ' . $form->dropDownList($model, 'kabupaten_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                                            </div>
                                        </div>';
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div id='searching'>
                                <?php
                                echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                                    '<div class="control-group">
                                                        ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                                                        <div class="controls">
                                                            ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                        'class' => 'form-control', 'multiple' => 'multiple'
                                    )) . '
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                                                        <div class="controls">												 
                                                            ' . $form->dropDownList($model, 'penjamin_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . '
                                                        </div>
                                                    </div>';
                                ?>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Filter</label>
                                <div class="controls">
                                    <?php
                                    echo $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                        );
                        ?>
                        <?php
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                            )
                        );
                        $this->endWidget();
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Sensus Harian</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <?php $this->renderPartial($this->path_view_mcu . 'sensus/_table', array('model' => $model)); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-chart-bar"></i> Grafik
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view_mcu . '_tab'); ?>
                    <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
                </div>
            </div>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanSensusHarianMC');

            $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
            ?>
        </div>
    </div>
</div>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php $this->renderPartial($this->path_view_mcu . '_jsFunctions', array('model' => $model)); ?>