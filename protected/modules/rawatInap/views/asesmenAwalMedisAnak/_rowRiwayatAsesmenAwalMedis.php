<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayatasesmenawal-medis',
    'dataProvider'=>$modAsesmenAwalMedis->searchRiwayatByPendaftaran(),
//    'dataProvider'=>$modRiwayatAwalMedis,
    'filter'=>$modRiwayatAwalMedis,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
            array(
                'header' => 'Tanggal Pemeriksaan',
                'value' => '!empty($data->tgl_pemeriksaan)?MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan):""'
            ),
            array(
                'header' => 'Keluhan Utama',
                'value' => '$data->keluhan_utama'
            ),
            array(
                'header' => 'Riwayat Penyakit Sekarang',
                'value' => '$data->riwayat_penyakit_sekarang'
            ),
            array(
                'header' => 'Riwayat Penyakit Terdahulu',
                'type' => 'raw',
                'value' => function($data){
                    $tr = '<ul>';
                    
                    if ($data->riwayat_sakit_dulu_tidakada){
                        return 'Tidak Ada';
                    }
                    
                    if ($data->riwayat_sakit_dulu_diabetes){
                        $tr .= '<li>Diabetes</li>';
                    }elseif ($data->riwayat_sakit_dulu_hipertensi){
                        $tr .= '<li>Hipertensi</li>';
                    }elseif ($data->riwayat_sakit_dulu_jantung){
                        $tr .= '<li>Jantung</li>';
                    }elseif ($data->riwayat_sakit_dulu_lainnya){
                        $tr .= '<li>'.$data->riwayat_sakit_dulu_lainnya_ket.'</li>';
                    }
                    
                    return $tr.'</ul>';
                },                        
            ),
            array(
                'header' => 'Riwayat Penyakit Keluarga',
                'type' => 'raw',
                'value' => function($data){
                    $tr = '<ul>';
                    
                    if ($data->riwayat_sakit_keluarga_tidakada){
                        return 'Tidak Ada';
                    }
                    
                    if ($data->riwayat_sakit_keluarga_diabetes){
                        $tr .= '<li>Diabetes</li>';
                    }elseif ($data->riwayat_sakit_keluarga_hipertensi){
                        $tr .= '<li>Hipertensi</li>';
                    }elseif ($data->riwayat_sakit_keluarga_jantung){
                        $tr .= '<li>Jantung</li>';
                    }elseif ($data->riwayat_sakit_keluarga_lainnya){
                        $tr .= '<li>'.$data->riwayat_sakit_keluarga_lainnya_ket.'</li>';
                    }                    
                    return $tr.'</ul>';
                },                        
            ),
            array(
                'header' => 'Riwayat Alergi Obat',
                'value' => function($data){
                    if ($data->riwayatalergi_obat){
                        return $data->riwayatalergi_obatket;
                    }
                },                        
            ),
            array(
                'header' => 'Riwayat Alergi Makanan',
                'value' => function($data){
                    if ($data->riwayatalergi_makanan){
                        return $data->riwayatalergi_makananket;
                    }
                },                        
            ),
            array(
                'header' => 'Berat Badan',
                'value' => function($data){
                   return !empty($data->beratbadan)?$data->beratbadan.' kg':'';
                },
                'htmlOptions' => array('style' => 'text-align:right;'),                            
            ),
            array(
                'header' => 'Tekanan Darah',
                'value' => function($data){
                    if (!empty($data->tekanandarah_sistolok) && !empty($data->tekanandarah_diastolik)){
                        return $data->tekanandarah_sistolok.'/'.$data->tekanandarah_diastolik.' mmHg';
                    }
                },
                'htmlOptions' => array('style' => 'text-align:right;'),     
                        
            ),
            array(
                'header' => 'Detak Nadi',
                'value' => function($data){
                   return $data->nadi;
                },                   
                'htmlOptions' => array('style' => 'text-align:right;')            
            ),
            array(
                'header' => 'Suhu Tubuh',
                'type' => 'raw',
                'value' => function($data){
                   return (!empty($data->suhu))?$data->suhu.' <sup>o</sup>C':'';
                },
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header'=>'Lihat',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("LihatRiwayat",array("id"=>$data->asesmen_awal_medis_id,"detail"=>'detail')),
                        array("class"=>"", 
                            "target"=>"frameDetail",
                            "onclick"=>"$('#dialogDetail').dialog('open');",
                            "rel"=>"tooltip",
                            'data-placement'=>'left',
                            "title"=>"Klik untuk melihat detail asesmen awal medis",
                        ));
                },
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value' => function($data){
                    echo CHtml::link("<i class='icon icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'id'=>$data->asesmen_awal_medis_id)); 
                }
            ),
            array(
                'header' => 'Hapus',
                'type' => 'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value' => function($data){
                    echo CHtml::link("<i class='entypo-trash'></i>",'javascript:;',array('onclick'=>'hapusRiwayat('.$data->asesmen_awal_medis_id.',this)',"rel"=>"tooltip","title"=>"Klik untuk menghapus Riwayat Asesmen Awal Dialisis"));
                }
            ),
            array(
                'header' => 'Cetak',
                'type' => 'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value' => function($data){
                echo CHtml::link(Yii::t('mds', '{icon}', 
                array('{icon}'=>'<i class="icon-print"></i>')), 
                    'javascript:void(0);', array('class'=>'',
                    'onclick'=>"print($data->asesmen_awal_medis_id);return false"))."&nbsp;";
                }
            ),
            array(
                'header' => 'Salin',
                'type' => 'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value' => function($data){
                    echo CHtml::link("<i class='icon icon-list'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'id'=>$data->asesmen_awal_medis_id, 'salin_id'=>1)); 
                }
            ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});cekListAwalMedis("load");}',
)); 
                
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetail',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Medis',
		'autoOpen'=>false,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetail" width="100%" height="500" style="border: none;">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>