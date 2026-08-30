<div style="overflow: auto;">
    <?php
    $modRiwayat = new PemindahanpasienT();
    $modRiwayat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modRiwayat->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'riwayatcppt-t-grid',
        'dataProvider'=>$modRiwayat->searchRiwayat(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
          array(
              'header' => 'No.',
              'type' => 'raw',
              'value' => '$row+1',
              'htmlOptions'=>array('style'=>'text-align: center;')
          ),
          array(
            'header' => 'Waktu Keadaan',
            'type' => 'raw',
            'value' => '$data->waktukeadaan'
        ),
            array(
                'header' => 'Tanggal Pemindahan',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_pemindahan)'
            ),
             array(
                'header' => 'Jenis Pemindahan',
                'type' => 'raw',
                'value' => '$data->jenispemindahan'
            ),
            array(
                'header' => 'Ruangan Asal',
                'type' => 'raw',
                'value' => function ($data) {
                    if(!empty($data->ruanganasal)){
                        echo $data->ruanganasal->ruangan_nama;
                    }else{
                        echo "-";
                    }
                }
            ),
            array(
                'header' => 'Ruangan Tujuan',
                'type' => 'raw',
                'value' => '(!empty($data->ruangantujuan->ruangan_nama) ? $data->ruangantujuan->ruangan_nama : "-")'
            ),
            array(
                'header' => 'Instalasi Tujuan',
                'type' => 'raw',
                'value' => 'isset($data->instalasitujuan->instalasi_nama) ? $data->instalasitujuan->instalasi_nama : "-"'
            ),
            array(
                'header' => 'Dokter Mengetahui',
                'type' => 'raw',
                'value' => '(isset($data->pegawaimengetahui)? $data->pegawaimengetahui->namaLengkap: "")'
            ),
            array(
                'header' => 'Diserahkan Oleh',
                'type' => 'raw',
                'value' => '(isset($data->perawatpengirim)? $data->perawatpengirim->namaLengkap: "")'
            ),

            array(
                'header' => 'Detail',
                'type' => 'raw',
                'value'=>function($data) {
                        return CHtml::link('<icon class="icon-form-detail"></icon>', $this->createUrl("detail", array("pemindahanpasien_id"=>$data->pemindahanpasien_id)),
                                array(
                                    "target"=>"frameDetail",
                                    "onclick"=>"$('#dialogDetail').dialog('open');",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",

                                ));
                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Aksi',
                'type' => 'raw',
                'value'=>function($data) {
                        return CHtml::link('<i class="'.MyIcon::getIcons('cetak').'" style="font-size:14pt"></i>', 'javascript:void(0)', array(
                           'onclick'=>'print('.$data->pemindahanpasien_id.'); return false'
                       ));;
                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Batal',
                'type' => 'raw',
                'value'=>function($data) {
                        return CHtml::link('<i class="icon-form-silang" style="font-size:14pt"></i>', 'javascript:void(0)', array(
                           'onclick'=>'batal('.$data->pemindahanpasien_id.', ' . $data->pegawai_mengetahui. ', ' . Yii::app()->user->getState('pegawai_id'). '); return false'
                       ));;
                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Riwayat Peminahaan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'height' => 550,
            'resizable' => false
        ),
));
?>
<iframe name='frameDetail' width="100%" height="98%"></iframe>
<?php $this->endWidget(); ?>
