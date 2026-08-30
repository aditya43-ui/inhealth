<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Pemeriksaan USG</div>
    </div>
    <div class="panel-body" style="overflow-x: auto;">
        <?php
        $modList = new PemeriksaanusgpasienT();
        $modList->unsetAttributes();
        $modList->pendaftaran_id = $model->pendaftaran_id;
        $prov = $modList->search();
//        $prov->sort->defaultOrder = "s";
        
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'observasi-grid',
            'dataProvider' => $prov,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header'=>'No',
                    'type'=>'raw',
                    'value'=>'$row+1',
                ),
                array(
                    'header'=>'Tanggal & Jam Pemeriksaan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan)',
                ),
                  array(
                    'header'=>'Ruangan Periksa',
                    'type'=>'raw',
                    'value'=>function($data) {
                         return $data->ruanganperiksausg->instalasi->instalasi_nama."/<br/>".$data->ruanganperiksausg->ruangan_nama;
                     }
                ),
                  array(
                    'header'=>'Trimester',
                    'type'=>'raw',
                    'value'=>'$data->trimesterkehamilan',
                ),
                array(
                    'header'=>'Pemeriksaan',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return $data->dokterpemeriksa->namaLengkap;
                    }
                ),
                array(
                    'header'=>'Hasil Pemeriksaan USG',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $titlehtml = "";
                        
                        if($data->trimesterkehamilan == '1'){
                            $titlehtml = "Trimester I";
                        }else if($data->trimesterkehamilan == '2'){
                            $titlehtml = "Trimester II";
                        }else if($data->trimesterkehamilan == '3'){
                            $titlehtml = "Trimester III";
                        }
                    
                        return CHtml::link(
                                        '<icon class="icon-riwayatpasien"></icon>', Yii::app()->createUrl("/rawatJalan/hasilPemeriksaanUsg/hasilPemeriksaan", array("pendaftaran_id"=>$data->pendaftaran_id,"pemeriksaanusgpasien_id"=>$data->pemeriksaanusgpasien_id,"dialog"=>true)), 
                                        array(
                                            "target"=>"iframeHasilPemeriksaan", 
                                            "onclick"=>"dialogDetailPemeriksaan('".$titlehtml."')",
                                            "rel"=>"tooltip", 
                                            "title"=>"Klik untuk Melihat Hasil Pemeriksaan USG",
                                            
                                        ));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                ),
                array(
                    'header'=>'Ubah',
                    'type'=>'raw',
                    'value'=>function($data) {
                        
                        return (($data->ruanganperiksausg_id == Yii::app()->user->getState("ruangan_id")) ? CHtml::link('<i class="entypo-pencil"></i>', Yii::app()->controller->createUrl('index', array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                            'pemeriksaanusgpasien_id'=>$data->pemeriksaanusgpasien_id,
                             'type'=>$_GET['type'],
                             'frame'=>$_GET['frame']
                        ))):"");
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                ),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return (($data->ruanganperiksausg_id == Yii::app()->user->getState("ruangan_id")) ? CHtml::link('<i class="entypo-trash"></i>', '#', array(
                            'onclick'=>'hapusHasilPemeriksaan('.$data->pemeriksaanusgpasien_id.','.$data->pendaftaran_id.'); return false'
                        )) : "");
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                ),
                array(
                    'header'=>'Cetak',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return $this->renderPartial($this->path_view.'_tombolPrinout',array('model'=>$data),true);
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
            . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
        ));
        ?>
    </div>
</div>

<?php 
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogHasil',
        'options' => array(
            'title' => 'Detail Hasil Pemeriksaan USG : <span class="titleDialog"></span>',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1100,
            'height' => 700,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeHasilPemeriksaan' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

