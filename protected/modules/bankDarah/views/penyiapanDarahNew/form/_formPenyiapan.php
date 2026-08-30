<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php

            echo $form->labelEx($model, 'tglpenyiapandarah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpenyiapandarah',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'tglpenyiapandarah'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'ket_penyiapan', array(
            'class' => 'span3',
            'placeholder' => 'Keterangan pengiriman',
        )); ?>
    </div>
</div>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No. Kantong Darah</th>
            <th>Petugas Lab Referal</th>
            <th>Tgl. Referal</th>
            <th>Petugas Pelabelan <i style='color: red'> * </i> </th>
            <th>Tgl. Pelabelan <i style='color: red'> * </i></th>
        </tr>
    </thead>
    <tbody id="tab_penyiapan">
       
    </tbody>
</table>

<script>
    var idx = null;

    function setDialogPetugasReferal(id) {
        idx = id;

        $("#dialogPetugas").dialog("open");
    }

    function setPetugasReferal(data) {
        console.log(idx, 'idx');
        $('#tab_penyiapan tr').each(function(){
            if($(this).data('pemeriksaangoldar') == idx) {
               $(this).find(".peg_referal_id").val(data.pegawai_id);
               $(this).find(".peg_referal_nama").val(data.nama_pegawai);
               $(this).find(".tanggal").show();
            }
        })
      
        $("#PenyiapandarahT_lamapenyiapan_detik").blur();
        $("#dialogPetugas").dialog("close");
        $("#alamatpasien").blur();
    }

    function setDialogPetugasLabeling(id) {
        idx = id;

        $("#dialogPetugasLabeling").dialog("open");
    }

    function setPetugasLabeling(data) {
        $('#tab_penyiapan tr').each(function(){
            if($(this).data('pemeriksaangoldar') == idx) {
               $(this).find(".peg_pelabelan").val(data.pegawai_id);
               $(this).find(".peg_pelabelan_nama").val(data.nama_pegawai);
              
            }
        });
        $
        $("#PenyiapandarahT_lamapenyiapan_detik").blur();
        $("#dialogPetugasLabeling").dialog("close");

        $("#alamatpasien").blur();
    }
</script>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Daftar Petugas Referal',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new BDPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['BDPegawaiM']))
    $modPegawai->attributes = $_GET['BDPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasreferal-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
            "id" => "selectBahan",
            "onClick" => "
                setPetugasReferal(".CJSON::encode($data->attributes).");
                return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugasLabeling',
    'options' => array(
        'title' => 'Daftar Petugas Labeling',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new BDPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['BDPegawaiM']))
    $modPegawai->attributes = $_GET['BDPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugaslabeling-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
            "id" => "selectBahan",
            "onClick" => "
                setPetugasLabeling(".CJSON::encode($data->attributes).");
                return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugasPenerima',
    'options' => array(
        'title' => 'Daftar Petugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new BDPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['BDPegawaiM']))
    $modPegawai->attributes = $_GET['BDPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasterima-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
            "id" => "selectBahan",
            "onClick" => "
                $(\".peg_penerimapermintaan_id\").val(".$data->pegawai_id.");
                $(\"#peg_penerimapermintaan_nama\").val(\"".$data->nama_pegawai."\");
                $(\"#dialogPetugasPenerima\").dialog(\"close\");
                return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>