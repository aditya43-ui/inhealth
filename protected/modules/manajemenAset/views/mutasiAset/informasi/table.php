<?php
/**
* issue RSST-1620
* - untuk menampilkan data ke dalam bentuk tabel
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* 
* 
*/
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Mutasi Aset</strong></div>
    </div>
    <div class="panel-body overflow-x">
        
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'informasi-mutasi-grid',
                'dataProvider' => $model->searchInformasi(),
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),                    
                    array(
                        'header' => 'No & Tanggal Mutasi',
                        'type' => 'raw',                         
                        'value' => function($data){
                            return CHtml::htmlButton($data->nomutasiaset."/<br/>".MyFormatter::formatDateTimeForUser($data->tglmutasiaset,'long'),array("class"=>"btn btn-default","onclick"=>"print(this);","rel"=>"tooltip","title"=>"Klik untuk Detail Mutasi Aset", 'id' => $data->mutasiaset_id, "target" => "empty"));
                        }
                    ),                    
                    array(
                        'header' => 'Ruangan Asal',
                        'type' => 'raw', 
                        'value' => '$data->ruanganasal_nama'
                    ),
                    [
                        'header' => 'Lokasi Aset Asal',
                        'type' => 'raw',
                        'value' => '$data->lokasiasal_nama'
                    ],
                    array(
                        'header' => 'Ruangan Tujuan',
                        'type' => 'raw', 
                        'value' => '$data->ruangantujuan_nama'
                    ),
                    [
                        'header' => 'Lokasi Aset Tujuan',
                        'type' => 'raw',
                        'value' => '$data->lokasitujuan_nama'
                    ],
                    [
                        'header' => 'Pegawai Penyerahan',
                        'name' => 'NamaLengkapMenyerahkan'
                    ],
                    array(
                        'header' => 'Pegawai Penerima',
                        'type' => 'raw',
                        'value' => function($data){
                            echo $data->NamaLengkapPenerima;
                            
                            echo !empty($data->pegpenerima_tgl)?'<hr/>'.MyFormatter::formatDateTimeForUser($data->pegpenerima_tgl):null;
                        }
                    ),
                    array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'value'=>function($data){
                                return CHtml::Link("<i class='".MyIcon::getIcons('lihat2')."'></i>",Yii::app()->controller->createUrl("lihatDetail",array("mutasiaset_id"=>$data->mutasiaset_id,"detail"=>'detail')),
                                    array("class"=>"", 
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat detail mutasi aset",
                                    ));
                            },
                    ),
                    [
                        'header' => 'Verifikasi',
                        'type' => 'raw',
                        'name' => 'tanggal_verifikasi',
                        'value' => function($data) {
                            
                            $cekpeg = PegawaiM::model()->find(" unitkerja_id::text IN (SELECT lookup_value FROM lookup_m where lookup_type = 'verifikasiaset' GROUP BY lookup_value) AND pegawai_id = ".Yii::app()->user->getState('pegawai_id')." ");
                                
                                
                            if ($data->status_verifikasi == 'BELUM VERIFIKASI') {
                                if (!empty($cekpeg)) {
                                    return CHtml::link("<i class='entypo entypo-check'></i>", 'javascript:;', [
                                                'onclick' => 'toastr.warning("Hanya Pengurus Verifikasi yang dapat melakukan verifikasi","Perhatian!")',
                                                'rel' => 'tooltip',
                                                'title' => 'Verifikasi Data',
                                                'class' => 'btn btn-success'
                                    ]);
                                } else {
                                    return CHtml::link("<i class='entypo entypo-check'></i>", Yii::app()->controller->createUrl("verifikasi",array("mutasiaset_id"=>$data->mutasiaset_id)), [
                                                'rel' => 'tooltip',
                                                'title' => 'Verifikasi Data',
                                                'class' => 'btn btn-success']);
                                }
                                
                            } else {
                                return $data->status_verifikasi;
                            }
                        }
                    ],
                    array(
                        'header' => 'Status',
                        'type'=>'raw',
                        'value' => function($data){                                                                               
//                                    verifikasiaset
                        
                            if (empty($data->mutasiaset_status) || $data->mutasiaset_status == ParamsConst::STATUS_MUTASI_ASET_BELUM){
                                
                                $dis = "disabled=true";
                                if ($data->is_disetujui)
                                    $dis = "";
                                                                
                                
                                echo "<p class='btn-group'>";
                                echo ParamsConst::getWrStatusMutasiAset(ParamsConst::STATUS_MUTASI_ASET_BELUM,$data, $dis);
                                echo "</p>";
                            }elseif ($data->mutasiaset_status){
                                return ParamsConst::getWrStatusMutasiAset($data->mutasiaset_status);
                            }                            
                        },
                        'headerHtmlOptions'=>array(
                            'style'=>'text-align:center;'
                        ),
                        'htmlOptions'=>array(
                                    'style'=>'width: 220px; text-align: center;',
                                ),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        
    </div>
</div>	

