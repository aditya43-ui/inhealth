<?php $this->breadcrumbs = array(
    'Informasi Pasien yang Dipindahkan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien yang Dipindahkan</b>
        </div>
    </div>
    <div class="panel-body">


        <?php
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
        <?php echo $this->renderPartial('_formPencarian', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien yang Dipindahkan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchPI(),
                    //                'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",

                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Admisi/<br>Tgl. Pindah',
                            'name' => 'tgladmisi',
                            'type' => 'raw',
                            'value' => '$data->TglAdmisiPindahKamar'
                        ),
                        array(
                            'header' => 'Cara Masuk',
                            'name' => 'caramasuk_nama',
                            'type' => 'raw',
                            'value' => '$data->caramasuk_nama',
                        ),
                        array(
                            'header' => 'No. RM/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->noRmNoPend',
                        ),
                        array(
                            'header' => 'Nama Pasien/<br>Alias',
                            'value' => '$data->namaPasienNamaBin'
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'name' => 'jeniskelamin',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'header' => 'Umur',
                            'name' => 'umur',
                            'value' => '$data->umur',
                        ),
                        array(
                            'header' => 'Dokter',
                            'name' => 'Dokter',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'name' => 'kelaspelayanan_nama',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'header' => 'Jenis Kasus Penyakit',
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header' => 'Ruangan Tujuan',
                            'name' => 'ruangan_nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'No. Kamar/<br>No. Bed',
                            'name' => 'kamarruangan_nokamar',
                            'type' => 'raw',
                            'value' => '(!empty($data->kamarruangan_nokamar))? "Kmr : ".$data->kamarruangan_nokamar."<br>"."Bed : ".$data->kamarruangan_nobed.CHtml::link("<i class=icon-form-kamar></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->masukkamar_id,$data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}return false;")) : CHtml::link("<i class=icon-form-kamar></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->masukkamar_id,$data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}return false;"))',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Batal Pindah',
                            'type' => 'raw',
                            'value' => 'isset($data->masukkamar_id) ?	($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Pasien sudah mendapatkan ".$data->TindakanDanObat["msg"]."! Silakan batalkan di Ruangan Tujuan !")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"dialogBatalPindah(".$data->pindahkamar_id.",".$data->masukkamar_id.");"))) :
                                                                                                                                        ($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Pasien sudah mendapatkan ".$data->TindakanDanObat["msg"]."! Silakan batalkan di Ruangan Tujuan !")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"dialogBatalPindah(".$data->pindahkamar_id.");")))',
                            //TANPA CEK TINDAKAN DAN OBAT >> 'value'=>'$data->masukkamar_id ? CHtml::link("Sudah Masuk Kamar", "#",array("title"=>"Silakan hubungi ruangan tujuan untuk membatalkan")) : CHtml::link("<i class=icon-remove-sign></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"{batalPindahKamar($data->pindahkamar_id,$data->masukkamar_id);}"))',    
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),

                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));

                ?>
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk Batal Pindah Kamar =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogSuksesBatalPindah',
    'options' => array(
        'title' => 'Batal Pindah Kamar',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 200,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<span size="5">
    <p><b>Data Berhasil Disimpan</b></p>
</span>
<?php
$this->endWidget();
//========= end Batal Pindah Kamardialog =============================
?>

<?php
// Dialog untuk Batal Pindah Kamar =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogGagalBatalPindah',
    'options' => array(
        'title' => 'Batal Pindah Kamar',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 200,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<span size="5">
    <p><b>Data Gagal Disimpan</b></p>
</span>
<?php
$this->endWidget();
//========= end Batal Pindah Kamardialog =============================
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalPindah',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Pindah Rawat Intensif',
        'autoOpen' => false,
        'zIndex' => 1002,
        'minWidth' => 500,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPindahDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMasukKamar',
    'options' => array(
        'title' => 'Masuk Kamar Rawat Intensif',
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

<?php echo $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<?php
$urlSessionMasukKamar = Yii::app()->createUrl('perawatanIntensif/PasienPindah/buatSessionMasukKamar ');
$jscript = <<< JS
function buatSessionMasukKamar(masukkamar_id,kelaspelayanan_id, pendaftaran_id)
{
    $.post("${urlSessionMasukKamar}", { masukkamar_id: masukkamar_id,kelaspelayanan_id: kelaspelayanan_id,pendaftaran_id: pendaftaran_id },
        function(data){
            'sukses';
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
?>
<script>
    function addMasukKamar() {

        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('perawatanIntensif/PasienPindah/addMasukKamarPI'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $('#dialogMasukKamar div.divForForm form').submit(addMasukKamar);
                    
//                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
//                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy hh:mm:ss','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
//                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
//                    
                    jQuery('#MasukkamarT_jammasukkamar').timepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {
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