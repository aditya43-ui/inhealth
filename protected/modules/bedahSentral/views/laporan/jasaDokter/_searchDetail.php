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

   label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }

    </style>
    
      <table>
            <tr>
                <td>
                    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
                    <div class="control-group">
                    <?php echo CHtml::label('Tgl. Kunjungan ','Tanggal Kunjungan ', array('class'=>'control-label')) ?>
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
                            <div style="margin-left:-650px;margin-top:40px;">
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
                            <div style="margin-left:-420px;margin-top:-20px;text-align:left">
                                <span> s/d </span>
                            </div>
<!--</div>-->
<!--</div>-->
              </td>
              <tr>
                 <td>
<!--<div class="control-group">-->
                            <?php //echo Chtml::label('Sampai Dengan', 'sampai dengan', array('style'=>'margin-top:20px;')) ?>
                            <div style="margin-left:560px;margin-top:-34px;">
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
            <tr>
                <td>
                    <div class="control-group">
                    <?php echo CHtml::label('Nama Dokter','namaDokter', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($model,'pegawai_id', CHtml::listData(DokterpegawaiV::model()->findAll(), 'pegawai_id', 'nama_pegawai'), 
                                          array('empty'=>'-- Pilih --','style'=>'width:160px','onkeypress'=>"return nextFocus(this,event)")); 
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                    <?php echo CHtml::label('Nama Ruangan','namaRuangan', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(), 'instalasi_id', 'instalasi_nama'), 
                                          array('empty'=>'-- Pilih --','style'=>'width:160px','onkeypress'=>"return nextFocus(this,event)")); 
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                    <?php echo CHtml::label('Kelas Ruangan','namaRuangan', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), 
                                          array('empty'=>'-- Pilih --','style'=>'width:160px','onkeypress'=>"return nextFocus(this,event)")); 
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
  </table>

    <div class="form-actions">
        <?php
             echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
                     array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class' => 'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;')); ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php 
Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BSLaporanrekaptransaksiV_tgl_awal').val(data.periodeawal);
            $('#BSLaporanrekaptransaksiV_tgl_akhir').val(data.periodeakhir);
            $('#PPRuanganM_tgl_awal').val(data.periodeawal);
            $('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
//            if(data.namaPeriode == 1 ){
//                myAlert("Pencarian Berdasarkan : "+data.namaPeriode);
//            }
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

