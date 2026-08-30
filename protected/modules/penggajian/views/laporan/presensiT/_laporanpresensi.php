<style>
    #ruangan label{
		width: 200px;
        display:inline-block;
    }
</style>
<div class="white-container">
    <legend class="rim2">Laporan <b>Presensi</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'laporan-search',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
        )); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                <?php
        //            $model->tglpresensi = $format->formatDateTimeForUser($model->tglpresensi);
        //            $model->tglpresensi_akhir = $format->formatDateTimeForUser($model->tglpresensi_akhir);
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglpresensi',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                  'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                  'class'=>'dtPicker3',
                                             ),
                    )); ?> 
                    </div>
                </div>
                    <?php //echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>30)); ?>
                    <div class="control-group">
                        <label class="control-label">Instalasi</label>
                        <div class="controls">
                            <?php
                                echo $form->dropDownList($model, 'instalasi_id',
                                        CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                            'update' => '#ruangan',
                                        ),
                                    )
                                );
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Ruangan</label>
                        <div class="controls">
                            <div id="ruangan">
                                <label>Data tidak ditemukan.</label>
                            </div>                    
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpresensi_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'changeYear'=>true,
                                                    'changeMonth'=>true,
                                                    'yearRange'=>'-70y:+4y',
                                                    'maxDate'=>'d',
                                                    'showAnim'=>'fold',
                                                    'timeText'=>'Waktu',
                                                    'hourText'=>'Jam',
                                                    'minuteText'=>'Menit',
                                                    'secondText'=>'Detik',
                                                    'showSecond'=>true,
                                                    'timeFormat'=>'hh:mm:ss',

                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?> 
                        </div>
                    </div>  
                    <?php
                        echo $form->dropDownListRow($model,'kategoripegawai', LookupM::model()->GetItems('kategoripegawai'), 
                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width:140px', 
                            )
                        );
                    ?>
                    <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>30)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'no_fingerprint',array('class'=>'span3','maxlength'=>30)); ?>
                    <?php
                        echo $form->dropDownListRow(
                            $model,'unit_perusahaan',LookupM::model()->GetItems('unit_perusahaan'),
                            array('class'=>'span3', 'empty'=>'-- Pilih --')
                        );
                    ?>
                </td>
            </tr>
        </table>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('Laporan/LaporanPresensi'), array('class'=>'btn btn-danger')); ?>
	</div>
    </fieldset>
    <?php
    $this->endWidget();
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Presensi</b></h6>
        <?php $this->renderPartial('presensiT/laporan',array('model'=>$model)); ?>
        <?php //$this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe> 
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanPresensi');
    $url = '';
    $this->renderPartial('_footerPresensi', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>
<script type="text/javascript">
    function checkAll()
    {
        if($("#checkAllRuangan").is(':checked')){
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", false);
        }        
        
    }
</script>