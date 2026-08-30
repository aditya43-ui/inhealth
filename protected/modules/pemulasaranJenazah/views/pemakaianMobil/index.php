<?php
$this->breadcrumbs = array(
    'Informasi Pemulasaran Jenazah' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Pemakaian Mobil Jenazah',
);

$arrMenu = array();
$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp ',
        //        'showSymbol'=>true,
        //        'symbolStay'=>true,
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '.',
        'precision' => 0,
    )
));

$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.number',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '.',
        'precision' => 0,
    )
));
?>
<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0) {
    Yii::app()->user->setFlash('success', "Transaksi Pemakaian Ambulans berhasil disimpan!");
}

?>
<style type="text/css">
    .tabelTarifAmbulan {
        overflow: auto;
        width: 100%;
    }

    table .span2x {
        float: none;
        margin-left: 0;
        width: 80px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Transaksi Pemakaian <b>Mobil Jenazah</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemakaianambulans-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return cekValidasi();',
                'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '',
                'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''
            ),
            'focus' => '#' . CHtml::activeId($modPemakaian, 'norekammedis'),
        )); ?>

        <?php echo $form->errorSummary($modPemakaian); ?>

        <?php echo CHtml::activeHiddenField($modPemakaian, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modPemakaian, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modPemakaian, 'pesanambulans_t', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <div class="panel panel-success" id="form-datakunjungan">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?>
                </div>
            </div>
            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'format' => $format, 'modPemakaian' => $modPemakaian)); ?>
            </div>
        </div>


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Pemakaian Mobil Jenazah
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="50%">
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Pemakaian Mobil Jenazah', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php $this->widget('MyDateTimePicker', array(
                                        'model' => $modPemakaian,
                                        'attribute' => 'tglpemakaianambulans',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5'),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <?php //echo $form->textFieldRow($modPemakaian,'tglkembaliambulans',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Kembali Mobil Jenazah', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php $this->widget('MyDateTimePicker', array(
                                        'model' => $modPemakaian,
                                        'attribute' => 'tglkembaliambulans',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //                                    'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker2-5'),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemakaian, 'Untuk_keperluan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPemakaian, 'untukkeperluan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    Ruangan <span style="color:red"> * </span>
                                </div>
                                <div class="controls">
                                    <?php echo CHtml::dropDownList(
                                        'instalasi',
                                        $instalasi,
                                        CHtml::listData($modInstalasi, 'instalasi_id', 'instalasi_nama'),
                                        array(
                                            'empty' => '-- Instalasi --',
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' =>  CController::createUrl('dynamicRuangan'),
                                                'update' => '#PJPemakaianambulansT_ruangan_id',
                                            ), 'class' => 'span2 reqPasien'
                                        )
                                    ); ?>
                                    <?php echo CHtml::activeDropDownList($modPemakaian, 'ruangan_id',  CHtml::listData(RuanganM::model()->getRuanganByInstalasi($instalasi), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Ruangan --', 'class' => 'span2 reqPasien')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemakaian, 'tempat_tujuan <span class="required">*</span>', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPemakaian, 'tempattujuan', array('class' => 'span3 reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemakaian, 'alamat_tujuan <span class="required">*</span>', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modPemakaian, 'alamattujuan', array('class' => 'span3 reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php //echo $form->textFieldRow($modPemakaian,'nomobile',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                            ?>
                            <?php //echo $form->textFieldRow($modPemakaian,'notelepon',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                            ?>

                            <?php //echo $form->textFieldRow($modPemakaian,'supir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemakaian, 'supir_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPemakaian, 'supir_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->textField($modPemakaian, 'supir_nama', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                                    <?php
                                    echo CHtml::htmlButton('<i class="entypo-search"></i> <i class="icon-white icon-chevron-right"></i> ', array(
                                        'class' => 'btn btn-search', 'onclick' => "$('#dialogSupir').dialog('open');",
                                        'id' => 'btnAddSupir', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('supir_id')
                                    ))
                                    ?>
                                    <?php echo $form->error($modPemakaian, 'supir_id'); ?>
                                </div>
                            </div>

                            <?php //echo $form->textFieldRow($modPemakaian,'pelaksana_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
                            <div class="control-group">
                                <?php // echo $form->labelEx($modPemakaian, 'pelaksana_id', array('class' => 'control-label')) 
                                ?>
                                <?php echo CHtml::activeLabel($modPemakaian, 'Supir 2', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPemakaian, 'pelaksana_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->textField($modPemakaian, 'pelaksana_nama', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php
                                    echo CHtml::htmlButton('<i class="entypo-search"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                        'class' => 'btn btn-search', 'onclick' => "$('#dialogPelaksana').dialog('open');",
                                        'id' => 'btnAddPelaksana', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('pelaksana_id')
                                    ))
                                    ?>
                                    <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
                                </div>
                            </div>

                            <?php //echo $form->textFieldRow($modPemakaian,'paramedis1_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPemakaian, 'paramedis1_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPemakaian, 'paramedis1_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->textField($modPemakaian, 'paramedis1_nama', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php
                                    echo CHtml::htmlButton('<i class="entypo-search"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                        'class' => 'btn btn-search', 'onclick' => "$('#dialogParamedis').dialog('open');$('#dialogParamedis #paramedisKe').val(1);",
                                        'id' => 'btnAddParamedis1', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('paramedis1_id')
                                    ))
                                    ?>
                                    <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo $form->labelEx($modPemakaian, 'paramedis2_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPemakaian, 'paramedis2_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->textField($modPemakaian, 'paramedis2_nama', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php
                                    echo CHtml::htmlButton('<i class="entypo-search"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                        'class' => 'btn btn-search', 'onclick' => "$('#dialogParamedis').dialog('open');$('#dialogParamedis #paramedisKe').val(2);",
                                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('paramedis2_id')
                                    ))
                                    ?>
                                    <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
                                </div>
                            </div>
                            <?php //echo $form->textFieldRow($modPemakaian,'tglpemakaianambulans',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Penanggung Jawab</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemakaian, 'Nama', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian, 'namapj', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemakaian, 'Hubungan', array('class' => 'control-label refreshable')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPemakaian, 'hubunganpj', LookupM::getItems('hubungankeluarga'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemakaian, 'Alamat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian, 'alamatpj', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemakaian, 'rt_rw', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian, 'rt', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?> /
                            <?php echo $form->textField($modPemakaian, 'rw', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?>
                            <?php echo $form->error($modPemakaian, 'rt_rw'); ?>
                        </div>
                        <?php echo $form->error($modPemakaian, 'rt_rw'); ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Pemakaian Mobil Jenazah
                    </div>
                </div>
                <div class="panel-body">
                    <?php //echo $form->textFieldRow($modPemakaian,'namapj',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                    ?>
                    <?php //echo $form->dropDownListRow($modPemakaian,'hubunganpj', LookupM::getItems('hubungankeluarga'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); 
                    ?>
                    <?php //echo $form->textAreaRow($modPemakaian,'alamatpj',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textAreaRow($modPemakaian,'untukkeperluan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemakaian, 'mobil_Jenazah <span class="required">*</span>', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modPemakaian, 'mobilambulans_id', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textField($modPemakaian, 'mobilambulans_nama', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php
                            echo CHtml::htmlButton('<i class="entypo-search"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                'class' => 'btn btn-search', 'onclick' => "$('#dialogKendaraan').dialog('open');",
                                'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('mobilambulans_id')
                            ))
                            ?>
                            <?php echo $form->error($modPemakaian, 'mobilambulans_id'); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($modPemakaian, 'KM Awal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian, 'kmawal', array('class' => 'span1 number', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->error($modPemakaian, 'kmawal'); ?> sampai dengan <span style="font-size:11px;"><?php echo $modPemakaian->getAttributeLabel('km_akhir'); ?></span>
                            <?php echo $form->textField($modPemakaian, 'kmakhir', array('class' => 'span1 number', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->error($modPemakaian, 'kmakhir'); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modPemakaian,'mobilambulans_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($modPemakaian,'kmawal',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($modPemakaian,'kmakhir',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemakaian, 'Jml bbm liter', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian, 'jmlbbmliter', array('class' => 'span1 number', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <?php
        $visibleTarif = "none";
        $visibleTarifAPI = "none";
        if (!empty($is_api_gmap) && isset($is_api_gmap)) {
            if ($is_api_gmap == 1) {
                $visibleTarif = "none";
                $visibleTarifAPI = "block";
            } else {
                $visibleTarifAPI = "none";
                $visibleTarif = "block";
            }
        } else {
            $visibleTarifAPI = "none";
            $visibleTarif = "block";
        }
        ?>

        <!--<div class="panel panel-success" style="display: <?php // echo $visibleTarif;
                                                                ?>">-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Tarif Mobil Jenazah Berdasarkan Kota Tujuan
                    <?php
                    echo CHtml::htmlButton('<i class="entypo-search"></i> <i class="icon-white icon-chevron-right"></i>', array(
                        'class' => 'btn btn-search', 'onclick' => "$('#dialogTarif').dialog('open');",
                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari Tarif Ambulans'
                    ))
                    ?>
                </div>
            </div>
            <div class="panel-body table-responsive">


                <?php //echo $form->textFieldRow($modPemakaian,'jumlahkm',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modPemakaian,'tarifperkm',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modPemakaian,'totaltarifambulans',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <table id="tblTarifAmbulans" class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="4" style='vertical-align:middle;text-align:center;'>Tujuan</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Jumlah KM</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Tarif / KM</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Biaya Tol</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Total Tarif</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:left;'>Batal</th>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count((array)$tarif['tarifAmbulans']); $i++) : ?>
                            <?php if (!empty($tarif['tarifAmbulans'][$i])) { ?>
                                <tr>
                                    <td><input type="text" value="<?php echo $tarif['propinsi'][$i]; ?>" name="tarif[propinsi][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['kabupaten'][$i]; ?>" name="tarif[kabupaten][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['kecamatan'][$i]; ?>" name="tarif[kecamatan][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['kelurahan'][$i]; ?>" name="tarif[kelurahan][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['jmlKM'][$i]; ?>" name="tarif[jmlKM][]" class="span1 number" />
                                        <input type="hidden" value="<?php echo $tarif['daftartindakanId'][$i]; ?>" name="tarif[daftartindakanId][]" class="span1 number" />
                                    </td>
                                    <td><input type="text" value="<?php echo $tarif['tarifKM'][$i]; ?>" name="tarif[tarifKM][]" class="span1 currency" /></td>
                                    <td><input type="text" value="<?php echo $tarif['biayatol'][$i]; ?>" name="tarif[biayatol][]" class="span1 currency" /></td>
                                    <td><input type="text" value="<?php echo $tarif['tarifAmbulans'][$i]; ?>" name="tarif[tarifAmbulans][]" class="span2 currency" /></td>
                                    <td><i class="icon-form-silang" onclick="batalTarif(this);return false;"></i></td>
                                </tr>
                            <?php } ?>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="panel panel-success" style="display: <?php echo $visibleTarifAPI; ?>">
            <div class="panel-heading">
                <div class="panel-title">Tarif Mobil Jenazah Berdasarkan Peta</div>
            </div>
            <div class="panel-body">
                <!--<h3>Tarif Ambulans-->
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-riwayatpasien',
                    'content' => array(
                        'content-riwayatpasien' => array(
                            'header' => '<b>Rute Tarif Mobil Jenazah</b>',
                            'isi' => $this->renderPartial('_daftarTarifAPI', array('modPemakaian' => $modPemakaian, 'form' => $form), true),
                            'active' => false,
                        ),
                    ),
                ));
                ?>
                </h3>

                <div class="tabelTarifAmbulan" style="oveflow-x:auto;">
                    <table id="tblTarifAmbulansAPI" class="table table-striped">
                        <thead>
                            <tr>
                                <th style='vertical-align:middle;text-align:center;'>Tujuan</th>
                                <th style='vertical-align:middle;text-align:center;'>Jarak</th>
                                <th style='vertical-align:middle;text-align:center;'>Durasi</th>
                                <th style='vertical-align:middle;text-align:center;'>Pelayanan</th>
                                <th style='vertical-align:middle;text-align:center;'>Jasa Sarana</th>
                                <th style='vertical-align:middle;text-align:center;'>Harga BBM</th>
                                <th style='vertical-align:middle;text-align:center;'>BHP</th>
                                <th style='vertical-align:middle;text-align:center;'>Jasa Pengemudi</th>
                                <th style='vertical-align:middle;text-align:center;'>Jasa Pendamping</th>
                                <th style='vertical-align:middle;text-align:center;'>Jasa Dokter</th>
                                <th style='vertical-align:middle;text-align:center;'>Biaya Tol</th>
                                <th style='vertical-align:middle;text-align:center;'>Total Tarif</th>
                                <th style='vertical-align:middle;text-align:left;'>Batal</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Form Pemakaian Bahan
                        </div>
                    </div>
                    <div class="panel-body" id="form-tambahobatalkes">
                        <?php $this->renderPartial('_formPemakaianBahan', array()); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Tabel Pemakaian Bahan <b>dan Alat Kesehatan</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Bahan dan Alat Kesehatan</th>
                                    <th>Satuan Kecil</th>
                                    <th>Stok</th>
                                    <th>Jumlah</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (isset($_GET['sukses']) && $_GET['sukses'] == '1') {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'disabled' => true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            } else {
                //                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                //                                        array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit','disabled'=>(isset($_GET['sukses']))? true : false, 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'disabled' => false, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-cancel"></i>')),
                Yii::app()->createUrl($this->module->id . '/pemakaianMobil/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda ingin mengulang ?') . '")) return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    //$('.number').each(function(){this.value = formatNumber(this.value)});
    //$('.currency').each(function(){this.value = formatNumber(this.value)});
    function clearDataPasien() {
        $("#<?php echo CHtml::activeId($modPemakaian, 'pasien_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modPemakaian, 'norekammedis') ?>").val('');
        $("#<?php echo CHtml::activeId($modPemakaian, 'noidentitas') ?>").val('');
    }

    function cekValidasi() {
        var kosong = '';
        var reqPasien = $("#pemakaianambulans-t-form").find(".reqPasien[value=" + kosong + "]");
        var pasienKosong = reqPasien.length;

        <?php // if(!empty($is_api_gmap) && isset($is_api_gmap) && $is_api_gmap==1){ 
        ?>
        var tarifApi = $("#tblTarifAmbulansAPI > tbody > tr");
        <?php // } else { 
        ?>
        var tarif = $("#tblTarifAmbulans > tbody > tr");
        <?php // } 
        ?>
        var tarifApikosong = tarifApi.length;
        var tarifkosong = tarif.length;
        if (pasienKosong != 0) {
            myAlert('Harap Isi Semua Bagian Yang Bertanda * pada Data Transaksi Pemakaian Mobil Jenazah');
            return false;
        } else {
            if (tarifkosong != 0 || tarifApikosong != 0) {
                $('.currency').each(function() {
                    this.value = unformatNumber(this.value)
                });
                $('.number').each(function() {
                    this.value = unformatNumber(this.value)
                });
                $('.integer2').each(function() {
                    this.value = unformatNumber(this.value)
                });
                $('.integer').each(function() {
                    this.value = unformatNumber(this.value)
                });
                return true;
            } else {
                myAlert('Harap Isi Tarif Mobil Jenazah');
                return false;
            }
        }
        return false;
    }

    function setRuanganPemesan(instalasiasalId, ruanganasalId) {
        $("#instalasi").val(instalasiasalId);
        $("#instalasi").change();
        myAlert('Otomatis mengambil dari instalasi/ruangan/unit pasien terakhir diperiksa');
        $("#<?php echo CHtml::activeId($modPemakaian, 'ruangan_id') ?>").val(ruanganasalId);
    }
</script>

<?php
//========= Dialog buat daftar paramedis  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogParamedis',
    'options' => array(
        'title' => 'Daftar Paramedis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarParamedis');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis =============================
//========= Dialog buat daftar supir  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupir',
    'options' => array(
        'title' => 'Daftar Supir',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarSupir');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar supir =============================
//========= Dialog buat daftar pelaksana  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPelaksana',
    'options' => array(
        'title' => 'Daftar Pelaksana',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarPelaksana');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar pelaksana =============================
//========= Dialog buat daftar ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKendaraan',
    'options' => array(
        'title' => 'Daftar Kendaraan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarKendaraan');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar ambulans =============================
//========= Dialog buat daftar tarif ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTarif',
    'options' => array(
        'title' => 'Daftar Tarif Ambulans',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarTarifAmbulans');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tarif ambulans =============================
?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienJenazah',
    'options' => array(
        'title' => 'Pencarian Jenazah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPasien = new PJPasienM('searchDialog');
$modPasien->unsetAttributes();
if (isset($_GET['PJPasienM'])) {
    $modPasien->attributes = $_GET['PJPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->searchDialog(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
"id" => "selectPasien",
"onClick" => "$(\"#PJPemakaianambulansT_norekammedis\").val(\"$data->no_rekam_medik\");
$(\"#PJPemakaianambulansT_namapasien\").val(\"$data->nama_pasien\");
$(\"#PJPemakaianambulansT_alamattujuan\").val(\"$data->alamat_pasien\");
$(\"#PJPemakaianambulansT_nomobile\").val(\"$data->no_mobile_pasien\");
$(\"#PJPemakaianambulansT_notelepon\").val(\"$data->no_telepon_pasien\");
setDataPasien();
$(\"#dialogPasienJenazah\").dialog(\"close\");    
"))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>
<?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan)); ?>