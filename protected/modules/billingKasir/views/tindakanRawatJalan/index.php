<?php
if (isset($_GET['sukses']))
    //    Yii::app()->user->setFlash('success',"Data tindakan berhasil disimpan!"); 
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tindakanpelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    //        'focus'=>'#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modTindakan); ?>
<?php
$kelaspelayanan_id = (!empty($modPasienAdmisi->kelaspelayanan_id) ? $modPasienAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id);
$carabayar_id = (!empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id);
$penjamin_id = (!empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
$instalasi_id = (!empty($modPasienAdmisi->ruangan->instalasi_id) ? $modPasienAdmisi->ruangan->instalasi_id : $modPendaftaran->ruangan->instalasi_id);
$instalasi_id = (isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : $instalasi_id); //ditimpa
//            $ruangan_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan_id : $modPendaftaran->ruangan_id);
?>
<div style="display:none;">
    <?php echo Chtml::textField('pendaftaran_id', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('pasienadmisi_id', $modPasienAdmisi->pasienadmisi_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('kelaspelayanan_id', $kelaspelayanan_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('carabayar_id', $carabayar_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('penjamin_id', $penjamin_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('instalasi_id', $instalasi_id, array('readonly' => true)); ?>
    <?php // echo Chtml::textField('ruangan_id',$ruangan_id,array('readonly'=>true)); 
    ?>
</div>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'table-riwayattindakan',
    'content' => array(
        'content-riwayattindakan' => array(
            'header' => '<b>Riwayat Tindakan</b>',
            'isi' => $this->renderPartial($this->path_view . '_tableRiwayatTindakan', array(
                'format' => $format,
                'modRiwayatTindakans' => $modRiwayatTindakans,
                'modPendaftaran' => $modPendaftaran,
            ), true),
            'active' => true,
        ),
    ),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tipe Paket', 'tipepaket_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::dropDownList('tipepaket_id', Params::TIPEPAKET_ID_NONPAKET, (CHtml::listData($modTindakan->getTipePakets(), 'tipepaket_id', 'tipepaket_nama')), array('class' => 'span3', 'onchange' => 'setTabelTindakanReset();')); ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <storng>Tindakan</storng>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table_tindakanpelayanan" class="table table-bordered table-condensed table-striped">
            <thead>
                <th></th>
                <th>No.</th>
                <th>Poliklinik / Ruangan<br>Tanggal Tindakan</th>
                <th>Kategori Tindakan</th>
                <th width="40%">Uraian Tindakan</th>
                <th>Tarif Satuan</th>
                <th>Jumlah</th>
                <th>Satuan Tindakan</th>
                <th>Cyto</th>
                <th>Tarif Cyto</th>
                <th>Jumlah Tarif</th>
                <!-- <th></th> -->
            </thead>
            <tbody>
                <?php
                //                BENTROK DENGAN tr hasil javascript
                //                if (count((array)$dataTindakans) > 0){
                //                    foreach($dataTindakans AS $ii => $tindakan){
                //                         echo $this->renderPartial("_rowTindakan",array('form'=>$form,'modTindakan'=>$tindakan), true); 
                //                    }
                //                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:center;"></td>
                    <td colspan="7" style="text-align:right;"><b>Total Nominal Tarif :</b></td>
                    <td><?php echo CHtml::textField('totaltariftindakan', 0, array('readonly' => true, 'class' => 'integer2', 'style' => 'width:100px;')); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
            'class' => 'btn btn-danger', 'type' => 'button', 'onkeypress' => 'formSubmit(this,event);',
            'onclick' => 'cekValidasi();'
        )); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Ulang', array('{icon}' => '<i class="entypo-print"></i>')), array(
            'class' => 'btn btn-success', 'type' => 'button', 
            'onclick' => 'printUlang(' . $modPendaftaran->pendaftaran_id . ');'
        )); ?>
    </div>
</div>
<script>
    function printUlang(pendaftaran_id)
    {
        window.open('<?php echo $this->createUrl('/rawatJalan/tindakan/printUlangTindakan'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=1080,height=640');
    }
</script>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('form' => $form, 'modTindakan' => $modTindakan)); ?>
<?php $this->endWidget(); ?>

<div style="display: none;">
    <?php
    //hanya untuk memanggil asset dari jquery date
    $this->widget('MyDateTimePicker', array(
        'name' => 'untukmemanggilassetjs',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeyup' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_tindakan',
        'options' => array(
            'title' => 'Daftar Tindakan ' . (InstalasiM::model()->findByPk($instalasi_id)->instalasi_nama),
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
echo CHtml::hiddenField('tindakan_untuk', 0, array('readonly' => true));
$modDaftarTindakan = new BKTariftindakanperdaruanganV('search');
$modDaftarTindakan->unsetAttributes();
// $modDaftarTindakan->ruangan_id = $modPendaftaran->ruangan_id; //default
$modDaftarTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id; //default
$modDaftarTindakan->penjamin_id = $modPendaftaran->penjamin_id; //default
if (isset($_GET['BKTariftindakanperdaruanganV'])) {
    $modDaftarTindakan->attributes = $_GET['BKTariftindakanperdaruanganV'];
    $modDaftarTindakan->tipepaket_id = $_GET['BKTariftindakanperdaruanganV']['tipepaket_id'];
    $modDaftarTindakan->pendaftaran_id = (!empty($_GET['BKTariftindakanperdaruanganV']['pendaftaran_id'])?$_GET['BKTariftindakanperdaruanganV']['pendaftaran_id']:null);
    $modDaftarTindakan->pasienadmisi_id = (!empty($_GET['BKTariftindakanperdaruanganV']['pasienadmisi_id'])?$_GET['BKTariftindakanperdaruanganV']['pasienadmisi_id']:null);
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'daftartindakan-grid',
        'dataProvider' => $modDaftarTindakan->searchDialog(),
        'filter' => $modDaftarTindakan,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihTindakan(\"$data->daftartindakan_id\",\"$data->daftartindakan_nama\",\"$data->kategoritindakan_nama\",\"$data->harga_tariftindakan\",\"$data->jenistarif_id\",\"$data->persencyto_tind\",\"$data->kelompoktindakan_id\");
                    $(\"#dialog_tindakan\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modDaftarTindakan, 'ruangan_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'kelaspelayanan_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'penjamin_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'tipepaket_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'pendaftaran_id', array('readonly' => true))
                    . CHtml::activeHiddenField($modDaftarTindakan, 'pasienadmisi_id', array('readonly' => true)),
            ),
            'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',
            array(
                'header' => 'Harga Nominal Tarif (Rp)',
                'name' => 'harga_tariftindakan',
                'type' => 'raw',
                'value' => 'MyFormatter::formatNumberForPrint($data->harga_tariftindakan)',
                'filter' => false,
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'persencyto_tind',
                'type' => 'raw',
                'value' => 'MyFormatter::formatNumberForPrint($data->persencyto_tind)',
                'filter' => false,
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_dokter',
        'options' => array(
            'title' => 'Dokter',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
echo CHtml::hiddenField('dokter_untuk', "", array('readonly' => true));
$modDokter = new BKDokterV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = $modPendaftaran->ruangan_id; //default
if (isset($_GET['BKDokterV'])) {
    $modDokter->attributes = $_GET['BKDokterV'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'dokter-grid',
        'dataProvider' => $modDokter->searchDialog(),
        'filter' => $modDokter,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihDokter(\"$data->pegawai_id\",\"$data->NamaLengkap\");
                    $(\"#dialog_dokter\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modDokter, 'ruangan_id', array('readonly' => true)),
            ),
            //'gelardepan',
            array(
                'name' => 'nama_pegawai',
                'value' => '$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
            ),
            array(
                'name' => 'jabatan_id',
                'type' => 'raw',
                'value' => function ($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    return $j->jabatan_nama;
                },
                'filter' => CHtml::activeDropDownList(
                    $modDokter,
                    'jabatan_id',
                    CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            //'gelarbelakang_nama',
            'jeniskelamin',
            // 'agama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>





<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_perawat',
        'options' => array(
            'title' => 'Perawat / Paramedis',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
// echo CHtml::hiddenField('dokter_untuk',"",array('readonly'=>true));
$modDokter = new PegawairuanganV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = $modPendaftaran->ruangan_id; //default
$modDokter->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
$modDokter->pegawai_aktif = true;
if (isset($_GET['PegawairuanganV'])) {
    $modDokter->attributes = $_GET['PegawairuanganV'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'perawat-grid',
        'dataProvider' => $modDokter->search(),
        'filter' => $modDokter,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihDokter(\"$data->pegawai_id\",\"$data->NamaLengkap\");
                    $(\"#dialog_perawat\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modDokter, 'ruangan_id', array('readonly' => true)),
            ),
            //'gelardepan',
            array(
                'name' => 'nama_pegawai',
                'value' => '$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
            ),
            array(
                'name' => 'jabatan_id',
                'type' => 'raw',
                'value' => function ($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    return $j->jabatan_nama;
                },
                'filter' => CHtml::activeDropDownList(
                    $modDokter,
                    'jabatan_id',
                    CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            //'gelarbelakang_nama',
            'jeniskelamin',
            // 'agama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialog_bidan',
        'options' => array(
            'title' => 'Bidan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
// echo CHtml::hiddenField('dokter_untuk',"",array('readonly'=>true));
$modDokter = new PegawaiM('search');
$modDokter->unsetAttributes();
$modDokter->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_BIDAN;
$modDokter->pegawai_aktif = true;
if (isset($_GET['PegawaiM'])) {
    $modDokter->attributes = $_GET['PegawaiM'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'bidan-grid',
        'dataProvider' => $modDokter->search(),
        'filter' => $modDokter,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                    . '"onClick" => "pilihDokter(\"$data->pegawai_id\",\"$data->NamaLengkap\");
                    $(\"#dialog_bidan\").dialog(\"close\");
                    return false;"))',
                'filter' =>
                CHtml::activeHiddenField($modDokter, 'ruangan_id', array('readonly' => true)),
            ),
            //'gelardepan',
            array(
                'name' => 'nama_pegawai',
                'value' => '$data->namaLengkap',
            ),
            array(
                'name' => 'jabatan_id',
                'type' => 'raw',
                'value' => function ($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    return $j->jabatan_nama;
                },
                'filter' => CHtml::activeDropDownList(
                    $modDokter,
                    'jabatan_id',
                    CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            //'gelarbelakang_nama',
            'jeniskelamin',
            // 'agama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//========= Dialog buat cari supir =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupir',
    'options' => array(
        'title' => 'Pencarian Supir',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$dtSupir = new PegawaiV();
$dtSupir->unsetAttributes();
//  $datPerawat->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
$dtSupir->jabatan_id = Params::getPegSupirByJab();
if (isset($_GET['PegawaiV'])) {
    $dtSupir->attributes = $_GET['PegawaiV'];
}
$provider = $dtSupir->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'supir-v-grid2',
    'dataProvider' => $provider,
    'filter' => $modTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectSupir",
                                    "onClick" => "pilihDokter(\"$data->pegawai_id\",\"$data->NamaLengkap\");
                    $(\"#dialogSupir\").dialog(\"close\");
                    return false;"))',
            //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            //                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data supir =============================

?>