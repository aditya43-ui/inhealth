<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
        <table>
            <tr>
                <td>
                    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
                    <?php echo CHtml::label('Kategori', ' berdasarkan', array('class'=>'control-label')) ?>
                      <div class='controls'>
                       <?php echo $form->dropDownList($modPPInfoKunjunganV,'bulan',
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
                      </div>
                </td>
                
            </tr>
            <tr>
                <td width="50%">
                     
                    <?php echo CHtml::hiddenField('type', ''); ?>
                      <div class="control-group">
                            <?php echo Chtml::label('Periode Laporan', 'tglKunjungan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPPInfoKunjunganV,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick'=>'checkPilihan(event)','onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
              </td>
                <td width="100%">
                   <div class="control-group">
                            <?php echo Chtml::label('Sampai Dengan', 'sampai dengan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPPInfoKunjunganV,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick'=>'checkPilihan(event)','onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
              </td>
            </tr>
  </table>

<table width="600" border="0">
  <tr>
    <td>  <div id='searching'>
                    <fieldset>
	<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'big',
//                                    'disabled'=>true,
                            'content'=>array(
                                'content1'=>array(
                                    'header'=>'Berdasarkan Wilayah',
                                    'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($modPPInfoKunjunganV, 'propinsi_id', CHtml::listData($modPPInfoKunjunganV->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
                                                    'ajax' => array('type' => 'POST',
                                                        'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => ''.$modPPInfoKunjunganV->getNamaModel().'')),
                                                        'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kabupaten_id').''),
                                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                                )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
                                                $form->dropDownList($modPPInfoKunjunganV, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
                                                    'ajax' => array('type' => 'POST',
                                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => ''.$modPPInfoKunjunganV->getNamaModel().'')),
                                                    'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kecamatan_id').''),
                                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                                )).'</td></tr></table>',
//                                                        .$form->dropDownList($modPPInfoKunjunganV, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
//                                                            'ajax' => array('type' => 'POST',
//                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => ''.$modPPInfoKunjunganV->getNamaModel().'')),
//                                                                'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kelurahan_id').''),
//                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
//                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
//                                                        $form->dropDownList($modPPInfoKunjunganV, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
                                    'active'=>true,
                                    ),   ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>      </fieldset>
      </td>
    <td> <fieldset>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'kunjungan',
                                    'slide'=>true,
									'content'=>array(
                                        'content2'=>array(
                                            'header'=>'Berdasarkan Jenis Penjamin',
                                            'isi'=>'<table><tr>
                                                        <td>'.CHtml::hiddenField('filter', 'carabayar',array('disabled'=>'disabled')).'<label>Jenis Penjamin</label></td>
                                                        <td>'.$form->dropDownList($modPPInfoKunjunganV, 'carabayar_id', CHtml::listData($modPPInfoKunjunganV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$modPPInfoKunjunganV->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'penjamin_id').'',  //selector to update
                                                            ),
                                                        )).'</td>
                                                            </tr><tr>
                                                        <td><label>Penjamin</label></td><td>'.
                                                        $form->dropDownList($modPPInfoKunjunganV, 'penjamin_id', CHtml::listData($modPPInfoKunjunganV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>', 'active'=>false,       
                                            'active'=>true,
                                            ),
                                    ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>
							</fieldset>
							  </fieldset>
      </td>
  </tr>
</table>

	 
			
                   

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>


<?php
$urlPeriode = $this->createUrl('GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#PPInfoKunjunganRJV_tgl_awal').val(data.periodeawal);
            $('#PPInfoKunjunganRJV_tgl_akhir').val(data.periodeakhir);
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
