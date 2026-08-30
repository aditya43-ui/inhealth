<?php 
 $this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'srk-spri-grid',
        'dataProvider' => $model->searchInformasi(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed table-bordered',
        'replaceUrl' => true,
        'columns' => array(
            'nosep',
            array(
                'name'=>'tglsep',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tglsep)',
            ),
            'nokartuasuransi',
            'nama_pasien',
            array(
                'name'=>'jenissurat',
                'value'=>'$data->jenissurat == 1 ? "Rencana Kontrol" : "SPRI"',
            ),
            array(
                'name'=>'tglsurat',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tglsurat)',
            ),
            array(
                'name'=>'tglrenkontrol',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tglrenkontrol)',
            ),
            'nomorsurat_bpjs',
            array(
                'name'=>'Poli Asal',
                'value'=>'$data->ruangan_nama',
            ),
            array(
                'name'=>'Poli Tujuan',
                'value'=>'$data->ruangankontrol_nama',
            ),
            array(
                'name'=>'pegawai_id',
                'type'=>'raw',
                'value'=>function($data) {
                    if (empty($data->pegawai_id)) {
                        return "-";
                    }
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    return empty($peg) ? "-" : $peg->namaLengkap;
                }
            ),
            array(
                'header'=>'Lihat',
                'type'=>'raw',
                'value'=>function($data) {
                    if(!empty($data->pendaftaran_id)) {
                        return CHtml::link('<i class="icon-form-lihat"</i>', '#', array(
                            'rel'=>'tooltip', 'title'=>'Lihat Surat Kontrol/SPRK',
                            'onclick'=>'printDetailSurat('.$data->surat_id.', '.$data->jenissurat.'); return false;',
                        ));
                    } else {
                        return CHtml::link('<i class="icon-form-lihat"</i>', '#', array(
                            'rel'=>'tooltip', 'title'=>'Lihat Surat Kontrol/SPRK',
                            'onclick'=>'printDetailSuratTanpaKunjungan('.$data->surat_id.', '.$data->jenissurat.'); return false;',
                        ));
                    }
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                ),
            ),
            array(
                'header' => 'Print Surat',
                'type' => 'raw',
                'value' => function ($data) {
                    if (!empty($data->pendaftaran_id)) {
                        return CHtml::link('<i class="icon-form-print"</i>', '#', array(
                            'rel' => 'tooltip', 'title' => 'Lihat Surat Kontrol/SPRK',
                            'onclick' => 'printSRK(' . $data->pendaftaran_id . '); return false;',
                        ));
                    } else {
                        return CHtml::link('<i class="icon-form-print"</i>', '#', array(
                            'rel' => 'tooltip', 'title' => 'Lihat Surat Kontrol/SPRK',
                            'onclick' => 'printDetailSuratTanpaKunjungan(' . $data->surat_id . ', ' . $data->jenissurat . '); return false;',
                        ));
                    }
                },
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header'=>'Update Rencana Kontrol/SPRI',
                'type'=>'raw',
                'value'=>function($data) {
                    if(!empty($data->pendaftaran_id)) {
                        $action = $data->jenissurat == 1 ? "updateKontrol" : "updateRanap";
                        $iframe = $data->jenissurat == 1 ? "frame-kontrol" : "frame-ranap";
                        $dialog = $data->jenissurat == 1 ? "dialog-kontrol" : "dialog-ranap";
    
                        return CHtml::link('<i class="icon-form-ubah"</i>', Yii::app()->controller->createUrl($action, array(
                            'id'=>$data->surat_id, 
                        )), array(
                            'target'=>$iframe, 'onclick'=>"$('#".$dialog."').dialog('open');",
                            'rel'=>'tooltip', 'title'=>'Ubah Surat Kontrol/SPRK',
                        ));
                    } else {
                        return CHtml::link('<i class="icon-form-ubah"</i>', Yii::app()->controller->createUrl('updateSRKTanpaKunjungan', array(
                            'id'=>$data->surat_id, 
                        )), array(
                            'target'=>'iframeUpdateSRKTanpaKunjungan', 'onclick'=>"$('#dialogRSKTanpaKunjungan').dialog('open');",
                            'rel'=>'tooltip', 'title'=>'Ubah Surat Kontrol/SPRK Tanpa Kunjungan',
                        ));
                    }
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                ),
            ),
            array(
                'header'=>'Hapus',
                'type'=>'raw',
                'value'=>function($data) {

                    return CHtml::link('<i class="icon-form-sampah"</i>', '#', array(
                        'rel'=>'tooltip', 'title'=>'Hapus Surat Kontrol/SPRK',
                        'onclick'=>"hapusKontrolSPRI(".$data->surat_id.", ".$data->jenissurat."); return false;",
                    ));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                ),
            ),
            
        ),
        'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            }',
    )
);

?>