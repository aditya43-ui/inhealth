<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        #penjamin, #ruangan{
            width:650px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
                <?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">           
            <div class="control-group">  
                <?php echo $form->labelEx($model,'pegawai_id', array('class'=>'control-label')); ?> 
                <div class="controls">
                    <?php echo CHtml::activeHiddenField($model,'pegawai_id'); ?>
                    <?php //echo CHtml::hiddenField('ygmengajukan_id'); ?>
                        <div style="float:left;">
                            <?php
                                $this->widget('MyJuiAutoComplete',array(
                                    'model'=>$model,
                                    'attribute'=>'dokter',
                                    'sourceUrl'=>  Yii::app()->createUrl('farmasiApotek/laporanFarmasi/listPegawai'),
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'minLength'=>2,
                                        'select'=>'js:function( event, ui ) {
                                                $("#FAPenjualanResepT_pegawai_id").val(ui.item.pegawai_id);
                                                $("#FAPenjualanResepT_dokter").val(ui.item.nama_pegawai);
                                        }',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'float:left;')
                                ));
                            ?>
                        </div>
                </div>          
            </div>
        </div>
    </div>              
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()')
        );
        ?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        myConfirm("Apakah Anda ingin me-refresh halaman?","Perhatian!",
        function(r){
            if(r){
                window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanJasaRacikan', array('modul_id'=>Yii::app()->session['modul_id'])).'";
            }
        }); 
    }', CClientScript::POS_HEAD); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
if(isset($_GET['PegawaiM'])){
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modPegawai->search(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                            $(\"#'.CHtml::activeId($model,'dokter').'\").val(\"$data->nama_pegawai\");
                            $(\"#dialogPegawai\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        'gelardepan',
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>
<?php 
    $skip = array(
        'pegawai' => true
    );
    
    $this->renderPartial('_jsFunctions', array('model' => $model,'skip'=>$skip)); 
?>
