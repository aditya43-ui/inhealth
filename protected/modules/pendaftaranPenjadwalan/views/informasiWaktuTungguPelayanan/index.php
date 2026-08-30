<?php
$this->breadcrumbs = array(
    'Informasi Waktu Tunggu Pelayanan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Waktu Tunggu Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#waktutunggu-src-grid').submit(function(){
            $.fn.yiiGridView.update('waktutunggu-info-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        
        <?php 
            $kirimAllCount = 0;
          
            $prov = $model->searchInfo();
            foreach ($prov->data as $i => $itemd) {
                if (($itemd->getCountStatusTerkirim($itemd->pendaftaran_id)==false)) {
                    $kirimAllCount += 1;
                }
            }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Waktu Tunggu Pelayanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'waktutunggu-info-grid',
                    'dataProvider'=>$model->searchInfo(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                        array(
                            'header'=>'Tgl. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
                        array(
                            'header'=>'No. Pendaftaran'.'/<br>'.'No. Rekam Medik',
                            'type'=>'raw',
                            'value'=>'"$data->no_pendaftaran"."/<br>"."$data->no_rekam_medik"',
                        ),
                        array(
                            'header'=>'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien',
                        ),
                        array(
                            'header'=>'Status Terkirim',
                            'type'=>'raw',
                            'value'=>function($data){
                                return ($data->getCountStatusTerkirim($data->pendaftaran_id)==true?"Ya":"Tidak");
                            },
                        ), 
                        array(
                            'header'=>'Response',
                            'type'=>'raw',
                            'value'=>function($data){
                                return $data->ambilResponseTask($data->pendaftaran_id);
                            },
                        ),
                        array(
                            'header'=>'Detail Riwayat',
                            'type'=>'raw',
                            'value'=>function ($data){
                                return  CHtml::Link("<i class=icon-form-detail></i>",Yii::app()->createUrl("pendaftaranPenjadwalan/InformasiWaktuTungguPelayanan/riwayat",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                        array("class"=>"", 
                                            "target"=>"iframeRiwayat",
                                            "onclick"=>"$(\"#dialogRiwayat\").dialog(\"open\");",
                                            "rel"=>"tooltip",
                                            "title"=>"Klik Lihat Riwayat",
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),        
                        array(
                            'header' => 'Kirim Ke BPJS <br>' . (($kirimAllCount > 0) ? CHtml::link('<icon class="icon-kirimdok"></icon>', "javascript::void(0)", array("onclick" => "kirimAllBPJS();", "rel" => "tooltip", "title" => "Klik untuk kirim Semua Ke BPJS")) : ""),
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->getCountStatusTerkirim($data->pendaftaran_id)==true) {
                                    return "";
                                }else{
                                    return CHtml::Link(
                                        '<i class="icon-kirimdok"></i>',
                                        'javascript::void(0)',
                                        array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk kirim Ke BPJS",
                                            "onclick" => "kirimBpjs(" . $data->pendaftaran_id . "); return false;",
                                        )
                                    );
                                }
                               
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align: center;'
                            ),
                        ) 
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
    </div>
</div>

<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    'options' => array(
        'title' => 'Riwayat Waktu Tunggu Layanan',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeRiwayat" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>

<script>

    function kirimBpjs(pendaftaran_id) {
        myConfirm("'Yakin Anda akan melakukan Kirim Ke BPJS?",'Perhatian!',function(r){
            if (r){
                $.post('<?php echo $this->createUrl('kirimKeBpjs'); ?>', {id: pendaftaran_id}, function(data) {
                    myAlert(data.pesan);
                    $.fn.yiiGridView.update('waktutunggu-info-grid', {
                        data: $(this).serialize()
                    });
                }, 'json');
           }
        });
    }

    function kirimAllBPJS() {
        myConfirm("'Yakin Anda akan melakukan Kirim Ke BPJS?",'Perhatian!',function(r){
            if (r){
                $.post('<?php echo $this->createUrl('kirimAllKeBpjs'); ?>', $('#waktutunggu-src-grid').serialize(), function(data) {
                    myAlert(data.pesan);
                    $.fn.yiiGridView.update('waktutunggu-info-grid', {
                        data: $('#waktutunggu-src-grid').serialize()
                    });
                }, 'json');
           }
        });
    }
</script>