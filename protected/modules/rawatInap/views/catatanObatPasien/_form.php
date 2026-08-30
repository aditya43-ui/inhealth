<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'catatanobatpasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
    ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'ruangan_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<?php echo $form->errorSummary($model); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Catatan Obat</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pemberian</th>
                    <th>Jam Pemberian</th>
                    <th>Nama Obat</th>
                    <th>Jenis Obat</th>
                    <th>Cara </th>
                    <th>Dosis</th>
                    <th>Waktu Pemberian</th>
                    <th>Ubah</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat as $idx => $item): ?>
                <tr>
                    <td><?php echo $idx+1; ?></td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_pemberian); ?></td>
                    <td><?php echo $item->jam_pemberian; ?></td>
                    <td><?php echo empty($item->obatalkes) ? "-" : $item->obatalkes->obatalkes_nama; ?></td>
                    <td><?php echo $item->jenisobat; ?></td>
                    <td><?php echo $item->cara; ?></td>
                    <td><?php echo $item->dosis; ?></td>
                    <td><?php echo $item->waktupemberian; ?></td>
                    <td><?php echo CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('create', array('pendaftaran_id'=>$kunjungan->pendaftaran_id, 'pasienadmisi_id'=>$kunjungan->pasienadmisi_id, 'id'=>$item->catatanobatpasien_id)), array(
                        'rel'=>'tooltip', 'title'=>'Ubah Catatan'
                    )); ?></td>
                    <td><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                        'rel'=>'tooltip', 'title'=>'Hapus Catatan', 'onclick'=>'hapusCatatan('.$item->catatanobatpasien_id.')',
                    )); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row-fluid">
      	<div class="form-actions">
          <?php
                // $cekData = EdukasiterintegrasiT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
                // if(!empty($cekData)){
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','onclick'=>"print('$model->pendaftaran_id','PRINT');return false"));
                // }else{
                //         echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','disabled'=>true));
                // }
          ?>
      	</div>
      </div>
    </div>
</div>



<div class="row-fluid">

    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tgl_pemberian', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_pemberian',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jam_pemberian', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jam_pemberian',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>

    </div>
    <div  class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'waktupemberian', LookupM::getItemsUrutan('waktupemberian'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'petugaspengisi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'petugaspengisi_id', array('id' => 'petugaspengisi_id', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'petugaspengisi_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('autocompletePetugas') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#petugaspengisi_id").val(ui.item.pegawai_id);
                                $("#petugaspengisi_nama").val(ui.item.namaLengkap);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'id' => 'petugaspengisi_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                ));
                ?>
            </div>
        </div>

    </div>

</div>
<br/>
<div class="panel panel-darkk">
    <span class="group-title">
        Data Obat
    </span>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'obatalkes_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'obatalkes_id', array('id' => 'obatalkes_id', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'obatalkes_nama',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('autocompleteObatalkes') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                    $(this).val("");
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    $("#obatalkes_id").val(ui.item.obatalkes_id);
                                    $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                    return false;
                                }',
                        ),
                        'htmlOptions' => array(
                            'id' => 'obatalkes_nama',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3'
                        ),
                            'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                    ));
                    ?>

                </div>
            </div>


            <?php echo $form->dropDownListRow($model, 'jenisobat', LookupM::getItems('jenisobat'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'cara', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'dosis', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
            $this->createUrl('create', array('pendaftaran_id' => $kunjungan->pendaftaran_id, 'pasienadmisi_id' => $kunjungan->pasienadmisi_id)),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
        ?>
        <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan CatatanobatpasienT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));  ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>




<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => false,
    ),
));

$modPetugas = new PegawairuanganV('searchPegawaiMenyetujui');
$modPetugas->unsetAttributes();
$modPetugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPetugas->pegawai_aktif = true;
if (isset($_GET['PegawairuanganV'])) {
    $modPetugas->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPetugas->search(),
    'filter' => $modPetugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#petugaspengisi_id\").val(\"".$data->pegawai_id."\");
                            $(\"#petugaspengisi_nama\").val(\"".$data->namaLengkap."\");
                            $(\"#dialogPegawai\").dialog(\"close\");
                            return false;"
                ))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPetugas, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPetugas, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($jabatan)) {
                    echo $jabatan->jabatan_nama;
                } else {
                    echo "-";
                }
            },
            'filter' => Chtml::dropDownList('PegawairuanganV[jabatan_id]', $modPetugas->jabatan_id, Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '}',
));

$this->endWidget();
?>




<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Obat Alkes Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));
$modObatAlkes = new RIObatalkesM('search');
$modObatAlkes->unsetAttributes();
$modObatAlkes->pendaftaran_id = $kunjungan->pendaftaran_id;
if (isset($_GET['RIObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['RIObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-premedikasi-grid',
    'dataProvider' => $modObatAlkes->searchObatAlkesPasienDijual(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        'obatalkes_kode',
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


<script>

    function hapusCatatan(id) {
        myConfirm("Anda yakin untuk menghapus catatan ini?", "Pertahian", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        window.location.replace('<?php echo $this->createUrl('create', array('pendaftaran_id' => $kunjungan->pendaftaran_id, 'pasienadmisi_id' => $kunjungan->pasienadmisi_id)); ?>');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    function print(pendaftaran_id,caraprint)
    {
    window.open('<?php echo $this->createUrl('printNew'); ?>&pendaftaran_id='+pendaftaran_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }


</script>
