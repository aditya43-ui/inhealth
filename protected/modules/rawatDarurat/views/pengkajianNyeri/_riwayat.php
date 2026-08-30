<?php
$mod = new PengkajiannyeriT;
$mod->pasien_id = $model->pendaftaran->pasien_id;
$mod->tgl_awal_kaji = $mod->tgl_awal_daftar = date('Y-m-d', strtotime('-1 week'));
$mod->tgl_akhir_kaji = $mod->tgl_akhir_daftar = date('Y-m-d');

if (isset($_GET['PengkajiannyeriT'])) {
    $mod->attributes = $_GET['PengkajiannyeriT'];

    $mod->tgl_awal_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_awal_kaji']);
    $mod->tgl_akhir_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_akhir_kaji']);
    
    if (isset($_GET['PengkajiannyeriT']['is_ceklis']) && $_GET['PengkajiannyeriT']['is_ceklis'] == 1) {
        $mod->is_ceklis = $_GET['PengkajiannyeriT']['is_ceklis'];
        $mod->tgl_awal_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_awal_daftar']);
        $mod->tgl_akhir_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_akhir_daftar']);
    }
}
?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">
        <form id="searchRiwayat" class="form-horizontal">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tanggal Pengkajian", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($mod->tgl_awal_kaji)) ?>" data-end-date="<?php echo date('d M Y', strtotime($mod->tgl_akhir_kaji)) ?>">
                            <i class="entypo-calendar"></i>
                            <span ><?php echo date('d M Y', strtotime($mod->tgl_awal_kaji)) ?> - <?php echo date('d M Y', strtotime($mod->tgl_akhir_kaji)) ?></span>
                            <?php echo CHtml::activeHiddenField($mod, 'tgl_awal_kaji', array('class' => 'start')) ?>
                            <?php echo CHtml::activeHiddenField($mod, 'tgl_akhir_kaji', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label(CHtml::activeCheckBox($mod, 'is_ceklis') . " Tanggal Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($mod->tgl_awal_daftar)) ?>" data-end-date="<?php echo date('d M Y', strtotime($mod->tgl_akhir_daftar)) ?>">
                            <i class="entypo-calendar"></i>
                            <span ><?php echo date('d M Y', strtotime($mod->tgl_awal_daftar)) ?> - <?php echo date('d M Y', strtotime($mod->tgl_akhir_daftar)) ?></span>
                            <?php echo CHtml::activeHiddenField($mod, 'tgl_awal_daftar', array('class' => 'start')) ?>
                            <?php echo CHtml::activeHiddenField($mod, 'tgl_akhir_daftar', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $criIns = new CDbCriteria();
                        $criIns->addCondition(" instalasi_aktif = TRUE ");
                        $criIns->order = " instalasi_nama ASC ";
                        echo CHtml::activeDropDownList($mod, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'), array(
                            'id'=>'search_instalasi_id', 'class' => 'span3', 'empty'=>'-- Pilih --', 'onchange'=>'setRuanganMulti();'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                    <div class="controls">												 
                        <?php
                        echo CHtml::activeDropDownList($mod, 'ruangan_id',
                            CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by instalasi_id, ruangan_nama'), 'ruangan_id', 'ruangan_nama'),
                            array('id'=>'search_ruangan_id', 'class' => 'form-control', 'multiple' => 'multiple'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_cari'));
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) $("#searchRiwayat").reset(); }); return false;'));  
            ?>
        </div>
        </form>
    </div>
</div>
<br/>

<?php
$skoring = array(
    "wbs" => "Wong Baker Faces Pain Scale",
    "flaccs" => "Skala FLACCS",
    "nrs" => "Numerical Rating Scale (NRS)",
    "vas" => "Visual Analog Scale (VAS)",
    "bps_tanpaventilator" => "Behavioural Pain Scale Tanpa Ventilator",
    "bps_ventilator" => "Behavioural Pain Scale Ventilator",
    "nips" => "Neonatal Infant Pain Score",
);
$prov = $mod->search();
$prov->sort->defaultOrder = 'waktupengkajian desc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pengkajian-nyeri-grid',
    'enableSorting' => false,
    'dataProvider' => $prov,
    'template' => '{summary}{items}{pager}',
    'itemsCssClass' => 'table table-bordered table-condensed',
    'htmlOptions' => array(
        'style' => 'width: 100%;',
    ),
    'columns' => array(
        array(
            'header' => 'Tanggal Pendaftaran/<br/>No. Pendaftran',
            'type' => 'raw',
            'value' => function($data) {
                $d = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                return MyFormatter::formatDateTimeForUser($d->tgl_pendaftaran) . "/<br/>" . $d->no_pendaftaran;
            }
        ),
        array(
            'header' => 'Instalasi/<br/>Ruangan',
            'type' => 'raw',
            'value' => function($data) {
                $ruangan = RuanganM::model()->findByPk($data->ruangan_id);
                return $ruangan->ruangan_nama . "/<br/>" . $ruangan->instalasi->instalasi_nama;
            }
        ),
        array(
            'header' => 'Waktu<br/>Tanggal/Jam',
            'type' => 'raw',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->waktupengkajian))) . "/" . date('H:i:s', strtotime($data->waktupengkajian));
            }
        ),
        array(
            'header' => 'Nama, Profesi, dan TTD',
            'type' => 'raw',
            'value' => function($data) {
                $peg = PegawaiM::model()->findByPk($data->petugaspengkaji_id);
                $jenis = JenistenagamedisM::model()->findByPk($peg->jenistenagamedis_id);
                
                $str = $peg->namaLengkap;
                
                if (!$data->isverifikasipetugas) {
                    $str .= CHtml::link('<i class="icon-form-verifikasi"></i>', 'javascript:void(0)', array(
                        'onclick'=>"verifikasiNyeri(".$data->pengkajiannyeri_id.", '".$peg->namaLengkap."'); return false;",
                    ));
                } else {
                    $alert_msg = "Sudah diverifikasi oleh \\n ".$peg->namaLengkap."\\n"
                        .(empty($jenis) ? "" : $jenis->tenagamedis_nama)."\\n"
                        ."Tanggal : ".MyFormatter::formatDateTimeForUser($data->verifikasipetugas_tanggal)."\\n"
                        ."Catatan : ".$data->verifikasipetugas_catatan;
                    $str .= CHtml::link('<i class="icon-form-verifikasi"></i>', '#', array(
                        'onclick'=>"myAlert('".$alert_msg."'); return false;",
                    ));
                }
                

                return $str;
            }
        ),
        array(
            'header' => 'Sistem Skoring',
            'type' => 'raw',
            'value' => function($data) use ($skoring) {
                return empty($data->sistemskoring) ? "-" : $skoring[$data->sistemskoring];
            }
        ),
        array(
            'header' => 'Skala Nyeri',
            'type' => 'raw',
            'value' => function($data) {
                return $data->skalanyeri . " : " . $data->keterangan_skalanyeri;
            }
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value'=>function($data) {
                    return CHtml::link('<i class="entypo-eye" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('view', array(
                        'pendaftaran_id'=>$data->pendaftaran_id,
                        'id'=>$data->pengkajiannyeri_id,
                        'type'=>(!empty($_GET['type'])?$_GET['type']:"")
                    )));
            },
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value'=>function($data) {
                if($data->ruangan_id==Yii::app()->user->getState('ruangan_id')){
                    return CHtml::link('<i class="entypo-pencil" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('create', array(
                        'pendaftaran_id'=>$data->pendaftaran_id,
                        'id'=>$data->pengkajiannyeri_id,
                        'type'=>(!empty($_GET['type'])?$_GET['type']:"")
                    )));
                }else{
                    return "";
                }

            },
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value'=>function($data) {
                if($data->ruangan_id==Yii::app()->user->getState('ruangan_id')){
                     return CHtml::link('<i class="entypo-trash" style="font-size:14pt"></i>', '#', array(
                        'onclick'=>'hapusRiwayatPengkajianNyeri('.$data->pengkajiannyeri_id.'); return false'
                    ));
                }else{
                    return "";
                }
            },
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        ),
    ),
));
?>
<br/>
<div class="row-fluid">
    <div class="pull-right">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak Riwayat Pengkajian Nyeri',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'onclick'=>"printPengkajian(".$model->pendaftaran->pasien_id.", 'PRINT');")); ?>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogVerifikasi',
    'options' => array(
        'title' => 'Verifikasi Petugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 300,
        'resizable' => false,
    ),
));
?>


