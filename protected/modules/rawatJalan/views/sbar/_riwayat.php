<?php
$modRiwayat = new SbarT();
$modRiwayat->pendaftaran_id = $modPendaftaran->pendaftaran_id;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayatsbar-grid',
    'dataProvider' => $modRiwayat->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'replaceUrl' => true,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'name' => 'Tanggal SBAR',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_sbar)',
        ),
        array(
            'name' => 'Pegawai SBAR',
            'type' => 'raw',
            'value' => '$data->pegawaiSbar->namaLengkap',
        ),
        array(
            'name' => 'Situation',
            'type' => 'raw',
            'value' => '$data->situation',
        ),
        array(
            'name' => 'Background',
            'type' => 'raw',
            'value' => '$data->background',
        ),
        array(
            'name' => 'Assesment',
            'type' => 'raw',
            'value' => '$data->assesmen',
        ),
        array(
            'name' => 'Recomendation',
            'type' => 'raw',
            'value' => '$data->rekomendasi',
        ),
        array(
            'header' => 'Status Verifikasi',
            'type' =>'raw',
            'value' => function($data){
                $html = CHtml::Link("<i class='glyphicon glyphicon-check' style='font-size: 12pt'></i>",Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/verifikasi', array("sbar_id"=>$data->sbar_id)),
                       array("class"=>"",
                             "target"=>"frmVerifikasi",
                             "onclick"=>"$(\"#dialogVerifikasi\").dialog(\"open\");",
                             "rel"=>"tooltip",
                             "title"=>"Klik untuk verifikasi",
                       ));

                  if($data->isstatusverifikasi == true){
                    $html = 'Sudah Diverifikasi oleh : '.(isset($data->pegawaiverifikasi)? $data->pegawaiverifikasi->namaLengkap:"").'<br/>'.
                            'Tgl : '.(!empty($data->tgl_verifikasi)? MyFormatter::formatDateTimeForUser($data->tgl_verifikasi):"").'<br/>'.
                        CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/detailverifikasi', array("sbar_id"=>$data->sbar_id)),
                           array("class"=>"",
                                 "target"=>"frmDetailVerifikasi",
                                 "onclick"=>"$(\"#dialogDetailVerifikasi\").dialog(\"open\");",
                                 "rel"=>"tooltip",
                                 "title"=>"Klik untuk Detail Verifikasi",
                           ));
                  }
                return $html;
            },
            'htmlOptions' => array(
                'style' => 'text-align: center; width: 150px'
            ),
        ),
        array(
            'header' => 'Aksi',
            'type' => 'raw',
            'value' => function($data){
                // return CHtml::link('<i class="icon-pencil"></i>', '#', array(
                //         'onclick' => "parent.editImplementasi(" . $data->pasien_id . ", '" . $typeinstalasi . "', " . $data->catatanimplementasi_id . "); return false;"
                // ));
                // return CHtml::link('<i class="icon-trash"></i>', '#', array(
                //         'onclick' => "hapusImplementasi(" . $data->catatanimplementasi_id . "); return false;"
                // ));
                return CHtml::link('<i class="glyphicon glyphicon-pencil" style="font-size: 12pt"></i>', Yii::app()->controller->createUrl('index', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    'sbar_id'=>$data->sbar_id,
                    'type'=>$_GET['type'],
                    'frame'=>$_GET['frame']
                )),array("rel"=>"tooltip","title"=>"Klik untuk ubah sbar")).' '.CHtml::link('<i class="glyphicon glyphicon-trash" style="font-size: 12pt"></i>', 'javascript:void(0)', array(
                        'onclick' => "hapusRiwayat(" . $data->sbar_id . "); return false;","rel"=>"tooltip","title"=>"Klik untuk hapus sbar"
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
<br />
<div>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printRiwayat(\'PRINT\')')); ?>
</div>

<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
  'id'=>'dialogVerifikasi',
      // additional javascript options for the dialog plugin
      'options'=>array(
      'title'=>'Review & Verifikasi SBAR',
      'autoOpen'=>false,
      'minWidth'=>900,
      'minHeight'=>100,
      'resizable'=>false,
      'close'=>"js:function(){ $.fn.yiiGridView.update('riwayatsbar-grid', {
					data: $(this).serialize()
				}); }",
       ),
  ));
?>
<iframe src="" name="frmVerifikasi" width="100%" height="500"> </iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>

<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
  'id'=>'dialogDetailVerifikasi',
      // additional javascript options for the dialog plugin
      'options'=>array(
      'title'=>'Hasil Review SBAR',
      'autoOpen'=>false,
      'minWidth'=>600,
      'minHeight'=>100,
      'resizable'=>false,
       ),
  ));
?>
<iframe src="" name="frmDetailVerifikasi" width="100%" height="500"> </iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>



<script type="text/javascript">
    function printRiwayat(caraPrint)
    {
      var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
        window.open('<?php echo $this->createUrl('printRiwayat'); ?>&pendaftaran_id=' + pendaftaran_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post("<?php echo $this->createUrl('hapusSbar'); ?>", {
                    id: id,
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayatsbar-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>
