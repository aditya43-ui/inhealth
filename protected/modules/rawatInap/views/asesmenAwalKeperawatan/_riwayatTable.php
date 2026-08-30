<?php
$model->pendaftaran_id = $model->pendaftaran_id;
$model->pasienadmisi_id = $model->pasienadmisi_id;
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'riwayataskep-grid',
	'dataProvider'=>$model->searchRiwayat(),
                'template'=>"{summary}\n{items}\n{pager}",
                'replaceUrl'=>true,
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                       'name'=>'Tanggal & Jam Pengkajian',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_assesmen_awal)',
                    ),
                    array(
                        'header'=>'Dokter Pemeriksa',
                        'type'=>'raw',
                        'value'=>function ($data){
                            return $data->dokterpemeriksa->namaLengkap;
                        }
                    ),
                    array(
                        'header'=>'Perawat Pengkaji',
                        'type'=>'raw',
                        'value'=>'$data->paramedis_nama'
                    ),array(
                        'header'=>'Jenis Asesmen',
                        'type'=>'raw',
                        'value'=>function ($data){
                          $jenisasesmen = "";

                          if($data->jenisasesmen == 'asesmenri_anak'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Anak";
                          }else if($data->jenisasesmen == 'asesmenri_dewasa'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Dewasa";
                          }else if($data->jenisasesmen == 'asesmenri_neonatus'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Neonatus";
                          }else if($data->jenisasesmen == 'asesmenri_geriatri'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Geriatri";
                          }else if($data->jenisasesmen == 'asesmenri_obgyn'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Obgyn";
                          }
                            return $jenisasesmen;
                        }
                    ),
                array(
                        'header'=>'Detail',
                        'type'=>'raw',
                        'value'=>function($data) {
                          $jenisasesmen = "";
                          $ruangan = ucfirst(strtolower(Yii::app()->user->getState("instalasi_nama")));

                          if($data->jenisasesmen == 'asesmenri_anak'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Pasien ".$ruangan." Anak";
                          }else if($data->jenisasesmen == 'asesmenri_dewasa'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Pasien ".$ruangan." Dewasa";
                          }else if($data->jenisasesmen == 'asesmenri_neonatus'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Pasien ".$ruangan." Neonatus";
                          }else if($data->jenisasesmen == 'asesmenri_geriatri'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Pasien Geriatri";
                          }else if($data->jenisasesmen == 'asesmenri_obgyn'){
                            $jenisasesmen = "Asesmen Awal Keperawatan Obgyn";
                          }

                          return CHtml::link(
                              '<icon class="icon-form-detail"></icon>', Yii::app()->createUrl("/rawatInap/AsesmenAwalKeperawatan/detail", array("asesmenawalkeperawatan_id"=>$data->asesmenawalkeperawatan_id,"frame"=>true)),
                              array(
                                  "target"=>"iframeDetail",
                                  "onclick"=>"dialogRiwayat('".$jenisasesmen."');",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Melihat Detail ".$jenisasesmen,

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
                            return CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('index', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'pasienadmisi_id'=>$data->pasienadmisi_id,
                                'asesmenawalkeperawatan_id'=>$data->asesmenawalkeperawatan_id,
                            )));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
                array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="icon-trash" style="font-size: 14pt"></i>', '#', array(
                                'onclick'=>'hapusRiwayat('.$data->asesmenawalkeperawatan_id.'); return false'
                            ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
            array(
                        'header'=>'Cetak',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="icon-print" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                                'onclick'=>'printRiwayat('.$data->asesmenawalkeperawatan_id.'); return false'
                            ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
<?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Riwayat <span id="titleRiwayat"></span>',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 600,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetail' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function dialogRiwayat(textTitle){
        $('#titleRiwayat').html(textTitle);
        $('#dialogDetail').dialog('open');
    }

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusRiwayat'); ?>', {id: id}, function(data) {
                    if (data.sukses === 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayataskep-grid', {
                            data: $(this).serialize()
                        });
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    function printRiwayat(asesmenawalkeperawatan_id)
    {
        window.open('<?php echo $this->createUrl('print'); ?>&asesmenawalkeperawatan_id='+asesmenawalkeperawatan_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
</script>
