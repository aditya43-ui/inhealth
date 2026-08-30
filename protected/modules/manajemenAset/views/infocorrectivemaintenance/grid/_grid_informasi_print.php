<?php
$data = $model->searchInformasi();
$data->pagination = false;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'corectivemaintenance-r-grid',
                            'dataProvider' => $data,
                            'template' => "{items}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '$row+1',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),   
                                array(
                                    'header'=>'Tanggal',
                                    'type' => 'raw',
                                    'value'=>'MyFormatter::formatDateTimeForUser($data->korektifmainten_tgl)'
                                ),
                                array(
                                    'header'=>' Nomor Permintaan',
                                    'type' => 'raw',
                                    'value'=>'$data->korektifmainten_no'
                                ),
                                array(
                                    'header'=>'Jenis Peralatan',
                                    'value'=>'$data->invperalatan_namabrg'
                                ),
                                array(
                                    'header'=>'Kode Aset',
                                    'type' => 'raw',
                                    'value'=>'$data->invperalatan_kode'
                                ),                                 
                                array(
                                    'header'=>'Nomor Seri',
                                    'type' => 'raw',
                                    'value'=>'$data->peralatan_noseri'
                                ), 
                                array(
                                    'header'=>'Lokasi Aset',
                                    'type' => 'raw',
                                    'value'=>function($data){
                                        return $data->lokasiaset_namalokasi;
                                    }
                                ),
                                array(
                                    'header'=>'Ruangan Aset',
                                    'type' => 'raw',
                                    'value'=>function($data){
                                        return $data->ruangpemohon_nama;
                                    }
                                ),                                                              
                                array(
                                    'header'=>'Nama Pemohon',
                                    'value'=>'$data->pemohon_nama'
                                ),
                                array(
                                    'header'=>'Keterangan',
                                    'value'=>'$data->korektifmainten_ket'
                                ),
                                [
                                    'header' => 'Tanggal Selesai',
                                    'value' => '!empty($data->korektifmainten_tglpakhir)?MyFormatter::formatDateTimeForUser($data->korektifmainten_tglpakhir,"long"):""'
                                ],                                
                                [
                                    'header' => 'Teknisi',
                                    'type' => 'raw',                                    
                                    'value' => function($data){
                                        $tek_ins = TeknisipemeliharaanasetT::model()->findAll(" korektifmainten_id = ".$data->korektifmainten_id." AND jenis_teknisi = 'Internal' ");
                                        if (!empty($tek_ins)){
                                            echo 'Internal :<br/>';
                                            echo '<ol style="margin:0px;">';
                                            foreach($tek_ins as $i => $det){
                                                echo '<li>'.$det->nama_teknisi.'</li>';
                                            }
                                            echo '</ol>';
                                        }
                                        echo '<br/>';
                                        $tek_ins = TeknisipemeliharaanasetT::model()->findAll(" korektifmainten_id = ".$data->korektifmainten_id." AND jenis_teknisi = 'Eksternal' ");
                                        if (!empty($tek_ins)){
                                            echo 'Eksternal :<br/>';
                                            echo '<ol style="margin:0px;">';
                                            foreach($tek_ins as $i => $det){
                                                echo '<li>'.$det->nama_teknisi.'</li>';
                                            }
                                            echo '</ol>';
                                        }
                                    }
                                ],
                                array(
                                    'header'=>'Status',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        return $data->korektifmainten_status;
                                    }
                                ),                                                                                           
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                                        
                                        ?>