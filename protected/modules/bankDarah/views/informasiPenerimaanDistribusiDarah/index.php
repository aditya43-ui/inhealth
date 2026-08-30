
<?php

Yii::app()->clientScript->registerScript('search', "
    $('#penerimaankantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('penerimaankantongdarah-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Penerimaan Distribusi Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Penerimaan Distribusi Darah</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'penerimaankantongdarah-r-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),
                                 array(
                                    'header'=>'Tanggal Penerimaan',
                                    'value'=>function($data){
                                        echo MyFormatter::formatDateTimeForUser($data->tgl_terima);
                                    },
                                ),
                                array(
                                    'header'=>'Nomor Penerimaan',
                                    'value'=>function($data){
                                        echo $data->nomor_terima;
                                    },
                                ),
                                array(
                                    'header'=>'Petugas Distribusi Pelayanan Darah',
                                    'value'=>function($data){
                                        if($data->petugasdistribusi_pelayanandarah){
                                             $modPegawaiDistribusi = PegawaiM::model()->findByPk($data->petugasdistribusi_pelayanandarah)->nama_pegawai;
                                             return $modPegawaiDistribusi;
                                        }else{
                                            return "-";
                                        }
                                        
                                    },
                                ),            
                                
                                array(
                                    'header'=>'Detail',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value'=>function($data){
                                        return CHtml::Link("<span style='font-size:17px'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("lihatDetail",array("terimadistribusidarah_id"=>$data->terimadistribusidarah_id,"detail"=>'detail')),
                                            array("class"=>"", 
                                                "target"=>"frameDetail",
                                                "onclick"=>"$('#dialogDetail').dialog('open');",
                                                "rel"=>"tooltip",
                                                'data-placement'=>'left',
                                                "title"=>"Klik untuk melihat rincian penerimaan distribusi darah",
                                            ));
                                    },
                                ),
                                array(
                                    'header'=>'Batal',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        return CHtml::link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
                                            'onclick'=>'batalTerima(this, '.$data->terimadistribusidarah_id.'); return false;',
                                            'width'=>'23px',
                                            'height'=>'23px',
                                            'rel'=>'tooltip',
                                            'data-placement'=>'left',
                                            'title'=>'Klik untuk membatalkan penerimaan.',
                                        ));
                                    },
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial('_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>        
<script>
function batalIzin(id) {
    myConfirm('Apakah anda yakin untuk membatalkan perizinan ini ?', 'Perhatian!', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('BatalIzin'); ?>', {id: id}, function(data) {
                if (data.sukses==1) {
                    myAlert(data.pesan);
                    $.fn.yiiGridView.update('penerimaankantongdarah-r-grid');
                } else {
                    myAlert(data.pesan);
                }
            }, 'json');
        }
    });
}

function batalTerima(obj, id) {
    myConfirm('Apakah anda yakin untuk membatalkan penerimaan distribusi darah ini ?', 'Perhatian!', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('batalTerima'); ?>', {id: id}, function(data) {
                if(data.status == 'proses_form'){
                            $.fn.yiiGridView.update('penerimaankantongdarah-r-grid');
                        }else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

</script>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetail',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Detail Penerimaan Distribusi Darah',
		'autoOpen'=>false,
		'minWidth'=>900,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetail" width="100%" height="500" style="border: none;">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>