<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Infomasi Tarif <b>Rehab Medis</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Tarif <b>Rehab Medis</b></div>
            </div>
            <div class="panel-body">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarTindakan-grid',
            'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    'kelompoktindakan_nama',
                    'kategoritindakan_nama',
                    'daftartindakan_nama',
                    'kelaspelayanan_nama',
    //                'ruangan_id',

                  array(
                            'name'=>'tarifTotal',
                            'value'=>'$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                    ),
                'persencyto_tind',
                'persendiskon_tind',
                array(
                            'name'=>'Komponen Tarif',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("idKelasPelayanan"=>$data->kelaspelayanan_id,"idDaftarTindakan"=>$data->daftartindakan_id, "idKategoriTindakan"=>$data->kategoritindakan_id)) ,array("title"=>"Klik Untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))',
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
        </div>
        
        
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"><i class="icon-search"></i> Pencarian</div>
        </div>
        <div class="panel-body">
        <?php
        // ===========================Dialog Details Tarif=========================================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogDetailsTarif',
                // additional javascript options for the dialog plugin
                'options'=>array(
                'title'=>'Komponen Tarif',
                'autoOpen'=>false,
                'width'=>300,
                'height'=>300,
                'resizable'=>false,
                'scroll'=>false    
                 ),
            ));
        ?>
        <iframe src="" name="iframe" width="100%" height="100%">
        </iframe>
        <?php    
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        //===============================Akhir Dialog Details Tarif================================

        Yii::app()->clientScript->registerScript('search', "

        $('form#formCari').submit(function(){
                $.fn.yiiGridView.update('daftarTindakan-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ", CClientScript::POS_READY);
        ?>

        <?php  ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'formCari',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#SARuanganM_instalasi_id',
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

        )); ?>
        <?php //echo $form->dropDownListRow($modTarifTindakanRuanganV,'daftartindakan_id',CHtml::listData(TariftindakanperdaruanganV::model()->findAll(), 'daftartindakan_id', 'daftartindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kategoritindakan_id',CHtml::listData(KategoritindakanM::model()->findAll('kategoritindakan_aktif = true'), 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelaspelayanan_id',CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                
                    <?php echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_id',array('placeholder'=>'Ketik Daftar Tindakan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
                  <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
                 <?php 
                   $content = $this->renderPartial('../tips/informasi',array(),true);
                                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                ?>
        </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>