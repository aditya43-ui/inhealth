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

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }

   </style>
    <!--<legend class="rim">Berdasarkan Kunjungan</legend>-->
                    <?php //echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::hiddenField('filter_tab', 'penjamin'); ?>
      <table>
            <tr>
                <td>
                    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pembayaran ','Tanggal Pembayaran ', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'bulan',
                                    array(
                                        'hari'=>'Hari Ini',
                                        'bulan'=>'Bulan',
                                        'tahun'=>'Tahun',
                                    ),
                                    array(
                                        'id'=>'PeriodeName',
                                        'onChange'=>'setPeriode()',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;',
                                    )
                                    );
                        ?>
                            </div>
                    </div>
                </td>
                 <td>
                    <?php echo CHtml::hiddenField('type', ''); ?>
<!--<div class="control-group">-->
                            <?php //echo Chtml::label('Tgl. Kunjungan', 'tglKunjungan', array('class' => 'control-label')) ?>
                            <div style="margin-left:-1150px;margin-top:40px;">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                            <div style="margin-left:-955px;margin-top:-25px;text-align:left">
                                <span> s/d </span>
                            </div>
<!--</div>-->
<!--</div>-->
              </td>
              <tr>
                 <td>
<!--<div class="control-group">-->
                            <?php //echo Chtml::label('Sampai Dengan', 'sampai dengan', array('style'=>'margin-top:20px;')) ?>
                            <div style="margin-left:527px;margin-top:-35px;">
                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3','onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
<!--</div>-->
<!--</div>-->
                </td>
              </tr>
            </tr>
  </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class' => 'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;')); ?>
    </div>
</div>    
<?php $this->endWidget();
      $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
      $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
      $urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => '')); ?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY); ?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BSTindakandanoasudahbayarV_tgl_awal').val(data.periodeawal);
            $('#BSTindakandanoasudahbayarV_tgl_akhir').val(data.periodeakhir);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode',$js,CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event){
            var namaPeriode = $('#PeriodeName').val();

            if(namaPeriode == ''){
                myAlert('Silakan pilih kategori pencarian!');
                event.preventDefault();
                $('#dtPicker3').datepicker("hide");
                return true;
                ;
            }
        }
</script>

