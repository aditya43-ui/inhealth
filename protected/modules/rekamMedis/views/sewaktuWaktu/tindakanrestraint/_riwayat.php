<?php
$model->pendaftaran_id = $model->pendaftaran_id;
$model->pasienadmisi_id = $model->pasienadmisi_id;
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'riwayat-grid',
	'dataProvider'=>$model->searchPasien(),
                'template'=>"{summary}\n{items}\n{pager}",
                'replaceUrl'=>true,
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'header' => 'Tanggal Pengkajian',
                        'name'=>'tgl_permintaan',
                        'value'=>'isset($data->tanggal_pengkajian) ? MyFormatter::formatdatetimeforuser($data->tanggal_pengkajian) : "-"'
                    ),
                    array(
                        'header' => 'Petugas Pengkaji',
                        'name'=>'dilakukanoleh',
                        'value'=>'isset($data->dilakukanoleh) ? $data->dilakukanoleh : "-"'
                    ),
                    array(
                        'header' => 'Dokter yang merawat',
                        'name'=>'dokteryang_merawat',
                        'value'=>'isset($data->dokteryang_merawat) ? $data->dokteryang_merawat : "-"'
                    ),
                    array(
                        'header' => 'Pemberi Informasi',
                        'name'=>'pemberi_informasi',
                        'value'=>'isset($data->pemberi_informasi) ? $data->pemberi_informasi : "-"'
                    ),
                    array(
                        'header' => 'Penerima Informasi',
                        'name'=>'penerima_informasi',
                        'value'=>'isset($data->penerima_informasi) ? $data->penerima_informasi : "-"'
                    ),
                    array(
                        'header' => 'Detail Tindakan Restraint',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $link = CHtml::link('<i class="icon-form-detail" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('DetailTindakanRestraint', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'observasirestrain_id'=>$data->observasirestrain_id,
                                'ubah'=>true,"frame"=>true
                            )),array("id"=>"$data->observasirestrain_id","target"=>"frameasesmenawal","rel"=>"tooltip","title"=>"Klik untuk Melihat Detail", "onclick"=>"dialogRiwayat()", "dialog-text"=>"Riwayat Asesmen Awal Medis"));
                            return $link;
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
                    array(
                        'header' => 'Edit',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $link = CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('IndexTindakanRestraint', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'observasirestrain_id'=>$data->observasirestrain_id,
                                'ubah'=>true
                            )));
                            // $link .= CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                            //     'onclick'=>'hapusRiwayat('.$data->observasirestrain_id.'); return false'
                            // ));
                            return $link;
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
                    array(
                        'header' => 'Hapus',
                        'type'=>'raw',
                        'value'=>function($data) {
                            // $link = CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('IndexTindakanRestraint', array(
                            //     'pendaftaran_id'=>$data->pendaftaran_id,
                            //     'observasirestrain_id'=>$data->observasirestrain_id,
                            //     'ubah'=>true
                            // )));
                            $link = CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                                'onclick'=>'hapusRiwayat('.$data->observasirestrain_id.'); return false'
                            ));
                            return $link;
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
                                'onclick'=>'print('.$data->observasirestrain_id.'); return false'
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

<script type="text/javascript">
    function dialogRiwayat(){
        $('#dialogDetail').dialog('open');
    }

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusTindakanRestraint'); ?>', {id: id}, function(data) {
                    if (data.ok === 1) {
                        window.location.replace("<?php echo $this->createUrl('IndexTindakanRestraint'); ?>&pendaftaran_id=<?= $model->pendaftaran_id;?>");
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayat-grid', {
                            data: $(this).serialize()
                        });
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    function print(observasirestrain_id)
    {
        window.open('<?php echo $this->createUrl('printTindakanRestraint'); ?>&observasirestrain_id='+observasirestrain_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
</script>
