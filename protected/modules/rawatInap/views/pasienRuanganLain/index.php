<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Pindahan dari Ruangan Lain'
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
        $('#daftarPasien-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Pindahan Dari Ruangan Lain</b>
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
                <?php echo $this->renderPartial('_formPencarian', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Pindahan Dari Ruangan Lain</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchPasienPindahan(),
                    //      'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pendaftaran/<br>No. Pendaftaran',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ ".$data->no_pendaftaran'
                        ),
                        array(
                            'header' => 'Tanggal Masuk',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpindahkamar)'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => '$data->namadepan." ".$data->nama_pasien'
                        ),
                        array(
                            'header' => 'Jenis Kelamin/<br>Umur',
                            'value' => '$data->jeniskelamin."/ ".$data->umur',
                        ),
                        array(
                            'header' => 'Jenis Kasus Penyakit',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'header' => 'Dokter Penerima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->dokterpenerima_id)) return "-";
                                $peg = PegawaiM::model()->findByPk($data->dokterpenerima_id);
                                return $peg->namaLengkap;
                            },
                        ),
                        array(
                            'header' => 'Dokter PJP',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $str = '<ul>';
                                if (!empty($data->pegawai_id)) {
                                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                                    $str .= '<li>' . $peg->namaLengkap . '</li>';
                                }
                                if (!empty($data->dpjp2_id)) {
                                    $peg = PegawaiM::model()->findByPk($data->dpjp2_id);
                                    $str .= '<li>' . $peg->namaLengkap . '</li>';
                                }
                                if (!empty($data->dpjp3_id)) {
                                    $peg = PegawaiM::model()->findByPk($data->dpjp3_id);
                                    $str .= '<li>' . $peg->namaLengkap . '</li>';
                                }
                                $str .= '</ul>';
                                return $str;
                            },
                        ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'header' => 'Ruangan Asal',
                            'name' => 'ruanganasal_nama',
                            'type' => 'raw',
                            'value' => '$data->ruanganasal_nama',
                        ),
                        array(
                            'header' => 'Kamar Ruangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $mkamar = MasukkamarT::model()->find(" pindahkamar_id = " . $data->pindahkamar_id);
                                if (!empty($mkamar)) {
                                    if (!empty($mkamar->kamarruangan_id)) {
                                        return $mkamar->kamarruangan->kamarruangan_nokamar . " - " . $mkamar->kamarruangan->kamarruangan_nobed;
                                    } else {
                                        return '-';
                                    }
                                }
                            } //'$data->kamarruangan_nokamar." - ".$data->kamarruangan_nobed'
                        ),
                        array(
                            'header' => 'Lama Dirawat',
                            'type' => 'raw',
                            'value' => function($data) {
                                if(!empty($data->lamadirawat_kamar)) {
                                    echo $data->lamadirawat_kamar;
                                } else {
                                    echo '0';
                                }
                            }
                        )
                        /*array(
                                                   'header'=>'Masuk Kamar / Batal',
                                                   'type'=>'raw',
                                                   'value'=>'isset($data->masukkamar_id) ? ( isset($data->cekTindakanDanObat()->ada) ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Silakan batalkan dulu ".$data->cekTindakanDanObat()->msg."!")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"{batalPindahKamar($data->pindahkamar_id,$data->masukkamar_id);}"))) : CHtml::link("<i class=icon-home></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}"))',    
                                                ),*/
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
                <!--/div-->
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMasukKamar',
    'options' => array(
        'title' => 'Masuk Kamar Rawat Inap',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 200,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<script>
    function addMasukKamar() {
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('rawatInap/pasienRuanganLain/insertMasukKamar'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $('#dialogMasukKamar div.divForForm form').submit(addMasukKamar);
                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    jQuery('#MasukkamarT_jammasukkamar').timepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy',
                   'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                }
                else
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogMasukKamar').dialog('close') \",1000);
                }
            } ",
        ))
        ?>;
        return false;
    }
</script>
<?php
$urlSessionMasukKamar = Yii::app()->createUrl('rawatInap/pasienRuanganLain/buatSessionMasukKamar ');
$jscript = <<< JS
function buatSessionMasukKamar(kelaspelayanan_id, pendaftaran_id)
{
    $.post("${urlSessionMasukKamar}", { kelaspelayanan_id: kelaspelayanan_id,pendaftaran_id: pendaftaran_id },
        function(data){
            'sukses';
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('jsMasukKamar', $jscript, CClientScript::POS_BEGIN);
?>
<?php
$url = Yii::app()->createUrl('rawatInap/pasienRuanganLain/batalPindahKamar');
$mds = Yii::t('mds', 'Anda yakin akan membatalkan pindah kamar?');
$jscript = <<< JS
function batalPindahKamar(idPindahKamar,idMasukKamar)
{
    if(confirm("${mds}"))
    {
        $.post("${url}", { idPindahKamar: idPindahKamar, idMasukKamar: idMasukKamar },
            function(data){
                if(data.status == 'true')
                {
                    $('#dialogSuksesBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
                else
                {
                    $('#dialogGagalBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
        }, "json");
    }
}
JS;
Yii::app()->clientScript->registerScript('jsBatalPindah', $jscript, CClientScript::POS_BEGIN);
?>