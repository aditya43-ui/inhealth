<?php 

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'daftarPasien-grid',
	'dataProvider'=>$model->searchRiwayat($model->pendaftaran_id),
                'template'=>"{summary}\n{items}\n{pager}",
                'replaceUrl'=>true,
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                       'name'=>'Tanggal / Jam',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggalpengkajian)',
                    ),
                    array(
                        'header'=>'Instalasi / Ruangan',
                        'type'=>'raw',
                        'value'=>function ($data){
                            $modRuangan = RuanganM::model()->findByPk($data->create_ruangan_id);
                            return $modRuangan->instalasi->instalasi_nama . " / ". $modRuangan->ruangan_nama;
                        }
                    ),
                    array(
                        'header'=>'Jenis Skoring',
                        'type'=>'raw',
                        'value'=>'$data->jenisews'
                    ),array(
                        'header'=>'Total Skor',
                        'type'=>'raw',
                        'value'=>'$data->total_skor'
                    ),
                array(
                        'header'=>'Lihat Detail',
                        'type'=>'raw',
                        'value'=>function($data) {
                        $modEws = EwspasienT::model()->findByPk($data->ewspasien_id);
                        
                        $titleDetail = "";
                        if(isset($modEws)){
                            if($modEws->jenisews == 'ews'){
                                $titleDetail = "EWS | Assesmen Early Warning Score";
                            }else if($modEws->jenisews == 'pews'){
                                $titleDetail = "EWS | Assesmen Pediatric Early Warning Score";
                            }else if($modEws->jenisews == 'newborn ews'){
                                $titleDetail = "EWS | Assesmen Newborn Early Warning Score";
                            }else if($modEws->jenisews == 'moews'){
                                $titleDetail = "EWS | Assesmen Modified Obstetric Early Warning System";
                            }
                        }
                        
                        return CHtml::link(
                                        '<icon class="icon-form-detail"></icon>', Yii::app()->createUrl("/rawatDarurat/earlyWarningScore/detailEws", array("pendaftaran_id"=>$data->pendaftaran_id,"ewspasien_id"=>$data->ewspasien_id,"dialog"=>true)), 
                                        array(
                                            "target"=>"iframeDetailEws", 
                                            "onclick"=>"dialogEws('".$titleDetail."')",
                                            "rel"=>"tooltip", 
                                            "title"=>"Klik untuk Melihat Detail",
                                            
                                        ));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                    ),
                array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="icon-trash"></i>', '#', array(
                                'onclick'=>'hapusEws('.$data->ewspasien_id.','.$data->pendaftaran_id.'); return false'
                            ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
            array(
                        'header'=>'Cetak',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="icon-print"></i>', '#', array(
                                'onclick'=>'printEws('.$data->ewspasien_id.','.$data->pendaftaran_id.'); return false'
                            ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
<?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailEws',
        'options' => array(
            'title' => 'Detail Early Warning Score',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 700,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailEws' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function dialogEws(textTitle){
        $("#ui-dialog-title-dialogDetailEws").html("Detail "+textTitle);
        $('#dialogDetailEws').dialog('open');
    }
</script>
    
    