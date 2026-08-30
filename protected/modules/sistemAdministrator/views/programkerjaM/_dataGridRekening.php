<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <!--<h6>Daftar <b>Anggaran</b></h6>-->
    <div style="max-width:100%;">
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'AGRekeninganggaran-v',
                    'dataProvider'=>$model->searchByFilter(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                          'header' => 'No.',
                          'type'=>'raw',
                          'value'=>'$row+1',
                          'htmlOptions'=>array('style'=>'width:20px')
                        ),
                        array(
							'header'=>'Kode Program',
							'name'=>'programkerja_kode',
							'type'=>'raw',
							'value'=>'$data->programkerja_kode',
							'htmlOptions'=>array('style'=>'text-align: center; width:50px;')
                        ),
                        array(
							'header'=>'Kode Sub Program',
							'name'=>'subprogramkerja_kode',
							'type'=>'raw',
							'value'=>'($data->subprogramkerja_kode == null ? "-" : $data->subprogramkerja_kode)',
							'htmlOptions'=>array('style'=>'text-align: center; width:60px')
                        ),
                        array(
							'header'=>'Kode Kegiatan',
							'name'=>'kegiatanprogram_kode',
							'type'=>'raw',
							'value'=>'$data->kegiatanprogram_kode',
							'htmlOptions'=>array('style'=>'text-align: center; width:50px')
                        ),
                        array(
							'header'=>'Kode Sub Kegiatan',
							'name'=>'subkegiatanprogram_kode',
							'type'=>'raw',
							'value'=>'($data->subkegiatanprogram_kode == null ? "-" : $data->subkegiatanprogram_kode)',
							'htmlOptions'=>array('style'=>'text-align: center; width:60px')
                        ),
                        array(
							'header'=>'Program',
							'name'=>'programkerja_nama',
							'type'=>'raw',
							'value'=>'isset($data->programkerja_nama) ? CHtml::Link($data->programkerja_nama, Yii::app()->controller->createUrl("ProgramkerjaMAG/editProgramKerja",array("id"=>$data->programkerja_id)),array("style"=>"color:blue","target"=>"frameEditProgramKerja", "onclick"=>"$(\"#dialogEditProgramKerja\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk Edit<br>Program Kerja",)) : "-"',
                        ),
                        array(
							'header'=>'Sub Program',
							'name'=>'subprogramkerja_nama',
							'type'=>'raw',
							'value'=>'isset($data->subprogramkerja_nama) ? CHtml::Link($data->subprogramkerja_nama, Yii::app()->controller->createUrl("ProgramkerjaMAG/editSubProgramKerja",array("id"=>$data->subprogramkerja_id)),array("style"=>"color:blue","target"=>"frameEditSubProgramKerja", "onclick"=>"$(\"#dialogEditSubProgramKerja\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik Untuk<br>Edit Sub Program Kerja",)) : "-"',
                        ),
                        array(
							'header'=>'Kegiatan',
							'name'=>'kegiatanprogram_nama',
							'type'=>'raw',
							'value'=>'isset($data->kegiatanprogram_nama) ? CHtml::Link($data->kegiatanprogram_nama, Yii::app()->controller->createUrl("ProgramkerjaMAG/editKegiatanProgram",array("id"=>$data->kegiatanprogram_id)),array("style"=>"color:blue","target"=>"frameEditKegiatanProgram", "onclick"=>"$(\"#dialogEditKegiatanProgram\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk Edit<br>Kegiatan Program",)) : "-"',
                        ),
                        array(
							'header'=>'Sub Kegiatan',
							'name'=>'subkegiatanprogram_nama',
							'type'=>'raw',
							'value'=>'isset($data->subkegiatanprogram_nama) ? CHtml::Link($data->subkegiatanprogram_nama, Yii::app()->controller->createUrl("ProgramkerjaMAG/editSubKegiatanProgram",array("id"=>$data->subkegiatanprogram_id)),array("style"=>"color:blue","target"=>"frameEditSubKegiatanProgram", "onclick"=>"$(\"#dialogEditSubKegiatanProgram\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk Edit<br>Sub Kegiatan Program",)) : "-"',
                        ),
                        array(
							'header'=>'Rekening Debit Akuntansi',
							'name'=>'rekening5debit_nama',
							'type'=>'raw',
							'value'=>'($data->rekening5debit_nama == null ? "-" : $data->rekening5debit_nama)',
                        ),
                        array(
							'header'=>'Rekening Kredit Akuntansi',
							'name'=>'rekening5kredit_nama',
							'type'=>'raw',
							'value'=>'($data->rekening5kredit_nama == null ? "-" : $data->rekening5kredit_nama)',
                        ),
                        array(
							'header'=>'Keterangan',
							'name'=>'subkegiatanprogram_ket',
							'type'=>'raw',
							'value'=>'isset($data->subkegiatanprogram_ket) ?  $data->subkegiatanprogram_ket : "-"',
                        ),
                        array(
							'header'=>'Status',
							'name'=>'subkegiatanprogram_aktif',
							'type'=>'raw',
							'value'=>'($data->subkegiatanprogram_aktif == true ? "Aktif" : "Tidak Aktif")',
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );
        ?>
    </div>
<!--</div>-->
<?php 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),
            array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),
            array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
            array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
?>
<?php
        $content = $this->renderPartial($this->path_view.'tips/master1',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#AGRekeninganggaran-v').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditProgramKerja',
        'options' => array(
            'title' => 'Edit Program Kerja',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,            
			'close'=>'js:function(){if(typeof getTreeMenuAnggaran == \'function\'){getTreeMenuAnggaran();$.fn.yiiGridView.update(\'AGRekeninganggaran-v\', {});}}'
        ),
    )
);
?>
<iframe name='frameEditProgramKerja' style="width: 100%; height: 98%;"></iframe>
<?php
    $this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditSubProgramKerja',
        'options' => array(
            'title' => 'Edit Sub Program Kerja',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,            
			'close'=>'js:function(){if(typeof getTreeMenuAnggaran == \'function\'){getTreeMenuAnggaran();$.fn.yiiGridView.update(\'AGRekeninganggaran-v\', {});}}'
        ),
    )
);
?>
<iframe name='frameEditSubProgramKerja' style="width: 100%; height: 98%;"></iframe>
<?php
    $this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditKegiatanProgram',
        'options' => array(
            'title' => 'Edit Kegiatan Program',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,            
			'close'=>'js:function(){if(typeof getTreeMenuAnggaran == \'function\'){getTreeMenuAnggaran();$.fn.yiiGridView.update(\'AGRekeninganggaran-v\', {});}}'
        ),
    )
);
?>
<iframe name='frameEditKegiatanProgram' style="width: 100%; height: 98%;"></iframe>
<?php
    $this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditSubKegiatanProgram',
        'options' => array(
            'title' => 'Edit Sub Kegiatan Program',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 400,
            'resizable' => false,
            'close'=>'js:function(){if(typeof getTreeMenuAnggaran == \'function\'){getTreeMenuAnggaran();$.fn.yiiGridView.update(\'AGRekeninganggaran-v\', {});}}'
        ),
    )
);
?>
<iframe name='frameEditSubKegiatanProgram' style="width: 100%; height: 98%;"></iframe>
<?php
    $this->endWidget();
?>