<form class="form-horizontal" id="form_verifikasi">
    <div class="control-group">
        <label class="control-label">Petugas</label>
        <div class="controls">
            <?php echo Chtml::hiddenField('verifikasi[nyeri_id]', '', array(
                'id'=>'verifikiasi_nyeri_id',
            )); ?>
            <?php echo CHtml::textField('verifikasi[petugaspengkaji_nama]', '', array(
                'id'=>'verifikiasi_petugaspengkaji_nama',
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tgl. Verifikasi</label>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker',array(
                'name'=>'verifikasi[verifikasipetugas_tanggal]',
                'value'=> MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')),
                'mode'=>'datetime',
                'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 verifikasi_verifikasipetugas_tanggal span3','onclick'=>"return $(this).focusNextInputField(event)", "id"=>"verifikasi_verifikasipetugas_tanggal"),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Catatan</label>
        <div class="controls">
            <?php echo CHtml::textArea('verifikasi[verifikasipetugas_catatan]', '', array(
                'id'=>'verifikasi_verifikasipetugas_catatan',
            )); ?>
        </div>
    </div>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Verifikasi Pengkajian Nyeri',array('{icon}'=>'<i class="icon-check icon-white"></i>')),array('class'=>'btn btn-primary', 'onclick'=>'submitVerifikasi();')); ?>
    </div>
    
</form>


<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); ?>
<script>
    
    
    function verifikasiNyeri(id, namaPegawai) {
        $("#form_verifikasi :input").val("");
        $("#form_verifikasi #verifikiasi_nyeri_id").val(id);
        $("#form_verifikasi #verifikasi_verifikasipetugas_tanggal").val(date_time_get());
        $("#form_verifikasi #verifikiasi_petugaspengkaji_nama").val(namaPegawai);
        $("#dialogVerifikasi").dialog("open");
    }
    
    function submitVerifikasi() {
        $.post('<?php echo $this->createUrl("verifikasi"); ?>', $("#form_verifikasi").serialize(), function(data) {
            if (data.ok == 1) {
                $("#dialogVerifikasi").dialog("close");
                myAlert(data.msg);
                $.fn.yiiGridView.update("pengkajian-nyeri-grid");
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }
    
    
    var ru = $('#search_ruangan_id');
    
    
    function setRuanganMulti() {
        
        console.log("Kick");
        
        var ins  = jQuery('#search_instalasi_id');
        var ins_all = jQuery('#search_instalasi_id option:selected');
        var ru  = jQuery('#search_ruangan_id');

        var brands = ins_all;
        var selected = [];


        $(brands).each(function(index, brand){
                selected.push($(this).val());
        });

        ru.addClass('animation-loading');
        //alert(selected);

        $.post('<?php echo $this->createUrl('/actionDynamic/getRuanganDariInstalasi', array('namaModel'=>'PengkajiannyeriT')) ?>', $("#searchRiwayat").serialize(), function(data){	

            //alert(data.ruangan);
            ru.html(data);
            console.log(ru.find("option[value='']").remove());
            ru.find("options[value='']").remove();
            ru.multiselect('rebuild');																
            ru.removeClass('animation-loading');
            						
        });

    }
    
    function hapusRiwayatPengkajianNyeri(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.sukses === 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('pengkajian-nyeri-grid', {
                            data: $('#searchRiwayat').serialize()
                        });
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    $("#btn_cari").on('click', function() {
        
        $.fn.yiiGridView.update('pengkajian-nyeri-grid', {data: $("#searchRiwayat").serialize()});
        
        return false;
    });
    
    
    
    $(document).ready(function() {
        console.log(ru);
        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
        
    });
    
    
</script>