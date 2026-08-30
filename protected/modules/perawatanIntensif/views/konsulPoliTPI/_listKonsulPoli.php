<table class="items table table-striped table-condensed" id="tblListKonsul">
    <thead>
        <tr>
            <th>Tanggal Konsul</th>
            <th>No. Permintaan</th>
            <th>No. Pendaftaran</th>
            <th>Poliklinik Asal</th>
            <th>Poliklinik Tujuan</th>
            <th>Permasalahan</th>
			<th>Jawaban Konsul</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modRiwayatKonsul as $i => $konsul) { ?>
        <tr>
            <td><?php echo $konsul->tglkonsulpoli ?></td>
            <td><?php echo $konsul->konsulpoli_id ?> <?php echo CHtml::link("<i class='entypo-print'></i>", '#', array('onclick'=>'printPermintaan('.$konsul->konsulpoli_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk mencetak detail konsul Poliklinik')); ?></td>
            <td><?php echo $konsul->pendaftaran->no_pendaftaran ?></td>
            <td><?php echo $konsul->poliasal->ruangan_nama ?></td>
            <td><?php echo $konsul->politujuan->ruangan_nama ?></td>
            <td><?php echo $konsul->catatan_dokter_konsul ?></td>
			<td style="text-align: center;">
				
                <?php if(empty($konsul->jawabkonsulpoli_id)){
				echo CHtml::link("<i class='icon-eye-open'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id."/JawabKonsul", array("konsulpoli_id"=>$konsul->konsulpoli_id)),
							array("class"=>"",
							"target"=>"frameJawabKonsul",
							"rel"=>"tooltip",
							"title"=>"Klik untuk Jawab Konsul",
							"onclick"=>"$('#dialogJawabKonsul').dialog('open');"));
				}else{ echo "Sudah Dijawab"; } 
				?>
				
            </td>
            <td>
                <?php echo CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick'=>'viewDetailKonsul('.$konsul->konsulpoli_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail konsul')); ?>
                <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'batalKonsul('.$konsul->konsulpoli_id.','.$konsul->pendaftaran_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan konsul')); ?>
            </td>
        </tr>
    <?php } ?>
        <tr>
            <td colspan="6">
                <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'buttons'=>array(
                        array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'printRiwayat(\'PRINT\')')),
                        array('label'=>'', 'items'=>array(
                            array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'PDF\')')),
                            array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'EXCEL\')')),
                           
                        )),       
                    ),
                    'htmlOptions'=>array('style'=>'float:right')
                )); ?>
            </td>
        </tr>
    </tbody>
</table>