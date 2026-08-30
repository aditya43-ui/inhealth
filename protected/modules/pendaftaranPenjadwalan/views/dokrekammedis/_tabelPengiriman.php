<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'ppdokumenpasienrmbaru-v-grid',
        'dataProvider'=>$model->searchPengiriman(),
        //'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih'.'<br>'.CHtml::checkBox("cekAll",true,array('onclick'=>'checkAll();')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField(\'Dokumen[pasien_id][]\', $data->pasien_id).
                    CHtml::hiddenField(\'Dokumen[tgl_rekam_medik][]\', $data->tgl_rekam_medik).
                    CHtml::hiddenField(\'Dokumen[pendaftaran_id][]\', $data->pendaftaran_id).
                    CHtml::hiddenField(\'Dokumen[no_rekam_medik][]\', $data->no_rekam_medik).
                    CHtml::hiddenField(\'Dokumen[ruangan_id][]\', $data->ruangan_id).
					CHtml::checkBox(\'cekList[]\', \'true\', array(\'onclick\'=>\'setUrutan()\', \'class\'=>\'cekList\'));
                    ',
            ),
            array(
                'header'=> 'Lokasi Rak',
                'type'=>'raw',
                'value'=>'
                    CHtml::dropDownList(\'Dokumen[lokasirak_id][]\',\'\',Chtml::listData(LokasirakM::model()->findAll(\'lokasirak_aktif=true\'), \'lokasirak_id\', \'lokasirak_nama\'), array(\'empty\'=>\'-- Pilih --\',\'class\'=>\'span2\', "style"=>"width:80px;"));'
            ),
            array(
                'header'=> 'Sub Rak',
                'type'=>'raw',
                'value'=>'
                    CHtml::dropDownList(\'Dokumen[subrak_id][]\',\'\',Chtml::listData(SubrakM::model()->findAll(\'subrak_aktif=true\'), \'subrak_id\', \'subrak_nama\'), array(\'empty\'=>\'-- Pilih --\', "style"=>"width:80px;"));'
            ),
            array(
                'header'=>'Warna Dokumen',
                'type'=>'raw',
                'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(), true)',
            ),
			array(
				'type' => 'raw',
				'header' => 'Tanggal Pendaftaran/<br> No. Pendaftaran',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)." ".$data->no_pendaftaran'
			),            
			'no_rekam_medik',
            'nama_pasien',
            //'tanggal_lahir',
            'jeniskelamin',
            array(
                'header'=>'Instalasi/<br> Ruangan',
                'value'=>'$data->instalasi_nama." ".$data->ruangan_nama ',
            ),            
            array(
				'header'=>'Kelengkapan Dokumen'.'<br><p style="margin: 0; text-align: center;">'.CHtml::checkBox("CheckKD",true,array('onclick'=>'checkAllKD();')).'</p>',
                'type'=>'raw',
                'value'=>'CHtml::checkBox(\'Dokumen[][kelengkapandokumen]\', true, array(\'class\'=>\'cekList;\'));',
				'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
        ),
            'afterAjaxUpdate'=>'function(id, data){
					var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
					jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
					jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
			}',
		)); 
	?> 
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#cekAll").attr("checked", "checked");
  $("#CheckKD").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
	function checkAll() {
		if ($("#cekAll").is(":checked")) {
			$('#ppdokumenpasienrmbaru-v-grid input[name*="cekList"]').each(function(){
			   $(this).attr('checked',true);
			})
		} else {
		   $('#ppdokumenpasienrmbaru-v-grid input[name*="cekList"]').each(function(){
			   $(this).removeAttr('checked');
			})
		}
	}
	function checkAllKD() {
		if ($("#CheckKD").is(":checked")) {
			$('#ppdokumenpasienrmbaru-v-grid input[name*="Dokumen"]').each(function(){
			   $(this).attr('checked',true);
			})
		} else {
		    $('#ppdokumenpasienrmbaru-v-grid input[name*="Dokumen"]').each(function(){
			   $(this).removeAttr('checked');
			})
		}
	}
</script>
