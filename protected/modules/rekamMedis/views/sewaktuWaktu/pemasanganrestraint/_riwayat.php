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
                        'header' => 'Tanggal Observasi',
                        'name'=>'tanggal',
                        'value'=>'isset($data->tanggal) ? MyFormatter::formatdatetimeforuser($data->tanggal) : "-"'
                    ),
                    array(
                        'header' => 'Jam Observasi',
                        'name'=>'jam',
                        'value'=>'isset($data->jam) ? $data->jam : "-"'
                    ),
                    array(
                        'header' => 'Perawat Pengisi',
                        'name'=>'perawat_pengisi',
                        'value'=>'isset($data->perawat_pengisi) ? $data->perawat_pengisi : "-"'
                    ),
                    array(
                        'header' => 'Detail Observasi',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $link = CHtml::link('<i class="icon-form-detail" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('DetailPemasanganRestraint', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'observasipemasanganrestrain_id'=>$data->observasipemasanganrestrain_id,
                                'ubah'=>true,"frame"=>true
                            )),array("target"=>"frameasesmenawal","rel"=>"tooltip","title"=>"Klik untuk Melihat Detail", "onclick"=>"dialogRiwayat()", "dialog-text"=>"Detail Observasi Pemasangan Restraint"));
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
                            $link = CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('IndexPemasanganRestraint', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'observasipemasanganrestrain_id'=>$data->observasipemasanganrestrain_id,
                                'ubah'=>true
                            )));
                            // $link .= CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                            //     'onclick'=>'hapusRiwayat('.$data->observasipemasanganrestrain_id.'); return false'
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
                            // $link = CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('IndexPemasanganRestraint', array(
                            //     'pendaftaran_id'=>$data->pendaftaran_id,
                            //     'observasipemasanganrestrain_id'=>$data->observasipemasanganrestrain_id,
                            //     'ubah'=>true
                            // )));
                            $link = CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                                'onclick'=>'hapusRiwayat('.$data->observasipemasanganrestrain_id.'); return false'
                            ));
                            return $link;
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
                    // array(
                    //     'header'=>'Print',
                    //     'type'=>'raw',
                    //     'value'=>function($data) {
                    //         return CHtml::link('<i class="entypo-print" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                    //             'onclick'=>'print('.$data->observasipemasanganrestrain_id.'); return false'
                    //         ));
                    //     },
                    //     'htmlOptions'=>array(
                    //         'style'=>'text-align: center;',
                    //     )
                    // ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
			'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'buttons'=>array(
				array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
				array('label'=>'', 'items'=>array(
					array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
					array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),

				)),       
			),
			'htmlOptions'=>array('style'=>'float:right')
	//        'htmlOptions'=>array('class'=>'btn')
		)); ?>
<script type="text/javascript">
    function dialogRiwayat(){
        $('#dialogDetail').dialog('open');
    }

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusPemasanganRestraint'); ?>', {id: id}, function(data) {
                    if (data.ok === 1) {
                        window.location.replace("<?php echo $this->createUrl('IndexPemasanganRestraint'); ?>&pendaftaran_id=<?= $model->pendaftaran_id;?>");
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

    // function print(observasipemasanganrestrain_id)
    // {
    //     window.open('<?php //echo $this->createUrl('printPemasanganRestraint'); ?>&observasipemasanganrestrain_id='+observasipemasanganrestrain_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    // }
</script>

<?php                   
		$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printPemasanganRestraint&pendaftaran_id='.$model->pendaftaran_id);
		
$js = <<< JSCRIPT
		function print(caraPrint){
			window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
		}
		
JSCRIPT;
		Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
	?>			