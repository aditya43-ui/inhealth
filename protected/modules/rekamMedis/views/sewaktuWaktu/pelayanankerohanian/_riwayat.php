<?php
$model->pendaftaran_id = $model->pendaftaran_id;
$model->pasienadmisi_id = $model->pasienadmisi_id;
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'riwayat-grid',
	'dataProvider'=>$model->searchRohani(),
                'template'=>"{summary}\n{items}\n{pager}",
                'replaceUrl'=>true,
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'header' => 'Tanggal Permintaan',
                        'name'=>'tgl_permintaan',
                        'value'=>'MyFormatter::formatdatetimeforuser($data->tgl_permintaan)'
                    ),
                    array(
                        'header' => 'Ruangan',
                        'name'=>'ruangan_id',
                        'value'=>'isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : " - "'
                    ),
                    array(
                        'header' => 'Petugas Kerohanian',
                        'name'=>'petugas_kerohanian',
                        'value'=>'isset($data->petugas_kerohanian) ? $data->petugas_kerohanian : "-"'
                    ),
                    array(
                        'header' => 'Tanggal Kedatangan Petugas',
                        'name'=>'petugas_kerohanian',
                        'value'=>'MyFormatter::formatdatetimeforuser($data->tgl_kedatangan_petugas)'
                    ),
                    array(
                        'header' => 'Edit',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $link = CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('ubahKerohanian', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'pelayanankerohanian_id'=>$data->pelayanankerohanian_id
                            )));
                            // $link .= CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                            //     'onclick'=>'hapusRiwayat('.$data->pelayanankerohanian_id.'); return false'
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
                            // $link = CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('ubahKerohanian', array(
                            //     'pendaftaran_id'=>$data->pendaftaran_id,
                            //     'pelayanankerohanian_id'=>$data->pelayanankerohanian_id
                            // )));
                            $link = CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                                'onclick'=>'hapusRiwayat('.$data->pelayanankerohanian_id.'); return false'
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
                                'onclick'=>'print('.$data->pelayanankerohanian_id.'); return false'
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
    function dialogRiwayat(textTitle){
        $('#titleRiwayat').html(textTitle);
        $('#dialogDetail').dialog('open');
    }

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusKerohanian'); ?>', {id: id}, function(data) {
                    if (data.ok === 1) {
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

    function print(pelayanankerohanian_id)
    {
        window.open('<?php echo $this->createUrl('printKerohanian'); ?>&pelayanankerohanian_id='+pelayanankerohanian_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
</script>
