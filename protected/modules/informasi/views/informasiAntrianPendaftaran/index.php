<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Antrian Pendaftaran</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'informasi Antrian Pendaftaran',
        );
        $this->widget('bootstrap.widgets.BootAlert');
        Yii::app()->clientScript->registerScript('search', "
      $('.search-button').click(function(){
      	$('.search-form').toggle();
      	return false;
      });
      $('#searchCari').submit(function(){
      	$.fn.yiiGridView.update('ininformasiAntrianPendaftaran-grid', {
      		data: $(this).serialize()
      	});
      	return false;
      });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body search-from">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'searchCari',
                    'type' => 'horizontal',
                    'focus' => '#INPasienmasukpenunjangV_instalasi_id',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
                <?php echo $form->errorSummary($modAntrianPendaftaran); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Loket', 'loket_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modAntrianPendaftaran, 'loket_id', CHtml::listData($modAntrianPendaftaran->getLoket(), 'loket_id', 'namaLoketLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->textFieldRow($modAntrianPendaftaran, 'noantrian', array('placeholder' => 'No. Antrian', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50));
                        ?>
                    </div>
                    <!--<div class="col-sm-6">
                    </div>-->
                    <!--<div class="form-group">
                    <div class="col-sm-6">-->
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiAntrianPendaftaran', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
                <!--</div>
                </div>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Antrian Pendaftaran</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'ininformasiAntrianPendaftaran-grid',
                    'dataProvider' => $modAntrianPendaftaran->searchAntrian(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    //        'mergeColumns'=>array('no_urutantri'),
                    'columns' => array(
                        'tglantrian',
                        array(
                            'header' => 'Loket',
                            'value' => 'isset($data->loket->loket_nama)? $data->loket->loket_nama : " "',
                        ),
                        array(
                            'header' => 'Loket (Singkatan)',
                            'value' => 'isset($data->loket->loket_singkatan)? $data->loket->loket_singkatan : " ")',
                        ),
                        'noantrian',
                        /*
                        array(
                          'name'=>'modelantrian_id',
                          'value'=>function($data){
                             if(empty($data->modelantrian_id)){
                                 return "-";
                             }
                                return  $data->modelantrian->modelantrian_nama;  
                          },
                        ),
                         * 
                         */
                        array(
                            'name' => 'statuspasien',
                            'value' => '(empty($data->pendaftaran_id)? "Antri" : "Sudah Mendaftar / ".$data->pendaftaran->no_pendaftaran)',
                        ),
                        array(
                            'header' => 'Karcis',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\"icon-print\"></i>", "onclick=printKarcis(\'$data->antrian_id\')", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint karcis"))." ".CHtml::link("Print", "javascript:printKarcis(\'$data->antrian_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint karcis"))',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!--<legend class="rim">Pencarian</legend>-->
<script type="text/javascript">
    function printKarcis(antrian_id) {
        window.open('<?php echo $this->createUrl('printKarcis'); ?>' + '&antrian_id=' + antrian_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>