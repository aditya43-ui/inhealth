<div class="search-form">
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
<style>
    label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }
</style>
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <table>
        <tr>
            <td>
                Tanggal Kunjungan <?php echo $form->dropDownList($model,'bulan',
                        array(
                            'hari'=>'Hari Ini',
                            'bulan'=>'Bulan',
                            'tahun'=>'Tahun',
                        ),
                        array(
                            'empty'=>'-- Pilih --',
                            'id'=>'PeriodeName',
                            'onChange'=>'setPeriode()',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;',
                        )
                        );
                    ?>
            </td>
            <td width="250px">
                <?php echo CHtml::hiddenField('type', ''); ?>
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
            </td>
            <td width="50px">s/d</td>
            <td>
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
            </td>
        </tr>
        <tr>
            <td rowspan =3>
                    Ruangan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->dropDownList($model, 'ruanganpenunj_id', 
                            CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama asc'), 'ruangan_id', 'ruangan_nama'), 
                            array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class' => 'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;')); ?>
    </div> 
</div>    
<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai ?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BSLaporankinerjapenunjangV_tgl_awal').val(data.periodeawal);
            $('#BSLaporankinerjapenunjangV_tgl_akhir').val(data.periodeakhir);
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

