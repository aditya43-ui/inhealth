<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
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
                label.checkbox,
                label.radio {
                    width: 150px;
                    display: inline-block;
                }
            </style>
            <div class="row">
                <div class="col-sm-4">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::hiddenField('filter_tab', 'rekap', array()); ?>
                    <?php echo CHtml::label('Periode', 'tgl_closingkasir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div>

                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_awal',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                        </div>
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_akhir',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                        </div>
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div style="float:left;margin-right:6px;">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onClick' => 'searchForm()')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')); ?>
                </div>
                <div style="float:left;">
                    <?php
                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
                    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanIGD');

                    ?>
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
            $('#BKRekapitulasipenerimaansejenisV_tgl_awal').val(data.periodeawal);
            $('#BKRekapitulasipenerimaansejenisV_tgl_akhir').val(data.periodeakhir);
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
        </script>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>

    </div>
</div>