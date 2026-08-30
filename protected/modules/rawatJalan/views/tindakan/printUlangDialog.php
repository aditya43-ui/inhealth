<div style="margin: 20px;" hidden>
    <?php
    echo CHtml::link(
        Yii::t(
            'mds',
            '{icon} Print Semua',
            array('{icon}' => '<i class="entypo-print"></i>')
        ),
        'javascript:void(0);',
        array(
            'class' => 'btn btn-info',
            'onclick' => "printSemua(" . $modPendaftaran->pendaftaran_id . ");return false"
        )
    );
?>
</div>

<div style="margin: 20px;">

    <?php echo CHtml::hiddenField('nopel', '', array('readonly' => true)) ?>

    <?php $this->widget('MyJuiAutoComplete',array(
            'name'=>'nopelayanan',
            'value'=>'',
//                  'name'=>"daftartindakan[$i]",
//                  'value'=>'',
            'sourceUrl'=> Yii::app()->createUrl('rawatJalan/tindakan/noPelayanan&pendaftaran_id=' . $modPendaftaran->pendaftaran_id),
            'options'=>array(
               'showAnim'=>'fold',
               'minLength' => 4,
               'focus'=> 'js:function( event, ui ) {
                    $(this).val( ui.item.label);
                    return false;
                }',
               'select'=>'js:function( event, ui ) {
                    return false;
                }',
            ),
            'tombolDialog'=>array("idDialog"=>'dialogNoPelayanan'),
            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3'),
    )); ?>
</div>

<div style="margin: 20px;">

<?php
    echo CHtml::link(
        Yii::t(
            'mds',
            '{icon} Print',
            array('{icon}' => '<i class="entypo-print"></i>')
        ),
        'javascript:void(0);',
        array(
            'class' => 'btn btn-info',
            'onclick' => "printNota(" . $modPendaftaran->pendaftaran_id . ");return false"
        )
    );
?>

</div>

<?php echo $this->renderPartial($this->path_view . '_jsFunction', array(
        'modTindakan' => $modTindakan,
        'modPendaftaran' => $modPendaftaran,
        'modJenisTarif' => $modJenisTarif,
    ), true); ?>

<?php
//========= Dialog buat cari data Alat Kesehatan (RACIKAN)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogNoPelayanan',
    'options' => array(
        'title' => 'Daftar No. Nota',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTin = new TindakanpelayananT('searchNoPelayanan');
$modTin->unsetAttributes();
$modTin->pendaftaran_id = $modPendaftaran->pendaftaran_id;
$modTin->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['TindakanpelayananT'])) {
    $modTin->attributes = $_GET['TindakanpelayananT'];
    $modTin->no_nota = $_GET['TindakanpelayananT']['no_nota'];
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'triase-m-grid',
    'dataProvider' => $modTin->searchNoPelayanan(),
    'filter' => $modTin,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(

        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "$(\"#nopelayanan\").val(\"$data->no_nota\"); $(\"#nopel\").val(\"$data->nopelayanan\");  
                                                $(\'#dialogNoPelayanan\').dialog(\'close\');return false;"))',
        ),
    
        array(
            'header' => 'No. Nota',
            'name' => 'no_nota',
            'value' => '$data->no_nota',
        ),
    ),


       
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>