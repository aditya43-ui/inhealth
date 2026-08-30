<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dropdownMulti.js', CClientScript::POS_END);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<style>
    label.checkbox,
    label.radio {
        width: 150px;
        display: inline-block;
    }
</style>
<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <?php echo CHtml::hiddenField('filter_tab', 'rekap', array()); ?>
        <div class="control-group">
            <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
            <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'kunjungan',
                    'slide'=>true,
                    'content'=>array(
                    'content2'=>array(
                            'header'=>'Berdasarkan Shift',
                            'multi' => 'multi',
                            'isi'=>     '<table class="">                                            
                                            <tr>
                                                <td>'.
                                                //$form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'))

                                                     $form->dropDownList($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll("shift_aktif = TRUE ORDER BY shift_nama"), 'shift_id', 'shift_nama'),array(
                                                     'class'=>'form-control', 'multiple'=>'multiple'))																			
                                                .'</td>
                                            </tr>
                                        </table>',            
                            'active'=>true,
                                    ),
                    ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    )); */
        ?>
    </div>

    <div class="col-sm-6">
        <?php /*            
                <div id='searching'>
                        <!--fieldset class="box2"-->
                                <legend class="rim">Berdasarkan Ruangan Kasir&nbsp;<?php echo CHtml::checkBox('cek_ruangan', true, array('onchange'=>'cek_all_ruangan(this)','value'=>'cek_ruangan'));?></legend>
                                <?php echo '<table id="ruangan_tbl">
                                        <tr>
                                                <td>'.
                                                $form->checkBoxList($model, 'ruangan_id', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)")).'
                                                </td>
                                        </tr>
                                 </table>'; ?>
                        <!--</fieldset>-->
                </div>
             * 
         */ ?>
        <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'kunjungan',
                    'slide'=>true,
                    'content'=>array(
                    'content2'=>array(
                            'header'=>'Berdasarkan Kasir',
                            'multi' => 'multi',
                            'isi'=>  '<table class="">                                            
                                        <tr>
                                                        <td>'.
                                                                   //$form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'))

                                                                        $form->dropDownList($model, 'pegawai_id',PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')),array(
                                                                        'class'=>'form-control', 'multiple'=>'multiple'))																			
                                                        .'</td>
                                        </tr>
                                        </table>',            
                            'active'=>true,
                                    ),
                    ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    )); */
        ?>
    </div>

</div>
<div class="form-actions">
    <div style="float:left;margin-right:6px;">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')
        ); ?>
    </div>
    <div style="float:left;">
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKasHarian');

        ?>
    </div>
    <div style="clear:both;"></div>
</div>
<?php
$jsx = <<< JSCRIPT
    function print(caraPrint)
    {
        window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>
<?php
Yii::app()->clientScript->registerScript('test', '
    function resizeIframe(obj){
           obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
        }    
    function setType(obj){
        $("#type").val($(obj).attr("type"));
        $(obj).parents("ul").find("li").each(function(){
            $(this).removeClass("active");
        });
        $(obj).addClass("active");
        $.fn.yiiGridView.update("tableLaporan", {
                data: $(this).serialize()
        });
        return false;
    }
', CClientScript::POS_HEAD);

?>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php
Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BKClosingkasirT_tgl_awal').val(data.periodeawal);
            $('#BKClosingkasirT_tgl_akhir').val(data.periodeakhir);
            $('#PPRuanganM_tgl_awal').val(data.periodeawal);
            $('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
//            if(data.namaPeriode == 1 ){
//                myAlert("Pencarian Berdasarkan : "+data.namaPeriode);
//            }
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode', $js, CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event) {
        var namaPeriode = $('#PeriodeName').val();

        if (namaPeriode == '') {
            myAlert('Silakan pilih kategori pencarian!');
            event.preventDefault();
            $('#dtPicker3').datepicker("hide");
            return true;;
        }
    }

    $(document).ready(function() {
        dropMulti("<?php echo CHtml::activeId($model, 'pegawai_id') ?>");
        dropMulti("<?php echo CHtml::activeId($model, 'shift_id') ?>");
    });
</script>
<?php $this->renderPartial('/laporanKasHarian/_jsFunctions', array('model' => $model)); ?>