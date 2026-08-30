<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<?php
$this->breadcrumbs = array(
    'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkonsul-poli-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($modKonsul, 'catatan_dokter_konsul'),
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Konsultasi MCU</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view . '_listKonsulMCU', array('modRiwayatKonsul' => $modRiwayatKonsul)); ?>
                </div>
            </div>
        </div>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary(array($modKonsul, $modelPendaftaran)); ?>
        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modKonsul, 'tglkonsulpoli', array('class' => 'control-label')) ?>
                <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modKonsul,
                        'attribute' => 'tglkonsulpoli',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2'),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow(
                $modKonsul,
                'ruangan_id',
                CHtml::listData($modKonsul->getRuanganInstalasi(), 'ruangan_id', 'ruangan_nama'),
                array('empty' => '-- Pilih --', 'class' => 'span3', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setTarif()')
            ); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow(
                $modKonsul,
                'pegawai_id',
                CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
            ); ?>
            <?php echo $form->textAreaRow($modKonsul, 'catatan_dokter_konsul', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan <b>Medical Check Up</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-ticket"></i> Karcis <b>Medical Check Up</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="box">
                            <div class="col-sm-12">
                                <?php echo $form->hiddenField($modPendaftaran, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                <?php
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'form-karcis',
                                    'content' => array(
                                        'content-karcis' => array(
                                            'header' => '<b>Karcis</b>',
                                            'isi' => $this->renderPartial($this->path_view . '_formKarcis', array(
                                                'form' => $form,
                                                'modPendaftaran' => $modPendaftaran,
                                                'modTindakan' => $modTindakan,
                                                'modTindakanKarcis' => $modTindakanKarcis,
                                                'dataTindakans' => $dataTindakans,
                                            ), true),
                                            'active' => $modPendaftaran->is_adakarcis,
                                        ),
                                    ),
                                ));
                                ?>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Paket <b>Medical Check Up</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="box">
                            <div id='content-pemeriksaan-mcu-paket'>
                                <?php
                                $this->renderPartial($this->path_view . '_formCariPemeriksaan', array(
                                    'modPaketPelayanan' => $modPaketPelayanan,
                                ));
                                ?>
                                <div class='checklists'></div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Di Luar Paket
                        </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="box">
                            <div id='content-pemeriksaan-mcu-diluar-paket'>
                                <?php
                                $this->renderPartial($this->path_view . '_formCariPemeriksaanDiluarPaket', array(
                                    'modPaketPelayanan' => $modPaketPelayanan,
                                ));
                                ?>
                                <div class='checklists-mcu-diluar-paket'></div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Pernah ke MCU
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <div class="control-group">
                                <div class="checkbox inline">
                                    <?php
                                    echo CHtml::activeCheckBox($modPemeriksaanMcu, 'pernahmcu', array());
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemeriksaanMcu, 'tglrencanaperiksa', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modPemeriksaanMcu->tglrencanaperiksa = (!empty($modPemeriksaanMcu->tglrencanaperiksa) ? date("d/m/Y H:i:s", strtotime($modPemeriksaanMcu->tglrencanaperiksa)) : null);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPemeriksaanMcu,
                                        'attribute' => 'tglrencanaperiksa',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            //                                    'dateFormat'=>Params::DATE_FORMAT,
                                            'showOn' => false,
                                            'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                                    ));
                                    ?>
                                    <?php echo $form->error($modPemeriksaanMcu, 'tglrencanaperiksa'); ?>
                                </div>
                            </div>
                            <?php echo $form->textAreaRow($modPemeriksaanMcu, 'keteranganpermintaan', array('placeholder' => 'Keterangan Permintaan', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Medical Check Up</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div id="form-tindakanpemeriksaan">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <!--<th>Tarif Tindakan</th>
                                    <th>Total Tarif</th>-->
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan Medical Check Up - Diluar Paket</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="form-tindakanpemeriksaan-diluar-paket">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <!--<th>Tarif Tindakan</th>
                                    <th>Total Tarif</th>-->
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
                    ); ?>
                    <?php
                    if (isset($_GET['idKonsulPoli'])) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
                    }
                    ?>
                    <?php
                    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    $ruanganMCU = $modKonsul->ruangan_id; // ruangan Klinik MCU (sesuai dengan yang di dropdown)                       
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsul',
    'options' => array(
        'title' => 'Detail Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));
echo '<div id="contentDetailKonsul"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
    'modKonsul' => $modKonsul, 'karcisTindakan' => $karcisTindakan,
    'modRiwayatKonsul' => $modRiwayatKonsul, 'modelPendaftaran' => $modelPendaftaran,
    'modJenisTarif' => $modJenisTarif, 'modPaketPelayanan' => $modPaketPelayanan,
    'modPemeriksaanMcu' => $modPemeriksaanMcu, 'modTindakan' => $modTindakan,
    'modPermintaanMcu' => $modPermintaanMcu, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
    'modTindakanKarcis' => $modTindakanKarcis, 'dataTindakans' => $dataTindakans
)); ?>