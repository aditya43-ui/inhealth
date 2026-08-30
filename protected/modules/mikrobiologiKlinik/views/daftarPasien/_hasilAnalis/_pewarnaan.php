<style>
.judul-ab {
    font-weight: bold;
}

.inp-ab {
    margin-left: 20px;
}

.space-ab1 {
    margin-left: 20px;
    margin-right: 20px;
}

.space-ab2 {
    margin-left: 20px;
    margin-right: 20px;
}
</style>

<?php echo $form->errorSummary($pewarnaan); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-book"></i> &nbsp;<b>Pemeriksaan Pewarnaan Langsung</b>
            <?php // echo $form->hiddenField($pewarnaan, 'pemeriksaanpewarnaan_id', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
        </div>
    </div>
    <div class="panel-body" id="">
        <div class="row row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                <label class="control-label">Dokter 1 <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($pewarnaan, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4 required',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter 2</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($pewarnaan, 'dpjp_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Analis</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($pewarnaan, 'perawat_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id in (2, 20) '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Pemeriksaan <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                    
                            $this->widget('MyDateTimePicker', array(
                                'model' => $pewarnaan,
                                'attribute' => 'tgl_pemeriksaan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));

                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Pemeriksaan </label>
                    <div class="controls">
                        <?php echo $form->textField($pewarnaan, 'jenis_pemeriksaan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-fluid">
            <div class="col-sm-12">
                <div class="panel panel-gradient">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <b>Hasil Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row row-fluid">
                            <div class="col-sm-6">
                                <div style="font-weight: bold; font-size: 14px; margin: 10px 0 10px 10px;">Pewarnaan Garam
                                </div>
                                <div class="">
                                    <div class="control-group">
                                        <label class="control-label">&emsp;&emsp;&emsp;&emsp;Sel Epitel </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'sel_epitel_pewarnaan', LookupM::getItems('mikro_sel_epitel'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">&emsp;&emsp;&emsp;&emsp;Sel Radang </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'sel_radang_pewarnaan', LookupM::getItems('mikro_sel_radang'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">&emsp;&emsp;&emsp;&emsp;Mikroorganisme </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'mikroorganisme', LookupM::getItems('mikro_mikroorganisme'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">&nbsp;</label>

                                        <div class="controls">
                                            <?php echo $form->textArea($pewarnaan, 'mikroorganisme_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
                                            <?php
                                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogMikroorganismeKet').dialog('open');",
                                      'id' => 'btnAddMikroorganisme', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                      'rel' => 'tooltip', 'title' => 'Klik untuk menambah rincian mikroorganisme'))
                                ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Pewarnaan Ziehn Nielsen </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'ziehlnielsen_pewarnaan', LookupM::getItems('mikro_nielsen'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Pewarnaan KOH </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'koh_pewarnaan', LookupM::getItems('mikro_nielsen'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Pewarnaan Niesser </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'niesser_pewarnaan', LookupM::getItems('mikro_niesser'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Pewarnaan Negatif </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'negatif_pewarnaan', LookupM::getItems('mikro_negatif'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Pewarnaan Spora </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'spora_pewarnaan', LookupM::getItems('mikro_spora'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Pewarnaan Giemsa </label>
                                        <div class="controls">
                                            <?php echo $form->dropDownList($pewarnaan,'giemsa_pewarnaan', LookupM::getItems('mikro_giemsa'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-gradient" style="width: 104%;">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <b>Saran / Expertise</b>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="control-group">
                                            <label class="control-label">Saran / Expertise</label>
                                            <div class="controls">
                                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $pewarnaan, 'attribute' => 'saran_pewarnaan', 'toolbar' => 'mini', 'height' => '200px')) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row-fluid">
    <div class="form-actions">
        <?php

            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            }       
                
            if (!isset($_GET['pemeriksaanpewarnaan_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Pewarnaan Langsung', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Pewarnaan Langsung', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPewarnaan();return false"));
            }
            
                $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                
    
?>
    </div>
</div>




<?php

/** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMikroorganismeKet',
    'options' => array(
        'title' => 'Pencarian Hasil Pemeriksaan Mikroorganisme',
        'autoOpen' => false,
        'width' => 490,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modMikro = new HasilpemeriksaanmikroM('search');
$modMikro->unsetAttributes();
if (isset($_GET['HasilpemeriksaanmikroM'])) {
    $modMikro->attributes = $_GET['HasilpemeriksaanmikroM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modMikro->search(),
    'filter' => $modMikro,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                            "onclick" => " setKetMikro(\"" . $data->hasilpemeriksaan . "\"); return false; "));
            },
        ),
        array(
            'header' => 'Kelompok Mikroorganisme',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modMikro, 'kelompok_mikroorganisme', array('class' => 'span3')),
            'value' => '$data->kelompok_mikroorganisme',
        ),
        array(
            'header' => 'Hasil Pemeriksaan',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modMikro, 'hasilpemeriksaan', array('class' => 'span3')),
            'value' => '$data->hasilpemeriksaan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>

<?php

/** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBiakan',
    'options' => array(
        'title' => 'Pencarian Hasil Pemeriksaan Mikroorganisme',
        'autoOpen' => false,
        'width' => 490,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modBiakan = new MikroorganismeM('search');
$modBiakan->unsetAttributes();
if (isset($_GET['MikroorganismeM'])) {
    $modBiakan->attributes = $_GET['MikroorganismeM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-biakan-grid',
    'dataProvider' => $modBiakan->search(),
    'filter' => $modBiakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                            "onclick" => " setKetMikro(\"" . $data->hasilpemeriksaan . "\"); return false; "));
            },
        ),
        array(
            'header' => 'Kelompok Mikroorganisme',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modBiakan, 'kelompok_mikroorganisme', array('class' => 'span3')),
            'value' => '$data->kelompok_mikroorganisme',
        ),
        array(
            'header' => 'Nama Mikroorganisme',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modBiakan, 'nama_mikroorganisme', array('class' => 'span3')),
            'value' => '$data->nama_mikroorganisme',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>

<script>
function setKetMikro(ket) {

    console.log('ket mikro: ' + ket);

    var isi = $('#<?= CHtml::activeId($pewarnaan, 'mikroorganisme_ket') ?>').val();

    if (isi === "") {
        $('#<?= CHtml::activeId($pewarnaan, 'mikroorganisme_ket') ?>').val(ket);
    } else {
        var isi_arr = isi.split(', ');
        isi_arr.push(ket);
        var isi_join = isi_arr.join(', ');

        $('#<?= CHtml::activeId($pewarnaan, 'mikroorganisme_ket') ?>').val(isi_join);

    }

    $('#dialogMikroorganismeKet').dialog('close');

}

function setBiakan(ket) {

    var isi = $('<?= CHtml::activeId($pewarnaan, 'biakan_kultur_ket') ?>').val();

    if (isi !== "") {
        $('<?= CHtml::activeId($pewarnaan, 'biakan_kultur_ket') ?>').val(ket);
    } else {
        var isi_arr = isi.split(', ');
        isi_arr.push(ket);
        var isi_join = isi_arr.join(', ');
    }
    $('<?= CHtml::activeId($pewarnaan, 'biakan_kultur_ket') ?>').val(ket);

    $('#dialogBiakan').dialog('close');
}

function printPewarnaan() {
    window.open(
        '<?php echo $this->createUrl('printPewarnaan', array('pemeriksaanpewarnaan_id' => isset($_GET['pemeriksaanpewarnaan_id']) ? $_GET['pemeriksaanpewarnaan_id'] : null)); ?>',
        'printwin', 'left=100,top=100,width=960,height=720');
}


</script>