<tr>
  <td width="10%" style="background-color: none !important">
    <?php echo CHtml::dropDownList('fungsigerakdasarsinistra_id',(isset($oriSinistra)?$oriSinistra->fungsigerakdasarsinistra_id:""),CHtml::listData(FungsigerakdasarsinistraM::model()->findAll('fungsigerakdasarsinistra_aktif = true '.(!empty($pemeriksaan_id)?"and periksafungsigerakdasar_id  = ".$pemeriksaan_id:"").' order by fungsigerakdasarsinistra_urutan asc'),'fungsigerakdasarsinistra_id','fungsigerakdasarsinistra_nama'),array('empty'=>'Pilih', 'class'=>'span2 fungsigerakdasarsinistra_id')); ?>
  </td>
  <td width="25%">
    <div class="form-horizontal">
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>Aktif</label>
      <div class="controls"></div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width:50px !important'>Gerakan</label>
      <div class="controls">
          <?php echo CHtml::textField('aktif_gerakan',(isset($oriSinistra)?$oriSinistra->aktif_gerakan:""),array('class'=>'aktif_gerakan_sinistra span2')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>ROM</label>
      <div class="controls">
          <?php echo CHtml::textField('aktif_rom',(isset($oriSinistra)?$oriSinistra->aktif_rom:""),array('class'=>'aktif_rom_sinistra span1')); ?>
          <label>&deg; Derajat</label>
      </div>
    </div>
    </div>

  </td>
  <td width="25%">
    <div class="form-horizontal">
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>Pasif</label>
      <div class="controls"></div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width:50px !important'>Gerakan</label>
      <div class="controls">
          <?php echo CHtml::textField('pasif_gerakan',(isset($oriSinistra)?$oriSinistra->pasif_gerakan:""),array('class'=>'pasif_gerakan_sinistra span2')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>ROM</label>
      <div class="controls">
          <?php echo CHtml::textField('pasif_rom',(isset($oriSinistra)?$oriSinistra->pasif_rom:""),array('class'=>'pasif_rom_sinistra span1')); ?>
          <label>&deg; Derajat</label>
      </div>
    </div>
    </div>

  </td>
  <td width="25%">
    <div class="form-horizontal">
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>Isometrik</label>
      <div class="controls"></div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width:50px !important'>Gerakan</label>
      <div class="controls">
          <?php echo CHtml::textField('isometrik_gerakan',(isset($oriSinistra)?$oriSinistra->isometrik_gerakan:""),array('class'=>'isometrik_gerakan_sinistra span2')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>ROM</label>
      <div class="controls">
          <?php echo CHtml::textField('isometrik_rom',(isset($oriSinistra)?$oriSinistra->isometrik_rom:""),array('class'=>'isometrik_rom_sinistra span1')); ?>
          <label>&deg; Derajat</label>
      </div>
    </div>
    </div>

  </td>

  <td style="text-align: center; vertical-align: middle;">
    <a onclick="batalSinistrasi(this);return false;" class="batalSinistrasi btn btn-primary" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Sinistrasi"><i class="icon-minus icon-white"></i></a>
  </td>

</tr>
