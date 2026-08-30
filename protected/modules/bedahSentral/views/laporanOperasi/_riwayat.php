<style>

.fa-disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

</style>

<?php
$modRiwayat = new LaporanoperasiT();
$modRiwayat->pasien_id = $modPendaftaran->pasien_id;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayatlaporanoperasi-grid',
    'dataProvider' => $modRiwayat->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'replaceUrl' => true,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No Pendaftaran',
            'type' => 'raw',
            'value' => '$data->pendaftaran->no_pendaftaran',
        ),
        array(
            'header' => 'Tgl Pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)',
        ),
        
        array(
            'name' => 'Tgl. Operasi',
            'type' => 'raw',
            'value' => '(!empty($data->rencanaoperasi)? MyFormatter::formatDateTimeForUser($data->rencanaoperasi->tglrencanaoperasi):"")',
        ),
        array(
            'name' => 'Jenis Operasi',
            'type' => 'raw',
            'value' => '(!empty($data->operasi)?$data->operasi->operasi_nama:"")',
        ),
        array(
            'name' => 'Golongan Operasi',
            'type' => 'raw',
            'value' => '$data->golonganoperasi_keterangan',
        ),
        [
            'header' => 'Dokter Bedah',
            'value' => '!empty($data->dokterpelaksana)?$data->dokterpelaksana->namaLengkap:"-"'
        ],
        array(
            'header' => 'Detail',
            'type' =>'raw',
            'value' => function($data){
                return CHtml::Link("<i class='icon-form-detail'></i>",Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/detail', array("laporanoperasi_id"=>$data->laporanoperasi_id)),
                       array("class"=>"",
                             "target"=>"frmDetail",
                             "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                             "rel"=>"tooltip",
                             "title"=>"Klik untuk detail laporan operasi",
                       ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center; width: 150px'
            ),
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function($data){
                
                $ruangan_login = Yii::app()->user->getState('ruangan_id');
                $ruangan_create = $data->create_ruangan;

                if($ruangan_login != $ruangan_create) {      
                    return CHtml::link('<i class="icon-form-ubah fa-disabled"></i>', 'javascript:void(0)',array("rel"=>"tooltip","title"=>""
                ));          
                } else {

                    return CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('index', array(
                        'pendaftaran_id'=>$data->pendaftaran_id,
                        'laporanoperasi_id'=>$data->laporanoperasi_id,
                        'jenis'=>'ubah',
                        'type'=> !empty($_GET['type']) ? $_GET['type'] : '',
                        'frame'=> !empty($_GET['frame']) ? $_GET['frame'] : '',
                    )),array("rel"=>"tooltip","title"=>"Klik untuk ubah laporan operasi"));
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center; width: 80px'
            ),
        ),
        array(
            'header' => 'Salin',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::link('<i class="icon-form-copy"></i>', Yii::app()->controller->createUrl('index', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    'laporanoperasi_id'=>$data->laporanoperasi_id,
                    'jenis'=>'salin',
                    'type'=> !empty($_GET['type']) ? $_GET['type'] : '',
                    'frame'=> !empty($_GET['frame']) ? $_GET['frame'] : '',
                )),array("rel"=>"tooltip","title"=>"Klik untuk salin laporan operasi"));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center; width: 80px'
            ),
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function($data){

                $ruangan_login = Yii::app()->user->getState('ruangan_id');
                $ruangan_create = $data->create_ruangan;

                if($ruangan_login != $ruangan_create) {
                    return CHtml::link('<i class="icon-form-sampah fa-disabled"></i>', 'javascript:void(0)', array(
                    "rel"=>"tooltip","title"=>""
                ));
                } else {
                    return CHtml::link('<i class="icon-form-sampah" style="font-size: 12pt"></i>', 'javascript:void(0)', array(
                        'onclick' => "hapusRiwayat(" . $data->laporanoperasi_id . "); return false;","rel"=>"tooltip","title"=>"Klik untuk hapus laporan operasi"
                ));
                }

                
            },
            'htmlOptions' => array(
                'style' => 'text-align: center; width: 80px'
            ),
        ),
        array(
            'header' => 'Cetak',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::link('<i class="icon-print"></i>', 'javascript:void(0)', array(
                        'onclick' => "print(" . $data->laporanoperasi_id . "); return false;","rel"=>"tooltip","title"=>"Klik untuk cetak laporan operasi"
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center; width: 80px'
            ),
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
  'id'=>'dialogDetail',
      'options'=>array(
      'title'=>'Detail Laporan Operasi',
      'autoOpen'=>false,
      'minWidth'=>1000,
      'minHeight'=>100,
      'resizable'=>false,
       ),
  ));
?>
<iframe src="" name="frmDetail" width="100%" height="500"> </iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>