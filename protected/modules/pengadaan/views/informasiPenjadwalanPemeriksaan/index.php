<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#penjadwalanpemeriksaan-m-search').submit(function(){
            $.fn.yiiGridView.update('penjadwalanpemeriksaan-r-grid', {
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
                <div class="panel-title">Informasi <strong>Penjadwalan Pemeriksaan </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Informasi <strong>Penjadwalan Pemeriksaan</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'penjadwalanpemeriksaan-r-grid',
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
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Tanggal dan Nomor Penjadwalan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function($data){
                            
                                        echo CHtml::link(MyFormatter::formatDateTimeForUser($data->pengadaanjadwalpemeriksaan_tanggal)."<br>".$data->pengadaanjadwalpemeriksaan_nomor,
                                                    Yii::app()->createUrl('pengadaan/InformasiPenjadwalanPemeriksaan/detail&id='.$data->pengadaanjadwalpemeriksaan_id),
                                                        array(
                                                                "rel"=>"tooltip",
                                                                "title"=>"Klik untuk melihat detail", 
                                                                "target"=>"frameSetuju", 
                                                                "onclick"=>"window.parent.$(\"#dialogSetuju\").dialog(\"open\");"));
                                    }
                                ),
                                array(
                                    'header' => 'Nomor SPK',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => '$data->nosuratperjanjiankerja'
                                ),
                                array(
                                    'header' => 'Nama Pekerjaan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => '$data->namapekerjaan'
                                ),
                                array(
                                    'header' => 'Penyedia',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => '$data->supplier_nama'
                                ),
                                array(
                                    'header' => 'Waktu Pemeriksaan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_pemeriksaan)'
                                ),
                                array(
                                    'header' => 'Pemeriksa',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function($data){
                                        $modJadwalDet = PengadaanjadwalpemeriksaandetT::model()->findAllByAttributes(array('pengadaanjadwalpemeriksaan_id' => $data->pengadaanjadwalpemeriksaan_id));
                                        if (!empty($modJadwalDet)) {
                                            echo '<ul>';
                                                foreach($modJadwalDet as $value){
                                                    echo '<li>'.$value->pegpemeriksa->namaLengkap.'</li>';
                                                }
                                            echo '</ul>';
                                        }
                                                                             
                                    }
                                ),
                                array(
                                    'header' => 'Persetujuan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'type' => 'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value' => function($data){
                                        $cekLogin = Yii::app()->user->getState('pegawai_id');
                                        $modJadwalDet = PengadaanjadwalpemeriksaandetT::model()->findAllByAttributes(array('pengadaanjadwalpemeriksaan_id' => $data->pengadaanjadwalpemeriksaan_id, 'pegpemeriksa_id' => $cekLogin));
                                        if (!empty($modJadwalDet)) {
                                            foreach($modJadwalDet as $value){
                                                if ($data->pengadaanjadwalpemeriksaan_status == Params::STATUSDIAJUKAN) {
                                                        echo CHtml::link("<i class='fa fa-check-circle' style='font-size: 20px; color: #00a651'></i>", 
                                                                        '', 
                                                                        array(
                                                                            'class' => 'hover',
                                                                            "rel" => "tooltip",
                                                                            "data-placement" => "left",
                                                                            'onclick'=>'verifikasi('.$value->pengadaanjadwalpemeriksaan_id.');')).
                                                            CHtml::link("<i class='fa fa-times-circle' style='font-size: 20px; color: #d42020; margin-left: 20px;'></i>",
                                                            Yii::app()->createUrl('pengadaan/InformasiPenjadwalanPemeriksaan/tolak&id='.$value->pengadaanjadwalpemeriksaan_id.'&pegpemeriksa='.$value->pegpemeriksa_id),
                                                                array(
                                                                        "rel"=>"tooltip",
                                                                        "title"=>"Klik untuk Menolak", 
                                                                        "target"=>"frameTolak", 
                                                                        "onclick"=>"window.parent.$(\"#dialogTolak\").dialog(\"open\");"));  

                                                } else {
                                                    if ($data->pengadaanjadwalpemeriksaan_status == Params::STATUSDISETUJUI) {
                                                        return CHtml::htmlButton('<i class="fa fa-check"> </i> DISETUJUI', array(
                                                                        'class' => 'btn btn-green',
                                                                        'disabled' => false,
                                                                        'style' => 'width: 120px;',
                                                                        'rel'=>'tooltip',
                                                                )); 
                                                    } else {
                                                        return CHtml::htmlButton('<i class="fa fa-times"> </i> DITOLAK', array(
                                                                        'class' => 'btn btn-danger',
                                                                        'disabled' => false,
                                                                        'style' => 'width: 120px;',
                                                                        'rel'=>'tooltip',
                                                                )); 

                                                    }
                                                } 
                                            }
                                        } else {
                                            if ($data->pengadaanjadwalpemeriksaan_status == Params::STATUSDIAJUKAN) {
                                                    echo CHtml::link("<i class='fa fa-check-circle' style='font-size: 20px; color: #00a651'></i>", 
                                                                        '', 
                                                                        array(
                                                                            'class' => 'hover',
                                                                            "rel" => "tooltip",
                                                                            "data-placement" => "left",
                                                                            'onclick' => 'myAlert("Hanya Pegawai PPHP yang dapat menyetujui");return false;')) . 
                                                            CHtml::link("<i class='fa fa-times-circle' style='font-size: 20px; margin-left: 20px; color: #d42020'></i>", 
                                                                        '', 
                                                                        array(
                                                                            'class' => 'hover',
                                                                            "rel" => "tooltip",
                                                                            "data-placement" => "left",
                                                                            'onclick' => 'myAlert("Hanya Pegawai PPHP yang dapat menolak");return false;'));
                                                  
                                                } else {
                                                    if ($data->pengadaanjadwalpemeriksaan_status == Params::STATUSDISETUJUI) {
                                                        return CHtml::htmlButton('<i class="fa fa-check"> </i> DISETUJUI', array(
                                                                        'class' => 'btn btn-green',
                                                                        'disabled' => false,
                                                                        'style' => 'width: 120px;',
                                                                        'rel'=>'tooltip',
                                                                )); 
                                                    } else {
                                                        return CHtml::htmlButton('<i class="fa fa-times"> </i> DITOLAK', array(
                                                                        'class' => 'btn btn-danger',
                                                                        'disabled' => false,
                                                                        'style' => 'width: 120px;',
                                                                        'rel'=>'tooltip',
                                                                )); 

                                                    }
                                                } 
                                        }
                                        
                                          
                                        
                                    }
                                ),
                                array(
                                    'header' => 'Keterangan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function($data){
                                        if (!empty($data->alasan_tolak)) {
                                            return $data->alasan_tolak;
                                        }
                                    }
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
					$("#penjadwalanpemeriksaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#penjadwalanpemeriksaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
    'width'=>1070,
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
// ===========================Dialog =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogSetuju',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Penjadwalan Pemeriksaan',
    'autoOpen'=>false,
    'modal' => true,
    'width'=>1000,
    'height'=>400,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('penjadwalanpemeriksaan-r-grid'); }",
     ),
));
?>
<iframe src="" name="frameSetuju" width="100%" height="100%">
</iframe>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// ===========================Dialog =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogTolak',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Alasan Menolak Jadwal Pemeriksaan',
    'autoOpen'=>false,
    'modal' => true,
    'width'=>500,
    'height'=>300,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('penjadwalanpemeriksaan-r-grid'); }",
     ),
));
?>
<iframe src="" name="frameTolak" width="100%" height="100%">
</iframe>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script type="text/javascript">
    function reloadTabel(){
        toastr.success('Penolakan penjadwalan pemeriksaan berhasil dilakukan');
        $.fn.yiiGridView.update('penjadwalanpemeriksaan-r-grid');
    }
    
    function verifikasi(id) {
        myConfirm('Apakah anda akan menyetujui penjadwalan pemeriksaan ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('verifikasi'); ?>',
                    data: {id: id},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 1) {
                            toastr.success('Persetujuan penjadwalan pemeriksaan berhasil dilakukan');
                            $.fn.yiiGridView.update('penjadwalanpemeriksaan-r-grid');
                        } else {
                            toastr.success(data.pesan);

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });        
            }
        });
    }
</script>