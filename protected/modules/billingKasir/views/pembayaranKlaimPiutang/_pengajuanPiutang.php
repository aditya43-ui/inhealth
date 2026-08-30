
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'GET',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'
            ),
        )
    );
    $modPengajuanKlaim->totaltagihan = MyFormatter::formatNumberForPrint($modPengajuanKlaim->totaltagihan, 2);
    $modPengajuanKlaim->totaldiskon = MyFormatter::formatNumberForPrint($modPengajuanKlaim->totaldiskon, 2);
    $modPengajuanKlaim->totalpiutang = MyFormatter::formatNumberForPrint($modPengajuanKlaim->totalpiutang, 2);
    $modPengajuanKlaim->totalbayar = MyFormatter::formatNumberForPrint($modPengajuanKlaim->totalbayar, 2);
    $modPengajuanKlaim->totalsisapiutang = MyFormatter::formatNumberForPrint($modPengajuanKlaim->totalsisapiutang, 2);

    
?>

<div class="row">
    <div class="col-sm-6">
      <div class="col-sm-6" hidden>
  			<div class="control-group">
  				<?php echo CHtml::label('Tgl. Pelayanan', 'tgl_pendaftaran',array('class'=>'control-label')); ?>
  				<div class="controls">
  						<?php
  							$modPendaftaran->tgl_awal = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_awal);
  							$this->widget('MyDateTimePicker',array(
  											'name' => 'Filter[tgl_awal]',
  											'model'=>$modPendaftaran,
  											'attribute'=>'tgl_awal',
  											'mode'=>'date',
  											'options'=> array(
  												'dateFormat'=>Params::DATE_FORMAT,
  											),
  											'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
  		//                                    'onchange'=>'ajaxGetList()',
  											),
  							));
  							$modPendaftaran->tgl_awal = MyFormatter::formatDateTimeForDb($modPendaftaran->tgl_awal);
  						?>
  				</div>
  			</div>
  			<div class="control-group">
  				<?php echo CHtml::label('Sampai Dengan', 'sampai dengan',array('class'=>'control-label')); ?>
  				<div class="controls">
  						<?php
  							$modPendaftaran->tgl_akhir = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_akhir);
  							$this->widget('MyDateTimePicker',array(
  											'name' => 'Filter[tgl_akhir]',
  											'model'=>$modPendaftaran,
  											'attribute'=>'tgl_akhir',
  											'mode'=>'date',
  											'options'=> array(
  												'dateFormat'=>Params::DATE_FORMAT,
  											),
  											'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
  		//                                    'onchange'=>'ajaxGetList()',
  											),
  							));
  							$modPendaftaran->tgl_akhir = MyFormatter::formatDateTimeForDb($modPendaftaran->tgl_akhir);
  						?>
  				</div>
  			</div>
  		</div>
      <div class="control-group">
          <?php echo CHtml::label('Tgl. Pengajuan', 'tglpengajuanklaimanklaim',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeHiddenField($modPengajuanKlaim,'pengajuanklaimpiutang_id',array('id'=>'pengajuanklaimpiutang_id')); ?>
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'tglpengajuanklaimanklaim',array('class'=>'span3','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('No. Pengajuan', 'nopengajuanklaimanklaim',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php 
            
            if (isset($_GET['pengajuanklaim_id'])) {
                echo CHtml::activeTextField($modPengajuanKlaim, 'nopengajuanklaimanklaim',array('class'=>'span3','readonly'=>true)); 
                
            } else {
            
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPengajuanKlaim,
                    'attribute' => 'nopengajuanklaimanklaim',
                    'source' => 'js: function(request, response) {
                       $.ajax({
                           url: "' . $this->createUrl('autocompletePengajuanKlaimPiutang') . '",
                           dataType: "json",
                           data: {
                               term: request.term,
                           },
                           success: function (data) {
                                   response(data);
                           }
                       })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(""); //SUPAYA TERLIHAT DATA SUDAH TERPILIH ATAU BELUM
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            setPengajuanKlaimPiutang(ui.item);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array('class'=>'span3'),
                    'tombolDialog' => array('idDialog' => 'dialogPengajuanKlaim'),
                ));
            }
            
            
            
            ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('Tgl. Jatuh Tempo', 'tgljatuhtempo',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'tgljatuhtempo',array('class'=>'span3','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeHiddenField($modPendaftaran,'carabayar_id'); ?>
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'carabayar_nama',array('class'=>'span3','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('Penjamin', 'penjamin_nama',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeHiddenField($modPendaftaran,'penjamin_id'); ?>
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'penjamin_nama',array('class'=>'span3','readonly'=>true)); ?>
          </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="control-group">
          <?php echo CHtml::label('Total Tagihan', 'totaltagihan',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'totaltagihan',array('class'=>'span3 integer-decimal','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('Total Keringanan', 'totaldiskon',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'totaldiskon',array('class'=>'span3 integer-decimal','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('Total Piutang', 'totalpiutang',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'totalpiutang',array('class'=>'span3 integer-decimal','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('Total Pengajuan', 'totalbayar',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'totalbayar',array('class'=>'span3 integer-decimal','readonly'=>true)); ?>
          </div>
      </div>
      <div class="control-group">
          <?php echo CHtml::label('Total Sisa Piutang', 'totalsisapiutang',array('class'=>'control-label')); ?>
          <div class="controls">
            <?php echo CHtml::activeTextField($modPengajuanKlaim, 'totalsisapiutang',array('class'=>'span3 integer-decimal','readonly'=>true)); ?>
          </div>
      </div>
    </div>
</div>

<?php
    $this->endWidget();
?>



<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPengajuanKlaim',
        'options' => array(
            'title' => 'List Pengajuan Klaim Piutang',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);

$klaim = new BKPengajuanklaimpiutangT;
$klaim->unsetAttributes();

if (isset($_GET['BKPengajuanklaimpiutangT'])) {
    $klaim->attributes = $_GET['BKPengajuanklaimpiutangT'];
}

$cpenjamin = new CDbCriteria;
$cpenjamin->compare('carabayar_id', $klaim->carabayar_id);
$cpenjamin->addCondition('penjamin_aktif = true');
$cpenjamin->order = 'penjamin_nama';

$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'pengajuanklaim-grid',
        'dataProvider' => $klaim->searchDialogKlaim(),
        'filter' => $klaim,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data) {
                    $data->tglpengajuanklaimanklaim = MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim);
                    $data->tgljatuhtempo = MyFormatter::formatDateTimeForUser($data->tgljatuhtempo);
                    
                    $res2 = $data->attributes;
                    $res2['carabayar_nama'] = $data->carabayar->carabayar_nama;
                    $res2['penjamin_nama'] = $data->penjamin->penjamin_nama;
                    
                    $res = CJSON::encode($res2);
                    
                    return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                        'onclick'=>"setPengajuanKlaimPiutang(".$res."); $('#dialogPengajuanKlaim').dialog('close')",
                    ));
                    
                },
            ),
            array(
                'header'=>'Tanggal Pengajuan Klaim',
                'name'=>'tglpengajuanklaimanklaim',
                'filter'=>false,
            ),
            array(
                'header'=>'Nomor Pengajuan Klaim',
                'name'=>'nopengajuanklaimanklaim',
            ),
            array(
                'header' => 'Jenis Penjamin',
                'name' => 'carabayar_id',
                'type' => 'raw',
                'value' => '$data->carabayar->carabayar_nama',
                'filter' => CHtml::activeDropDownList($klaim, 'carabayar_id', CHtml::listData(
                    CarabayarM::model()->findAllByAttributes(array(
                        'carabayar_aktif' => true,
                    ), array('order' => 'carabayar_nama')),
                    'carabayar_id',
                    'carabayar_nama'
                ), array(
                    'empty' => '-- Pilih --',
                )),
            ),
            array(
                'header' => 'Penjamin',
                'name' => 'penjamin_id',
                'type' => 'raw',
                'value' => '$data->penjamin->penjamin_nama',
                'filter' => CHtml::activeDropDownList($klaim, 'penjamin_id', CHtml::listData(
                    PenjaminpasienM::model()->findAll($cpenjamin),
                    'penjamin_id',
                    'penjamin_nama'
                ), array(
                    'empty' => '-- Pilih --',
                )),
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>