<?php
Yii::app()->clientScript->registerScript('search', "
    $('#persiapanpengadaan-m-search').submit(function(){
        $.fn.yiiGridView.update('persiapanpengadaan-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Persiapan Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Informasi <strong>Persiapan Pengadaan</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'persiapanpengadaan-m-grid',
                            'replaceUrl'=>true,
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Nomor dan Tanggal Transaksi',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data)){
                                            return CHtml::link($data->persiapanpengadaan_nomor.'<br>'.MyFormatter::formatDateTimeforUser($data->persiapanpengadaan_tanggal),
                                                    Yii::app()->createUrl('pengadaan/InformasiPersiapanPengadaan/detail&id='.$data->persiapanpengadaan_id),
                                                    array(
                                                        'class'=>'hover',
                                                        "rel"=>"tooltip",
                                                        "title"=>"Klik untuk Melihat Detail Persiapan Pengadaan"));
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Nomor RUP',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data)){
                                            return CHtml::link($data->rencanaumumpengadaan_nomor,
                                                    Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/detail&id='.$data->rencanaumumpengadaan_id),
                                                    array(
                                                        'class'=>'hover',
                                                        "rel"=>"tooltip",
                                                        "target"=>"__blank", 
                                                        //"onclick"=>"$('#dialogDetail').dialog('open');",
                                                        "title"=>"Klik untuk Melihat Detail Rencana Umum Pengadaan"));
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Bagian / Bidang / Instalasi',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data->instalasi_nama)){
                                            return $data->instalasi_nama;
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Kategori Pengadaan',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data->rencanaumumpengadaan_kategori)){
                                            return $data->rencanaumumpengadaan_kategori;
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Nama Pekerjaan',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data->nama_pekerjaan)){
                                            return $data->nama_pekerjaan;
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Nilai HPS',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data->persiapanpengadaan_id)){
                                            $persiapan = PersiapanpengadaanT::model()->findByPk($data->persiapanpengadaan_id);
                                            if(!empty($persiapan)){
                                                return 'Rp&nbsp;'.number_format($persiapan->total_hargaseluruhnya,2,',','.');
                                            }else{
                                                return '-';
                                            }
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Tahun Anggaran',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data->periodeanggaran_id)){
                                            $periodeanggaran = PeriodeanggaranK::model()->findByPk($data->periodeanggaran_id);
                                            return $periodeanggaran->tahunanggaran." - ".$periodeanggaran->anggaran_nama;
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Sumber Dana',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        $sumberdana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id'=>$data->rencanaumumpengadaan_id));
                                        if(!empty($sumberdana)){
                                            foreach($sumberdana as $sumber){
                                                $modSumber = SumberanggaranM::model()->findByPk($sumber->sumberanggaran_id);
                                                echo $modSumber->sumberanggarannama.'<br>';
                                            }
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Status',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data->persiapanpengadaan_status)){
                                            return ($data->persiapanpengadaan_status);
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Ubah',
                                    'type'=>'raw',
                                    'value'=>function($data) {   
                                        if (strtolower($data->persiapanpengadaan_status) == strtolower(Params::STATUS_PERSIAPAN_DIBATALKAN)){
                                            return "<span style='font-size:15px;'><i class='entypo-pencil'></i></span>";
                                        }else{
                                            if (    $data->pegawaikpa_id == Yii::app()->user->getState('pegawai_id') || 
                                                    $data->pegawaipa_id == Yii::app()->user->getState('pegawai_id') ||
                                                    $data->pegawaippk_id  == Yii::app()->user->getState('pegawai_id') || 
                                                    $data->pegawaipembuat_id  == Yii::app()->user->getState('pegawai_id')
                                                    ){
                                                        if(!empty($data)){
                                                            if(strtolower($data->persiapanpengadaan_status) == 'diajukan' || strtolower($data->persiapanpengadaan_status) == 'revisi'){
                                                                return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>",
                                                                Yii::app()->createUrl('pengadaan/persiapanPengadaan/index&persiapanpengadaan_id='.$data->persiapanpengadaan_id),
                                                                array(
                                                                    'class'=>'hover',
                                                                    "rel"=>"tooltip",
                                                                    "data-placement"=>"left",
                                                                    "title"=>"Klik untuk Mengubah Persiapan Pengadaan"));
                                                            }else{
                                                                return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-pencil'></i></span>",
                                                                '',
                                                                array(
                                                                    'class'=>'hover',
                                                                    "rel"=>"tooltip",
                                                                    "data-placement"=>"left",
                                                                    "title"=>"Klik untuk Mengubah Persiapan Pengadaan"));
                                                            }
                                                        } else {
                                                            return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-pencil'></i></span>",
                                                                'javascript:;',
                                                                array(                                                                
                                                                    'class'=>'hover',
                                                                    "rel"=>"tooltip",
                                                                    "data-placement"=>"left",
                                                                    "title"=>"Klik untuk Mengubah Persiapan Pengadaan"));
                                                        }
                                            }else{
                                                 return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>",
                                                        'javascript:;',
                                                        array(
                                                            'onclick' => 'myAlert("Maaf, Anda tidak berwenang mengubah data.","Perhatian!")',
                                                            'class'=>'hover',
                                                            "rel"=>"tooltip",
                                                            "data-placement"=>"left",
                                                            "title"=>"Klik untuk Mengubah Persiapan Pengadaan"));
                                            }
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Review',
                                    'type'=>'raw',
                                    'value'=>function($data) {  
                                        if (strtolower($data->persiapanpengadaan_status) == strtolower(Params::STATUS_PERSIAPAN_DIBATALKAN)){
                                            return "<span style='font-size:15px;'><i class='entypo-docs'></i></span>";
                                        }else{
                                            $cekUnitkerja = UnitkerjaM::model()->findByPk(Params::UNITKERJA_ID_PENGADAAN_DAN_JASA);
                                            $cekpegawailogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                            
                                            if($cekUnitkerja->kepalaunitpeg_id == Yii::app()->user->getState('pegawai_id')){
                                                if ($data->persiapanpengadaan_status == 'Diajukan') {
                                                     return CHtml::link("<span style='font-size:15px; color: green'><i class='entypo-docs'></i></span>",
                                                        Yii::app()->createUrl('pengadaan/informasiPersiapanPengadaan/review&id='.$data->persiapanpengadaan_id),
                                                        array(
                                                            'class'=>'hover',
                                                            "rel"=>"tooltip",
                                                            "data-placement"=>"left",
                                                            "title"=>"Klik untuk Menambahkan Review Persiapan Pengadaan"));
                                                } else {
                                                    return CHtml::link("<span style='font-size:15px; color: red'><i class='entypo-docs'></i></span>");
                                                }
                                            }
//                                            else if($cekpegawailogin->unitkerja_id == Params::UNITKERJA_ID_PENGADAAN_DAN_JASA){
//                                                if(!empty($data)){
//                                                    if($data->persiapanpengadaan_status == 'Diajukan'){
//                                                        return CHtml::link("<span style='font-size:15px; color: green'><i class='entypo-docs'></i></span>",
//                                                        Yii::app()->createUrl('pengadaan/informasiPersiapanPengadaan/review&id='.$data->persiapanpengadaan_id),
//                                                        array(
//                                                            'class'=>'hover',
//                                                            "rel"=>"tooltip",
//                                                            "data-placement"=>"left",
//                                                            "title"=>"Klik untuk Menambahkan Review Persiapan Pengadaan"));
//                                                    } else {
//                                                        return CHtml::link("<span style='font-size:15px; color: red'><i class='entypo-docs'></i></span>");
//                                                    } 
//                                                } 
//                                            } 
                                            else {
                                                return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-docs'></i></span>",
                                                    '',
                                                    array(
                                                        'class'=>'hover',
                                                        "rel"=>"tooltip",
                                                        "data-placement"=>"left",
                                                        "title"=>"Klik untuk Review Persiapan Pengadaan"));
                                            }
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Pejabat <br> Pengadaan',
                                    'type' => 'raw',
                                    'value' => function($data){
                                        $modInfo = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $data->persiapanpengadaan_id));
                                        $cri = new CDbCriteria();
                                        $cri->addCondition('pegawai_id = ' . Yii::app()->user->getState('pegawai_id'));
                                        $cri->addCondition('pejabatpengadaan_aktif is true');
                                        $cri->addCondition("jabatan_pengadaan = '" . Params::JABATAN_PENGADAAN_PPK . "'");
                                        $modPPK = PejabatpengadaanM::model()->find($cri);
                                        $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $data->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                                        $pegawai_pengadaan = !empty($modInfo->pegpengadaan->namaLengkap) ? $modInfo->pegpengadaan->namaLengkap : '';
                                        
                                        if (!empty($modInfo)) {
                                            if ($data->persiapanpengadaan_status == Params::STATUS_PERSIAPAN_DISETUJUI && empty($modPPK) && empty($cekSPK)) {
                                                if(empty($pegawai_pengadaan)){
                                                    echo "<span style='font-size:15px;'><i class='fa fa-user'></i></span>";
                                                }else{
                                                    return CHtml::link($modInfo->pegpengadaan->namaLengkap,
                                                            Yii::app()->createUrl('pengadaan/informasiPersiapanPengadaan/pejabatPengadaan&persiapanpengadaan_id='.$data->persiapanpengadaan_id),
                                                            array(
                                                                'class'=>'hover',
                                                                "rel"=>"tooltip",
                                                                "target" => "iframe2",
                                                                "onclick" => "$('#dialog2').dialog('open');",
                                                                "data-placement"=>"left",
                                                                "title"=>"Klik untuk Menambahkan Pemilihan Pejabat Pengadaan"));
                                                }
                                            } else if($data->persiapanpengadaan_status == 'Diajukan'){
                                                echo "<span style='font-size:15px;'><i class='fa fa-user'></i></span>";
                                            } else {
                                                if(!empty($pegawai_pengadaan)){
                                                    return CHtml::link($modInfo->pegpengadaan->namaLengkap,
                                                            Yii::app()->createUrl('pengadaan/informasiPersiapanPengadaan/pejabatPengadaan&persiapanpengadaan_id='.$data->persiapanpengadaan_id),
                                                            array(
                                                                'class'=>'hover',
                                                                "rel"=>"tooltip",
                                                                "target" => "iframe2",
                                                                "onclick" => "$('#dialog2').dialog('open');",
                                                                "data-placement"=>"left",
                                                                "title"=>"Klik untuk Menambahkan Pemilihan Pejabat Pengadaan"));
                                                }
                                            }
                                        } else {
                                            if ($data->persiapanpengadaan_status == Params::STATUS_PERSIAPAN_DISETUJUI && empty($modPPK) && empty($cekSPK)) {
                                                return CHtml::link("<span style='font-size:15px; color: green'><i class='fa fa-user'></i></span>",
                                                        Yii::app()->createUrl('pengadaan/informasiPersiapanPengadaan/pejabatPengadaan&persiapanpengadaan_id='.$data->persiapanpengadaan_id),
                                                        array(
                                                            'class'=>'hover',
                                                            "rel"=>"tooltip",
                                                            "target" => "iframe2",
                                                            "onclick" => "$('#dialog2').dialog('open');",
                                                            "data-placement"=>"left",
                                                            "title"=>"Klik untuk Menambahkan Pemilihan Pejabat Pengadaan"));
                                            } else if($data->persiapanpengadaan_status == 'Diajukan'){
                                                echo "<span style='font-size:15px;'><i class='fa fa-user'></i></span>";
                                            } else {
                                                echo "<span style='font-size:15px;'><i class='fa fa-user'></i></span>";
                                            }
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Cetak HPS',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if (strtolower($data->persiapanpengadaan_status) == strtolower(Params::STATUS_PERSIAPAN_DIBATALKAN)){
                                            return "<span style='font-size:15px;'><i class='entypo-print'></i></span>";
                                        }else{
                                            if(!empty($data)){
                                                return CHtml::link('<span style="font-size:15px;"><i class="entypo-print"></i></span>', '#', array(
                                                            'class' => 'hover',
                                                            "rel" => "tooltip",
                                                            "data-placement" => "left",
                                                            "title" => "Klik untuk Cetak Mencetak HPS",
                                                            'onclick' => "window.open('" . $this->createUrl('printHps', array('id' => $data->persiapanpengadaan_id)) . "', 'printwin', 'left=100,top=100,width=1120,height=790')"
                                                ));
                                            } else {
                                                return CHtml::link("<span style='font-size:15px;'><i class='entypo-print'></i></span>");
                                            } 
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial('_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>        
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    
    $js = <<< JSCRIPT
				function cekForm(obj){
					$("#persiapanpengadaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#persiapanpengadaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
<?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetail',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Rencana Umum Pengadaan',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Rencana Umum Pengadaan================================
?>
<?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialog2',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Pemilihan Pejabat Pengadaan',
    'autoOpen'=>false,
    'width'=>800,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('persiapanpengadaan-m-grid', {
            data: $('#persiapanpengadaan-m-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe2" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Rencana Umum Pengadaan================================
?>