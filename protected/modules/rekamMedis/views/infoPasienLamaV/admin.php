<?php
$this->breadcrumbs = array(
    'Informasi Pasien Lama',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#rminfo-pasien-lama-v-search').submit(function(){
	$.fn.yiiGridView.update('rminfo-pasien-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data janji poliklinik berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Lama</b>
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
                <?php $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Lama</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'rminfo-pasien-v-grid',
                    'dataProvider' => $model->searchDataPasien(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'replaceUrl' => true,
                    'mergeHeaders' => array(
                        array(
                            'name' => 'Ubah',
                            'start' => 8, //indeks kolom 3
                            'end' => 9, //indeks kolom 4
                        ),
                    ),
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        //		'pasien_id',
                        //		'jenisidentitas',
                        //		'no_identitas_pasien',
                        //		'namadepan',
                        //		'nama_pasien',
                        //		'nama_bin',
                        array(
                            'header' => 'Instalasi/<br>Tanggal Pendaftaran',
                            'type' => 'raw',
                            'value' => '"$data->instalasi_nama"." / ".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
                        array(
                            'header' => 'Ruangan/<br>Poliklinik',
                            'type' => 'raw',
                            'value' => '((!empty($data->ruangan_nama)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->ruangan_nama,"javascript:gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\'$data->nama_pasien\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Poliklinik")) : $data->ruangan_nama) ',
                        ),
                        array(
                            'header' => 'No. Rekam Medik/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '"$data->no_rekam_medik"." / ".(!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-form-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Print Lembar Poli")) : "-") ',
                            'htmlOptions' => array('style' => 'text-align: left; width:120px')
                        ),
                        array(
                            'header' => 'Nama Pasien/<br>Alias',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->nama_pasien, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))',
                        ),
                        array(
                            'header' => 'Jenis Kelamin/<br>Umur',
                            'type' => 'raw',
                            'value' => '"$data->jeniskelamin"." / "."$data->umur"',
                        ),
                        array(
                            'header' => 'Alamat',
                            'type' => 'raw',
                            'value' => '"$data->alamat_pasien"." / "."$data->rt"."/"."$data->rw"',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'type' => 'raw',
                            //                        'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->CaraBayarPenjamin," ",array("onclick"=>"ubahCaraBayar(\'$data->nama_pasien\');listCaraBayar(\'$data->carabayar_id\');setIdPendaftaran(\'$data->pendaftaran_id\',\'$data->no_pendaftaran\');$(\'#carabayardialog\').dialog(\'open\');return false;",
                            'value' => '((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->CaraBayarPenjamin," ",array("onclick"=>"ubahCaraBayar(\'$data->pendaftaran_id\',\'$data->nama_pasien\');$(\'#carabayardialog\').dialog(\'open\');return false;",
                                                                                                                                                                 "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Jenis Penjamin & Penjamin pasien")) : $data->CaraBayarPenjamin) ',
                        ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '"$data->kelaspelayanan_nama"',
                        ),
                        array(
                            'header' => 'Penanggung Jawab',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => '(!empty($data->penanggungjawab_id) ? CHtml::link($data->pj->nama_pj, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab"))." ".CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab")) : CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPenanggungJawab", array("pendaftaran_id"=>$data->pendaftaran_id)), array("rel"=>"tooltip","title"=>"Klik untuk menambah data penanggung jawab"))) ',
                        ),
                        array(
                            'header' => 'Rujukan',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => '(!empty($data->asalrujukan_id) ? CHtml::link($data->asalrujukan->asalrujukan_nama, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahRujukan",array("id"=>"$data->asalrujukan_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data rujukan"))." ".CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahRujukan",array("id"=>"$data->asalrujukan_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data Rujukan")) : "-") ',
                        ),
                        array(
                            'header' => 'Riwayat Pasien',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-riwayatpasien\'></i>",Yii::app()->createUrl(\'rekamMedis/infoPasienLamaV/getRiwayatPasien&id=\'.$data->pasien_id),array("rel"=>"tooltip","title"=>"Klik untuk Riwayat Kunjungan Pasien")) ',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view_pasienbaru . "_jsFunctions"); ?>
