<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saalatmedis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Detail Pengiriman Kantong Darah </b> </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel panel-heading"> 
                <div class="panel-title"> <b> Data Pengiriman Kantong Darah  </b></div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('No. Pengiriman', '', array('class' => 'control-label')); ?>
                        <div class="controls">	
                            <?php echo CHtml::activeTextField($model, 'no_kirimkantong', array('readonly' => true, 'class' => 'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan Asal ', '', array('class' => 'control-label')); ?>
                        <div class="controls">	
                            <?php echo CHtml::activeTextField($model, 'ruangankirim_nama', array('readonly' => true, 'class' => 'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Waktu Pengiriman ', '', array('class' => 'control-label')); ?>
                        <div class="controls">	
                            <?php
                            $model->tglkirimkantongdarah = MyFormatter::formatDateTimeForUser($model->tglkirimkantongdarah);
                            echo CHtml::activeTextField($model, 'tglkirimkantongdarah', array('readonly' => true, 'class' => 'span3'));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Suhu Pengiriman', '', array('class' => 'control-label')); ?>
                        <div class="controls">	
                            <?php echo CHtml::activeTextField($model, 'suhu_kirim', array('readonly' => true, 'class' => 'span3')); ?>
                            <label><sup>o</sup>C</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Petugas Pengiriman', '', array('class' => 'control-label')); ?>
                        <div class="controls">	
                            <?php echo CHtml::activeTextField($modKantong, 'petugaskirim_nama', array('readonly' => true, 'class' => 'span3')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="panel panel-success">
                <div class="panel panel-heading"> 
                    <div class="panel-title"> <b> Tabel Pengiriman Kantong Darah  </b></div>
                </div>
                <div class="panel-body">
                    <?php
                    $modDet = new KirimkantongdetT;
                    $criteria = new CDbCriteria;
                    $criteria->select = 'kantongdarah.nomorbarcode_utama, kantongdarah.nomorbarcode_sample_imltd, coolbox.no_penggunaan_coolbox, jenis.coolboxdarah_nama, 
                                         kantongdarah.nomorbarcode_utama, kantongdarah.nomorbarcode_sample,
                                         kantongdarah.gol_darah, kantongdarah.rhesus, jeniskantongdarah.nama_jenis';
                    $criteria->join = 'JOIN kantongdarah_t kantongdarah ON kantongdarah.kantongdarah_id = t.kantongdarah_id 
                                       LEFT JOIN penggunaan_coolbox_t coolbox ON t.no_penggunaan_coolbox = coolbox.no_penggunaan_coolbox
                                       LEFT JOIN coolboxdarah_m jenis ON coolbox.coolboxdarah_id = jenis.coolboxdarah_id
                                       LEFT JOIN jeniskantongdarah_m jeniskantongdarah ON jeniskantongdarah.jeniskantongdarah_id = kantongdarah.jeniskantongdarah_id';
                    $criteria->addCondition('t.kirimkantongdarah_id = ' . $model->kirimkantongdarah_id);
                    $criteria->group = 'kantongdarah.nomorbarcode_utama, kantongdarah.nomorbarcode_sample_imltd, coolbox.no_penggunaan_coolbox,jenis.coolboxdarah_nama,kantongdarah.nomorbarcode_utama, kantongdarah.nomorbarcode_sample,kantongdarah.gol_darah, kantongdarah.rhesus, jeniskantongdarah.nama_jenis ';

                    $dataProvider = new CActiveDataProvider($modDet, array(
                        'criteria' => $criteria,
                    ));

                    $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
                        'id' => 'diagnosa-mrs-grid',
                        'dataProvider' => $dataProvider,
                        'template' => "{items}\n{pager}",
                        'mergeColumns' => array('no_penggunaan_coolbox', 'coolboxdarah_nama'),
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Nomor Penggunaan Coolbox',
                                'name' => 'no_penggunaan_coolbox',
                                'value' => '$data->no_penggunaan_coolbox',
                            ),
                            array(
                                'header' => 'Jenis Coolbox',
                                'name' => 'coolboxdarah_nama',
                                'value' => '$data->coolboxdarah_nama',
                            ),
                            /*
                            array(
                                'header' => 'No. Identitas Pendonor',
                                'value' => '$data->no_identitas',
                            ),
                             */
                            array(
                                'header' => 'No. Kantong Utama / No. Sample',
                                'value' => function($data) {
                                    return $data->nomorbarcode_utama;
                                }
                            ),
//                            array(
//                                'header'=> 'No. Sampel Konfirmasi Gol Darah',
//                                'value' => function($data) {
//                                    return $data->nomorbarcode_sample;
//                                }
//                            ),
//                            array(
//                                'header'=> 'No. Sampel Skrining IMLTD',
//                                'value' => function($data) {
//                                    return !empty($data->nomorbarcode_sample_imltd) ? $data->nomorbarcode_sample_imltd : " ";
//                                }
//                            ),
                            array(
                                'header' => 'Golongan Darah / Rhesus',
                                'value' => function($data) {
                                    return $data->gol_darah . " / " . $data->rhesus;
                                }
                            ),
                            array(
                                'header' => 'Jenis Kantong Darah',
                                'value' => '$data->nama_jenis',
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $_GET['id'] . ")", 'disabled' => false)) . '&nbsp;';
                    echo CHtml::link(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="entypo-book"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPDF(" . $_GET['id'] . ")", 'disabled' => false));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . 'pengirimanKantongDarah' . '/print', array('kirimkantongdarah_id' => ''));
?>
<script>
    function print(kirimkantongdarah_id){
        window.open('<?php echo $urlPrint?>'+kirimkantongdarah_id+'&caraPrint=PRINT','printwin','left=400,top=400,width=800,height=600');
    }
    
    function printPDF(kirimkantongdarah_id){
        window.open('<?php echo $urlPrint?>'+kirimkantongdarah_id+'&caraPrint=PDF','printwin','left=400,top=400,width=800,height=600');
    }
</script>