<div class="search-form" style="">
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
<!--   <legend class="rim">Berdasarkan Kunjungan</legend>-->
                    <?php //echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo CHtml::hiddenField('src', ''); ?>
      <table>
            <tr>
                <td>
                    <legend class="rim"><i class="icon-search"></i> Pencarian Berdasarkan : </legend>
                    <div class="control-group ">
                    
                    <?php echo CHtml::hiddenField('filter_tab','rekap',array()); ?>
                    <?php echo CHtml::label('Tanggal Kunjungan ','Tanggal Kunjungan ', array('class'=>'control-label')) ?>
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
<!--                      <div class="control-group ">-->
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
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                            <div style="margin-left:-420px;margin-top:-20px;text-align:left">
                                <font> s/d </font>
                            </div>
<!--                        </div>-->
<!--                    </div>-->
              </td>
              <tr>
                 <td>
<!--                   <div class="control-group ">-->
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
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3','onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
<!--                        </div>-->
<!--                    </div>-->
                </td>
              </tr>
                
            </tr>
            
  </table>

 <div class="form-actions">
            <div style="float:left;margin-right:6px;">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
            </div>
                <div style="float:left;">
                <?php
                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
                    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKasHarian');
                    $this->widget('bootstrap.widgets.BootButtonGroup', array(
                        'type'=>'primary',
                        'buttons'=>array(
                            array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>$urlPrint, 'htmlOptions'=>array('onclick'=>'print(\'PRINT\');return false;')),
                            array('label'=>'',
                                'items'=>array(
                                    array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'PDF\');return false;')),
                                    array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'EXCEL\');return false;')),
                                )
                            ),
                        ),
                    ));
    
$jsx = <<< JSCRIPT
    function print(caraPrint)
    {
        window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
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
        $("#Grafik").attr("src","'.$url.'"+$(".search-form form").serialize());
        return false;
    }
', CClientScript::POS_HEAD);

?>
                    
    </div>
    <div style="clear:both;"></div>
</div> 
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
                myAlert('Pilih Kategori Pencarian');
                event.preventDefault();
                $('#dtPicker3').datepicker("hide");
                return true;
                ;
            }
        }
</script>


