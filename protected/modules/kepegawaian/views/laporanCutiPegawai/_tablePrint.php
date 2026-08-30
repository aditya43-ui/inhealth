<?php

$row = '$row+1';
$prov = $model->search();
$prov->pagination = false;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'laporancutipegawai-v-grid',
                'dataProvider'=>$model->searchPrint(),              
				'itemsCssClass'=>'table border',
				'enableSorting'=>false,
				'template'=>"{items}",
                'columns'=>array(
                    array(
						'header' => 'No.',
						'value' => $row
					),
                    'jeniscuti_nama',
                    //'pegawai_id',
                    //'gelardepan',
                    array(
						'header' => 'Nama Pegawai',
						'value' => '$data->namaLengkap'
					),
					array(
						'header' => 'Tanggal Cuti',
						'value' => 'MyFormatter::formatDateTimeForUser($data->tglmulaicuti)." s/d ".MyFormatter::formatDateTimeForUser($data->tglakhircuti)'
					),                   
                    array(
						'header'=>'Lama',
                        'value'=>'$data->lamacuti." Hari"',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        )
                    ),                   
                    'keperluancuti',                    
                    array(
                        'name'=>'tglditetapkanskcuti',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglditetapkanskcuti)',
                    ),                                                          
                    array(
                        'name'=>'nama_menyetujui',
                        'value'=>'$data->gelardepan_menyetujui.$data->nama_menyetujui.", ".$data->gelarbelakang_menyetujui',
                    ),
					'status_cuti',
                    array(
                        'name'=>'nama_pengganti',
                        'value'=>'$data->gelardepan_pengganti.$data->nama_pengganti.", ".$data->gelarbelakang_pengganti',
                    ),
                ),
            ));

?>