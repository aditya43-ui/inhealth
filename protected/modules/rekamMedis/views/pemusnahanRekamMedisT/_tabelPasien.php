<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pasien-m-grid',
    'dataProvider'=>$modPasien->searchKunjunganPasienTerakhir(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih'.CHtml::checkBox('pilihsemua', 1, array('onchange'=>'pilihSemua(this); $(\'#RKPemusnahanrekammedisT_keterangan\').blur();')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField("Dokumen[".$row."][pasien_id]", $data->pasien_id).
                    CHtml::hiddenField("Dokumen[".$row."][pendaftaran_id]", $data->pendaftaran_id).
                    CHtml::hiddenField("Dokumen[".$row."][ruanganakhir_id]", $data->ruangan_id).
                    CHtml::hiddenField("Dokumen[".$row."][instalasiakhir_id]", $data->instalasi_id).
                    CHtml::hiddenField("Dokumen[".$row."][inaktifrekammedisdet_id]", $data->inaktifrekammedisdet_id).
                    CHtml::checkBox("Dokumen[".$row."][cekList]", false, array("onclick"=>"$(\'#RKPemusnahanrekammedisT_keterangan\').blur();", "class"=>"cekList"));
                    ',
            ),
            array(
                'header' => 'Lokasi', 
                'name' => 'satelitrm_nama',
            ),
            array(
                'header' => 'Lokasi Rak', 
                'name' => 'lokasirak_nama',
            ),
            array(
                'header' => 'Sub Rak', 
                'name' => 'subrak_nama',
            ),
            array(
                'header'=>'No. Rekam Medik',
                'name'=>'no_rekam_medik',
            ),
            array(
                'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                'value' => function($data){
                    echo MyFormatter::formatDateTimeForUser($data->tglkunjunganterakhir)."<br>".$data->no_pendaftaran;
                }
            ),
            array(
                'name'=>'nama_pasien',
                'value'=>'$data->namadepan.$data->nama_pasien',
            ),
            array(
                'name'=>'tanggal_lahir',
                'value'=>'MyFormatter::formatDateTimeFOrUser($data->tanggal_lahir)',
            ),
            'jeniskelamin',
            'alamat_pasien',
            array(
                'header' => 'Instalasi/<br>Ruangan',
                'value' => function($data){
                    echo $data->instalasi_nama."<br>".$data->ruangan_nama;
                }
            ),
            array(
                'header'=>'Masa Aktif',
                'type'=>'raw',
                'value'=>function($data, $row) {
                    $sekarang = new DateTime(date('Y-m-d'));
                    $terakhir = new DateTime($data->tglkunjunganterakhir);
                    $selisih = $sekarang->diff($terakhir);
                    
                    $str = $selisih->y." Tahun ".$selisih->m." Bulan ".$selisih->d." Hari";
                    
                    return $str
                        .CHtml::hiddenField("Dokumen[".$row."][masa_fungsi]", $str);
                }
            ),
            array(
                'header'=>'Status Scan',
                'htmlOptions' => array('style'=>'text-align: center;'),
                'value' => function($data) {
                    $dok = DokfilermR::model()->findAllByAttributes(array(
                        'pasien_id'=>$data->pasien_id,
                    ));
                    if (count($dok) == 0) {
                        echo "<i style='color: black; font-size: 14px' class='glyphicon glyphicon-minus'>";
                    } else {
                        echo "<i style='color: black; font-size: 14px' class='glyphicon glyphicon-ok'>";
                    }
                    
                }
            ), 
    ),
    'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
    }',
)); ?> 
<?php $dokumen = CHtml::activeId($model, 'pasien_id'); ?>