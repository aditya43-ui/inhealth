<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Pindah ke Ruangan Lain'
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
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Yang di Pindahkan Ke Ruangan Lain</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Yang di Pindahkan Ke Ruangan Lain</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchPasienYangDipindahkan(),
                    //                'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pendaftaran/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->TglNoPendaftaran',
                        ),
                        array(
                            'header' => 'Tanggal Pindah',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpindahkamar)'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'value' => '$data->no_rekam_medik'
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
                            'header' => 'Ruangan Tujuan',
                            //                  'name'=>'ruangan_nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Kamar Ruangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $pkamar = PindahkamarT::model()->findByPk($data->pindahkamar_id);
                                if (!empty($pkamar)) {
                                    if (!empty($pkamar->kamarruangan_id)) {
                                        return $pkamar->kamarruangan->kamarruangan_nokamar . " - " . $pkamar->kamarruangan->kamarruangan_nobed;
                                    } else {
                                        $mkamar = MasukkamarT::model()->findByPk($pkamar->masukkamar_id);
                                        if (!empty($mkamar->kamarruangan_id)) {
                                            return $mkamar->kamarruangan->kamarruangan_nokamar . " - " . $mkamar->kamarruangan->kamarruangan_nobed;
                                        } else {
                                            return '-';
                                        }
                                    }
                                }
                            } //'$data->kamarruangan_nokamar." - ".$data->kamarruangan_nobed'
                        ),
                        /* array(
                                                                    'header'=>'Batal Pindah',
                                                                    'type'=>'raw',
                                                                    'value'=>'isset($data->masukkamar_id) ?	($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Pasien sudah mendapatkan ".$data->TindakanDanObat["msg"]."! Silakan batalkan di Ruangan Tujuan !")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"batalPindahKamar(".$data->pindahkamar_id.",".$data->masukkamar_id.");"))) :
                                                                                                                                                                             ($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Pasien sudah mendapatkan ".$data->TindakanDanObat["msg"]."! Silakan batalkan di Ruangan Tujuan !")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"batalPindahKamar(".$data->pindahkamar_id.");")))',
                                                                    //TANPA CEK TINDAKAN DAN OBAT >> 'value'=>'$data->masukkamar_id ? CHtml::link("Sudah Masuk Kamar", "#",array("title"=>"Silakan hubungi ruangan tujuan untuk membatalkan")) : CHtml::link("<i class=icon-remove-sign></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"{batalPindahKamar($data->pindahkamar_id,$data->masukkamar_id);}"))',    
                                                                    'htmlOptions'=>array('style'=>'text-align:left;'),
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
$url = $this->createUrl('BatalPindahKamar');
$mds = Yii::t('mds', 'Anda yakin akan membatalkan pindah kamar?');
$jscript = <<< JS
function batalPindahKamar(idPindahKamar,idMasukKamar=null)
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