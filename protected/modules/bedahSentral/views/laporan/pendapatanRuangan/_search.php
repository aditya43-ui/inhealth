<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    
    $format = new MyFormatter();
    ?>
   <style>

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }
		label.checkbox{
			width:100px;
			display:inline-block;
		}
    </style>  
    <div class="row">
		<!--RND-8745  untuk penginputan tanggan "sampai dengan" sebaiknya sejajar dengan penginputan tanggal pelayanan-->
        <div class="col-sm-4">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::label('Periode Laporan', 'tgl_tindakan', array('class' => 'control-label')) ?>
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
                        'htmlOptions' => array('readonly' => true, 'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
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
                        'htmlOptions' => array('readonly' => true,
                            'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
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
                        'htmlOptions' => array('readonly' => true, 'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
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
                        'htmlOptions' => array('readonly' => true, 'class' => "span2",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
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
    <table width="100%" border="0">
            <tr>
                <td> 
                    <div id='searching'>
                    <fieldset>    
                       <?php 
						$cri = new CDbCriteria();
						$cri->join = "JOIN kelasruangan_m kr ON kr.kelaspelayanan_id = t.kelaspelayanan_id";
						$cri->addCondition(" t.kelaspelayanan_aktif = TRUE ");
						$cri->addCondition(" kr.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
						$cri->order = "t.kelaspelayanan_nama ASC";
						
						$kelas = KelaspelayananM::model()->findAll($cri);						
						$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kunjungan',
                            'slide'=>true,
                            'content'=>array(
                            'content2'=>array(
                                'header'=>'Berdasarkan Kelas pelayanan',
                                'isi'=>  CHtml::checkBox('cek_all', true, array("id"=>"checkSemuaid",'value'=>'cek', "onclick"=>"checkSemua()")).'Pilih Semua <br>                                             
                                            <table class="penjamin">                                            
                                            <tr>
                                                    <td>'.
                                                           $form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData($kelas, 'kelaspelayanan_id', 'kelaspelayanan_nama'))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>true,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>											
                    </fieldset>	
                    </div>
                </td>
                <td> 
                    <div id='searching'>
                    <fieldset>    
                          <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'kunjungana',
                        'slide' => true,
                        'content' => array(
                            'content22' => array(
                                'header' => 'Berdasarkan Jenis Penjamin',
                                'isi' => '<table><tr>
                        <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Jenis Penjamin</label></td>
                        <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array('type' => 'POST',
                                        'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                        'update' => '#' . CHtml::activeId($model, 'penjamin_id') . '', //selector to update
                                    ),
                                )) . '</td>
                            </tr><tr>
                        <td><label>Penjamin</label></td><td>' .
                                $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . '</td></tr></table>',
                                'active' => true,
                            ),
                        ),
                    ));
                    ?>										
                    </fieldset>	
                    </div>
                </td>
                </tr>
                <tr>
					
						<td style = "text-align:left;">
                        <div id='searching'>
                    <fieldset>    
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kunjungan2',
                            'slide'=>true,
                            'content'=>array(
                            'content3'=>array(
                                'header'=>'Berdasarkan Dokter',
                                'isi'=>  '
                                            <table>                                            
                                            <tr>
                                                    <td>'.$form->dropDownListRow($model,'nama_pegawai',  CHtml::listData(DokterV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'  ORDER BY nama_pegawai ASC"), 'nama_pegawai', 'namaLengkap'),array('empty'=>'-- Pilih --'))
                                                    .'</td>
                                            </tr>
                                            </table>
                                            <table  id="penjamin">
                                            <tr>
                                                <td></td>
                                            </tr>
                                            </table>',            
                                'active'=>true,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>											
                    </fieldset>	
                    </div>
                        
                    
					</td>
					<td>
						<?php 
                    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'kunjungan5',
                        'slide' => true,
                        'content'=>array(
                        'content5'=>array(
                            'header'=>'Opsi Grafik',
                            'isi'=>  '<table>
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'kelaspelayanan')).' <label>Kelas Pelayanan</label></td>                                               
											<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'carabayar')).' <label>Jenis Penjamin</label></td>                                               
                                        </tr>                                        										
                                    </table>',          
                            'active'=>TRUE,
                                ),
                        ),
    //                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>	
					</td>
				</tr>
            </table>       
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan','onclick'=>'pilihPencarian();')); ?>
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
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
function checkAll() {
    if ($("#checkAllKelas").is(":checked")) {
        $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function(){
           $(this).attr('checked',true);
        })
    } else {
       $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
    
    if ($("#checkAllCaraBayar").is(":checked")) {
        $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).attr('checked',true);
        })
    } else {
       $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
}   
function konfirmasi(){
    location.reload();
}
function pilihPencarian(){
   // var idCaraBayar = parseFloat($('#BSLaporanpendapatanruanganV_carabayar_id').val());
   // if(!jQuery.isNumeric(idCaraBayar)){
    //    myAlert('Silakan pilih cara bayar terlebih dahulu!')
   //     return false;
   // }else{
    //    $('#searchLaporan').submit();
   // }
}

 function checkSemua() {
            if ($("#checkSemuaid").is(":checked")) {
                $('.penjamin input[name*="BSLaporanpendapatanruanganV"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('.penjamin input[name*="BSLaporanpendapatanruanganV"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
}
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>