<script type="text/javascript">
    function listCaraBayar(idCaraBayar) {
        $('#carabayardialog #tempCaraBayarId').val(idCaraBayar);
        return false;
    }

    function setIdPendaftaran(pendaftaran_id, noPendaftaran) {
        $('#carabayardialog #tempPendaftaranId').val(pendaftaran_id);
        $('#carabayardialog #tempNoPendaftaran').val(noPendaftaran);
    }

    function ubahKelasPelayanan(namaPasien) {
        $('#titleNamaPasienKelasPelayanan').html(namaPasien);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('ubahKelasPelayanan') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#kelaspelayanandialog div.divForFormKelasPelayanan').html(data.div);
                    $('#kelaspelayanandialog div.divForFormKelasPelayanan form').submit(ubahKelasPelayanan);
                } else {
                    $('#kelaspelayanandialog div.divForFormKelasPelayanan').html(data.div);
                    $.fn.yiiGridView.update('RKInfoPasienBaru-v', {
                        data: $(this).serialize()
                    });
                    setTimeout("$('#kelaspelayanandialog').dialog('close') ", 500);
                }
            },
            'cache': false
        });
        return false;
    }

    function listKelasPelayanan(idKelasPelayanan) {
        $('#kelaspelayanandialog #tempKelasPelayananId').val(idKelasPelayanan);
        return false;
    }
    //function setIdPendaftaran(pendaftaran_id,noPendaftaran)
    //{
    //    $('#kelaspelayanandialog #tempPendaftaranId').val(pendaftaran_id);
    //    $('#kelaspelayanandialog #tempNoPendaftaran').val(noPendaftaran);
    //}
</script>
<?php
//========================================= Jenis Penjamin dialog =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'carabayardialog',
    'options' => array(
        'title' => 'Ganti Jenis Penjamin dan Penjamin <span id="titleNamaPasienCaraBayar"></span>',
        'autoOpen' => false,
        'minWidth' => 400,
        'modal' => true,
        'resizable' => false,
        //'hide'=>explode,
    ),
));
echo CHtml::hiddenField('tempCaraBayarId', '', array('readonly' => true));
echo CHtml::hiddenField('tempPendaftaranId', '', array('readonly' => true));
echo CHtml::hiddenField('tempNoPendaftaran', '', array('readonly' => true));
echo '<div class="divForFormUbahCaraBayar"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========================================================= end cara bayar dialog =========
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'kelaspelayanandialog',
    'options' => array(
        'title' => 'Ganti Kelas Pelayanan - <span id="titleNamaPasienKelasPelayanan"></span>',
        'autoOpen' => false,
        'minWidth' => 400,
        'modal' => true,
        'resizable' => false,
        //'hide'=>explode,
    ),
));
echo CHtml::hiddenField('tempKelasPelayananId', '', array('readonly' => true));
echo CHtml::hiddenField('tempPendaftaranId', '', array('readonly' => true));
echo CHtml::hiddenField('tempNoPendaftaran', '', array('readonly' => true));
echo '<div class="divForFormKelasPelayanan"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========================================================= end cara bayar dialog =========
//=============================== Ganti Poli Dialog =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'ganti_poli',
    'options' => array(
        'title' => 'Ganti Ruangan Pasien - <span id="titleNamaPasien"></span>',
        'autoOpen' => false,
        'minWidth' => 260,
        'height' => 300,
        'modal' => true,
    ),
));
?>
<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Poliklinik</label>
        <div class="controls">
            <?php echo CHtml::dropDownList('ruangan_sebelumnya', '', array(), array('disabled' => true)); ?>
            <?php echo CHtml::hiddenField('ruangan_awal', '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Alasan Perubahan</label>
        <div class="controls">
            <td><?php echo CHtml::textArea('alasanperubahan', '', array('placeholder' => 'Alasan Perubahan',)); ?></td>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Menjadi Poliklinik</label>
        <div class="controls">
            <td><?php echo CHtml::dropDownList('ruangan_id_ganti', 'ruangan_id_ganti', array(), array('empty' => '-- Pilih --',)); ?></td>
        </div>
    </div>
    <?php
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanRuanganBaru();')
    );
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => '$(\'#ganti_poli\').dialog(\'close\');')
    );
    ?>
