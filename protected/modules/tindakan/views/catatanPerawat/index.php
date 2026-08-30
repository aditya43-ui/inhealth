<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Catatan Perawat</div>
    </div>
    <div class="panel-body">
        

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Tabel Riwayat Catatan Perawat</strong></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_riwayat', array('modPendaftaran'=>$modPendaftaran)); ?>
            </div>
        </div>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>


        <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'catatanperawat-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                'focus' => '#',
                ));
        ?>
        <?php echo $form->hiddenField($model,'pendaftaran_id'); ?>
        <?php echo $form->hiddenField($model,'pasienadmisi_id'); ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Catatan Perawat</strong></div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tglobservasi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglobservasi',
                                    'value' => null,
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'diagnosa_nama', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                 echo $form->textArea($model,'diagnosa_nama',array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly'=>true))
                                ?>
                            </div>
                        </div> 
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'catatanperawat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textArea($model,'catatanperawat',array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"))
                                ?>
                            </div>
                        </div>        
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'petugas_pemeriksa', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model,'perawatmengetahui_id') ?>
                                <?php
                                $this->widget('MyJuiAutoComplete',array(
                                    'model'=>$model,
                                    'attribute'=>'perawatmengetahui_nama',
                                    'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('autocompletePetugasRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                tipe: 1,
                                            },
                                            success: function (data) {
                                                    response(data);
                                            }
                                        })
                                    }',
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'minLength'=>2,
                                        'select' => 'js:function( event, ui ) {
                                            $("#'.CHtml::activeId($model, 'perawatmengetahui_nama') . '").val(ui.item.label);
                                            $("#'.CHtml::activeId($model, 'perawatmengetahui_id') . '").val(ui.item.value);
                                            return false;
                                        }',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogPetugas'),
                                    'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')
                                ));
                                ?>

                            </div>
                        </div>

                    </div>   
                </div>
            </div>
        </div>

        <div class="row-fluid">
         <div class="form-actions">
             <?php
               $disabledSukses = (isset($_GET['sukses'])? true:false);
                 echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disabledSukses));
                 echo "&nbsp;";
                 echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                     $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                     array('class'=>'btn btn-danger',
                         'onclick'=>'return refreshForm(this);'));
             ?>
             <?php
                 $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                 $this->widget('UserTips',array('type'=>'admin','content'=>$content));
             ?>
         </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>


<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Petugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => false,
    ),
));


$modPegRuangan = new PegawairuanganV();
$modPegRuangan->unsetAttributes();
$modPegRuangan->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PegawairuanganV'])) {
    $modPegRuangan->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokteranastesi-m-grid',
    'dataProvider' => $modPegRuangan->search(),
    'filter' => $modPegRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#' . CHtml::activeId($model, 'perawatmengetahui_nama') . '\").val(\"$data->namaLengkap\");
                            $(\"#' . CHtml::activeId($model, 'perawatmengetahui_id') . '\").val(\"$data->pegawai_id\");
                            $(\"#dialogPetugas\").dialog(\"close\");
                            return false;"
                ))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegRuangan, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegRuangan, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
              $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
              return (!empty($jabatan)?$jabatan->jabatan_nama:"");
              },
            'filter' => Chtml::activeDropdownList($modPegRuangan, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama ASC'),'jabatan_id','jabatan_nama'),array('empty' => '-Pilih-'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '}',
));

$this->endWidget();
?>
