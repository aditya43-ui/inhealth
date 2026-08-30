<div style="overflow-x: auto;">
    <?php
    $modList = new PrepostoperasiT();
    $modList->unsetAttributes();
    $modList->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modList->jenischecklist = "Post Operasi";
    if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI){
      $modList->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    }

    $prov = $modList->search();

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'postoperasi-grid',
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
                'header'=>'Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->ruanganasal->ruangan_nama',
            ),
              array(
                'header'=>'Ruangan Tujuan',
                'type'=>'raw',
                'value'=>'$data->ruangantujuan->ruangan_nama',
            ),
            array(
                'header'=>'Petugas Ruangan Asal',
                'type'=>'raw',
                'value'=>function($data) {
                    return MyFormatter::formatDateTimeForUser($data->tanggal_penginputan).' '.
                    CHtml::link(
                            '<icon class="icon-form-detail"></icon>', Yii::app()->createUrl("/bedahSentral/ChecklistPostOperasi/detail", array("prepostoperasi_id"=>$data->prepostoperasi_id,'typeruangan'=>'asal', 'type'=>$_GET['type'], 'frame'=>$_GET['frame'])),
                            array(
                                "target"=>"iframeDetailAsal",
                                "onclick"=>"$('#dialogDialogAsal').dialog('open');",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk Melihat detail Ruangan Asal",

                            )).' '.(($data->ruanganasal_id == Yii::app()->user->getState("ruangan_id")) ? CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('index', array(
                      'pendaftaran_id'=>$data->pendaftaran_id,
                        'prepostoperasi_id'=>$data->prepostoperasi_id,
                        'aksitype'=>'ubahasal', 
                        'type'=>$_GET['type'],
                         'frame'=>$_GET['frame']
                    ))):"");
                }
            ),
            array(
                'header'=>'Petugas Ruangan Tujuan',
                'type'=>'raw',
                'value'=>function($data) {
                  $findCheck = PrepostoperasiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id,'ruangantujuan_id' => Yii::app()->user->getState("ruangan_id"),'isterima'=>false,'jenischecklist'=>'Post Operasi'));
                  $html = "";
                    if($data->isterima == false){
                      $html .= "Belum melakukan pengisian ".(!empty($findCheck) ?
                                CHtml::link('<i class="icon-form-check"></i>', $this->createUrl("ChecklistPostOperasi/index", array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                    'prepostoperasi_id' => $findCheck->prepostoperasi_id,
                                    'isterima' =>true, 
                                    'type'=>$_GET['type'],
                                     'frame'=>$_GET['frame']
                                ))):"");
                    }else{
                      $html .= MyFormatter::formatDateTimeForUser($data->tglpengisian_ruangantujuan).' '.
                      CHtml::link(
                              '<icon class="icon-form-detail"></icon>', Yii::app()->createUrl("/bedahSentral/ChecklistPostOperasi/detail", array("prepostoperasi_id"=>$data->prepostoperasi_id,'typeruangan'=>'tujuan', 'type'=>$_GET['type'], 'frame'=>$_GET['frame'])),
                              array(
                                  "target"=>"iframeDetailTujuan",
                                  "onclick"=>"$('#dialogDialogTujuan').dialog('open');",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Melihat detail Ruangan Tujuan",

                              ));
                    }

                    $html .= ' '.(($data->ruangantujuan_id == Yii::app()->user->getState("ruangan_id")) ? CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('index', array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                              'prepostoperasi_id'=>$data->prepostoperasi_id,
                              'aksitype'=>'ubahtujuan', 
                              'type'=>$_GET['type'],
                               'frame'=>$_GET['frame']
                          ))):"");
                    return $html;

                }
            ),
            array(
                'header'=>'Aksi',
                'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                        'onclick'=>'hapusRiwayat('.$data->prepostoperasi_id.'); return false'
                    ));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center;',
                )
            ),
            array(
                'header'=>'Print',
                'type'=>'raw',
                'value'=>function($data) {
                  return CHtml::link('<i class="entypo-print" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                      'onclick'=>'printRiwayat('.$data->prepostoperasi_id.'); return false'
                  ));
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


<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDialogAsal',
    'options'=>array(
        'title'=>'Detail Petugas Pengisian Ruangan Asal',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo '<iframe name="iframeDetailAsal" style="border: 0px; width:100%; height: 530px; "></iframe>';

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDialogTujuan',
    'options'=>array(
        'title'=>'Detail Petugas Pengisian Ruangan Tujuan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo '<iframe name="iframeDetailTujuan" style="border: 0px; width:100%; height: 530px; "></iframe>';

$this->endWidget();
?>


<script type="text/javascript">
    function printRiwayat(prepostoperasi_id) {
        window.open("<?php echo $this->createUrl('print'); ?>&prepostoperasi_id="+prepostoperasi_id,"",'location=_new, width=900px');
    }

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusRiwayat'); ?>', {
                    id: id,
                }, function(data) {
                    if (data.sukses == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('praoperasi-grid', {
                      			data: $(this).serialize()
                      		});
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

</script>