</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//================================ end Ganti Ruangan Dialog =================================
/*//=============================== Ganti Poli Dialog =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'kelaspelayanan_id',
    'options'=>array(
        'title'=>'Ganti Kelas Pelayanan - <span id="titleNamaPasien"></span>',
        'autoOpen'=>false,
        'minWidth'=>400,
        'modal'=>true,
    ),
));
?>
<table>
    <tr>
        <td>Kelas Pelayanan</td>
        <td>:</td>
        <td>
            <?php echo CHtml::dropDownList('kelas_sebelumnya','', array(),array('disabled'=>true));?>
            <?php echo CHtml::hiddenField('kelas_awal','',array('readonly'=>true));?>
        </td>
    </tr>
    <tr>
        <td>Alasan Perubahan <span class="required">*</span></td>
        <td>:</td>
        <td><?php echo CHtml::textArea('alasanperubahan','', array());?></td>
    </tr>
    <tr>
        <td>Menjadi Kelas</td>
        <td>:</td>
        <td><?php echo CHtml::dropDownList('kelaspelayanan_id_ganti','ruangan_id_ganti', array(),array('empty'=>'-- Pilih --',));?></td>
    </tr>
</table>
<?php
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');
echo CHtml::htmlButton(Yii::t('mds','{icon} Ya',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'simpanRuanganBaru();'));
echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-cancel"></i>')),
                                                array('class' => 'btn btn-default', 'type'=>'button','onclick'=>'$(\'#ganti_poli\').dialog(\'close\');'));
$this->endWidget('zii.widgets.jui.CJuiDialog');*/
//================================ end Ganti Ruangan Dialog =================================
//======================================================JAVA SCRIPT===================================================                          
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printStatus', array('pendaftaran_id' => ''));
$urlPrintKartuPasien = Yii::app()->createUrl('print/kartuPasien', array('pendaftaran_id' => ''));
$urlListDokterRuangan = $this->createUrl('listDokterRuangan');
$urlGetRuangan = Yii::app()->createUrl('rekamMedis/InfoPasienLamaV/GetRuanganPasien');
$simpanRuanganBaru = Yii::app()->createUrl('rekamMedis/InfoPasienLamaV/SaveRuanganBaru');
$statusPeriksaBatalPeriksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
$js = <<< JSCRIPT
//=======================================Awal Print Lembar Poli==========================================================
function print(pendaftaran_id)
{
   window.open('${urlPrintLembarPoli}'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');    
}
//========================================Akhir Print Lembar Poli========================================================
//========================================Awal Ganti Ruangan=============================================================
function gantiPoli(pendaftaran_id,ruangan_id,instalasi_id,pasien_id,namaPasien)
    {
        $('#titleNamaPasien').html(namaPasien);
           $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, instalasi_id:instalasi_id, pasien_id:pasien_id},
           function(data){
            $('#ganti_poli').dialog('open');
            $('#ganti_poli #ruangan_awal').val(ruangan_id);
            $('#ganti_poli #ruangan_sebelumnya').html(data.dropDown);
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #pendaftaran_id').val(pendaftaran_id);
            $('#ganti_poli #pasien_id').val(pasien_id);
        }, "json");
    }
 function simpanRuanganBaru()
    {
        if($('#ganti_poli #alasanperubahan').val()==''){
           myAlert('Alasan Perubahan tidak boleh kosong!');
           $('#ganti_poli #alasanperubahan').addClass('error');
           return false;
        }
        $('#ganti_poli').dialog('close');
        var pendaftaran_id= $('#ganti_poli #pendaftaran_id').val();
        var pasien_id= $('#ganti_poli #pasien_id').val();
        var ruangan_id= $('#ganti_poli #ruangan_id_ganti').val();
        var ruangan_awal= $('#ganti_poli #ruangan_awal').val();
        var alasan = $('#ganti_poli #alasanperubahan').val();
        $.post("${simpanRuanganBaru}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, ruangan_awal: ruangan_awal, alasan:alasan, pasien_id:pasien_id},
            function(data){
                if(data.status=='Gagal')
                    myAlert(data.status);
                $.fn.yiiGridView.update('rminfo-pasien-v-grid', {
                            data: $('#formCari').serialize()
                });
            }, "json");
    }
//========================================Akhir Ganti Ruangan===========================================================
JSCRIPT;
Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD);
$js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";
if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}
if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>