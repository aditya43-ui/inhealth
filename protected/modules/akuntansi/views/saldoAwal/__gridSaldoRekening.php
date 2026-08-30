<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Daftar Saldo Rekening</div>
	</div>
	<div class="panel-body">
		<?php
            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'grid-saldo-rekening',
					//'filter'=>$model,
                    'dataProvider'=>$model->searchByFilter(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-bordered datatable',
					'overflowx' => true,
                    'columns'=>array(
                        array(
                          'header'=>'No',
                          'type'=>'raw',
                          'value'=>'$row+1',
                          'htmlOptions'=>array('style'=>'width:20px')
                        ),
						array(
							'header'=>'Periode Posting',
							'name'=>'periodeposting_id',
							'value'=>'$data->periodeposting_nama',
							'filter'=>CHtml::activeDropDownList($model, 'periodeposting_id', CHtml::listData(
							PeriodepostingM::model()->findAll(array(
								'order'=>'tglperiodeposting_awal',
							)), 'periodeposting_id', 'periodeposting_nama'
							), array(
								'empty'=>'-- Pilih --',
							)),
						),
                        array(
							'header'=>'Kode Rekening',
                           'name'=>'kdrincianobyek',
                           'type'=>'raw',
                            'value'=>'($data->kdrincianobyek == null ? "-" : $data->kdrincianobyek)',
                           'htmlOptions'=>array('style'=>'text-align: center; width:80px')
                        ),
                        array(
                           'header'=>'Nama Rekening',
                           'type'=>'raw',
                           'name' => 'nmrincianobyek',
                           //'value'=>'(isset($data->nmrincianobyek) ? $data->nmrincianobyek : (isset($data->nmobyek) ? $data->nmobyek : (isset($data->nmjenis) ? $data->nmjenis : (isset($data->nmkelompok) ? $data->nmkelompok : (isset($data->nmstruktur) ? $data->nmstruktur : "-")))))',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),                        
                        /*
                        array(
                           'name'=>'nmstruktur',
                           'type'=>'raw',
                           'value'=>'isset($data->nmstruktur) ? $data->nmstruktur : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmkelompok',
                           'type'=>'raw',
                           'value'=>'isset($data->nmkelompok) ? $data->nmkelompok : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmjenis',
                           'type'=>'raw',
                           'value'=>'isset($data->nmjenis) ? $data->nmjenis : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmobyek',
                           'type'=>'raw',
                           'value'=>'isset($data->nmobyek) ? $data->nmobyek : "-"',
                        ),
                        array(
                           'name'=>'nmrincianobyek',
                           'type'=>'raw',
                           'value'=>'isset($data->nmrincianobyek) ? $data->nmrincianobyek : "-"',
                        ),
                        array(
                           'name'=>'rincianobyek_nb',
                           'type'=>'raw',
                            'value'=>'($data->rincianobyek_nb == null ? "-" : ($data->rincianobyek_nb == "D" ? "Debit" : "Kredit"))',
                        ),
                        array(
                           'name'=>'kelompokrek',
                           'type'=>'raw',
                            'value'=>'($data->kelompokrek == null ? "-" : $data->kelompokrek)',
                        ),
                         * 
                         */
						array(
							'name'=>'matauang',
							'filter'=>false,
						),
                        array(
                            'header' => 'Jumlah Anggaran',
                            'name' => 'jmlanggaran',
                            'value' => 'number_format($data->jmlanggaran,2,",",".")',
                            'htmlOptions' => array('style'=>'text-align:right;'),
							'filter'=>false,
                        ),                        
                        array(
                            'header' => 'Jumlah Saldo Awal (Debit)',
                            'name' => 'jmlsaldoawald',
                            'value' => 'number_format($data->jmlsaldoawald,2,",",".")',
                            'htmlOptions' => array('style'=>'text-align:right;'),
							'filter'=>false,
                        ),
                        array(
                            'header' => 'Jumlah Saldo Awal (Kredit)',
                            'name' => 'jmlsaldoawalk',
                            'value' => 'number_format($data->jmlsaldoawalk,2,",",".")',
                            'htmlOptions' => array('style'=>'text-align:right;'),
							'filter'=>false,
                        ),
                         array(
                            'header' => 'Jumlah Mutasi (Debit)',
                            'name' => 'jmlmutasid',
                            'value' => 'number_format($data->jmlmutasid,2,",",".")',
                            'htmlOptions' => array('style'=>'text-align:right;'),
							'filter'=>false,
                        ),
                         array(
                            'header' => 'Jumlah Mutasi (Kredit)',
                            'name' => 'jmlmutasik',
                            'value' => 'number_format($data->jmlmutasik,2,",",".")',
                            'htmlOptions' => array('style'=>'text-align:right;'),
							'filter'=>false,
                        ),
                        array(
                            'header' => 'Jumlah Saldo Akhir (Debit)',
                            'name' => 'jmlsaldoakhird',
                            'value' => 'number_format($data->jmlsaldoakhird,2,",",".")',
                            'htmlOptions' => array('style'=>'text-align:right;'),
							'filter'=>false,
                        ),
                        array(
                            'header' => 'Jumlah Saldo Akhir (Kredit)',
                            'name' => 'jmlsaldoakhirk',
                            'value' => 'number_format($data->jmlsaldoakhirk,2,",",".")',
                            'htmlOptions' => array('style'=>'text-align:right;'),
							'filter'=>false,
                        ),
                        array(
                           'header'=>'&nbsp;',
                           'type'=>'raw',
                           'value'=>'CHtml::Link("<i class=\''.MyIcon::getIcons('ubah').'\'></i>", Yii::app()->controller->createUrl("SaldoAwal/editSaldoRekening",array("id"=>$data->saldoawal_id)),array("value"=>$data->saldoawal_id, "onclick"=>"editSaldoJenisRek(this);return false;","rel"=>"tooltip", "title"=>"Klik Untuk Edit Saldo Rekening","data-placement"=>"left"))',
                        )
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );
        ?>
	</div>
</div>

<?php 
      //  echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),
      //      array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        
      //  echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),
       //     array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        
      //  echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
       //     array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
?>
<div class="btn-group">
    <button type="button" class="btn btn-primary" onclick='print("PRINT"); return false;'>
            <i class="entypo-print"></i>Print
    </button>
    <button type="button" class="btn btn-primary dropdown-toggle menu-print">
            <i class="entypo-export"></i>
    </button>
    <ul class="dropdown-menu option-print" role="menu">
        <li>
            <a onclick='print("EXCEL"); return false;'><i class="<?php echo MyIcon::getIcons('excel') ?>"></i>EXCEL</a>
        </li>
        <li>
            <a onclick='print("PDF"); return false;'><i class="<?php echo MyIcon::getIcons('pdf') ?>"></i>PDF</a>
        </li>
    </ul>
</div>
<?php
        $content = $this->renderPartial('../tips/master',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penjaminpasien-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditSaldoRekening',
        'options' => array(
            'title' => 'Ubah Saldo Awal Rekening',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 400,
            'resizable' => false,
            'close'=>'js:function(){$.fn.yiiGridView.update(\'grid-saldo-rekening\', {});}'
        ),
    )
);
?>
<div id="pop_up_content"></div>
<?php
    $this->endWidget();
?>

<script type="text/javascript">
    
</script>