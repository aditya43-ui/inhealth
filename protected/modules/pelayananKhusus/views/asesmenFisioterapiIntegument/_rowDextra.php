<tr>
  <td width="10%" style="background-color: none !important">
    <?php echo CHtml::dropDownList('fungsigerakdasarsinistra_id',(isset($oriDextra)?$oriDextra->fungsigerakdasarsinistra_id:""),CHtml::listData(FungsigerakdasarsinistraM::model()->findAll('fungsigerakdasarsinistra_aktif = true '.(!empty($pemeriksaan_id)?"and periksafungsigerakdasar_id  = ".$pemeriksaan_id:"").' order by fungsigerakdasarsinistra_urutan asc'),'fungsigerakdasarsinistra_id','fungsigerakdasarsinistra_nama'),array('empty'=>'Pilih', 'class'=>'span2 fungsigerakdasarsinistra_id')); ?>
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
          <?php echo CHtml::textField('aktif_gerakan',(isset($oriDextra)?$oriDextra->aktif_gerakan:""),array('class'=>'aktif_gerakan_dextra span2')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>ROM</label>
      <div class="controls">
          <?php echo CHtml::textField('aktif_rom',(isset($oriDextra)?$oriDextra->aktif_rom:""),array('class'=>'aktif_rom_dextra span2')); ?><label> &deg;Derajat</label>
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
          <?php echo CHtml::textField('pasif_gerakan',(isset($oriDextra)?$oriDextra->pasif_gerakan:""),array('class'=>'pasif_gerakan_dextra span2')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>ROM</label>
      <div class="controls">
          <?php echo CHtml::textField('pasif_rom',(isset($oriDextra)?$oriDextra->pasif_rom:""),array('class'=>'pasif_rom_dextra span2')); ?><label> &deg;Derajat</label>
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
          <?php echo CHtml::textField('isometrik_gerakan',(isset($oriDextra)?$oriDextra->isometrik_gerakan:""),array('class'=>'isometrik_gerakan_dextra span2')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style='width: 50px !important'>ROM</label>
      <div class="controls">
          <?php echo CHtml::textField('isometrik_rom',(isset($oriDextra)?$oriDextra->isometrik_rom:""),array('class'=>'isometrik_rom_dextra span2')); ?><label> &deg;Derajat</label>
      </div>
    </div>
    </div>

  </td>

  <td style="text-align: center; vertical-align: middle;">
    <a onclick="batalDextrasi(this);return false;" class="batalDextra btn btn-primary" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Dextrasi"><i class="icon-minus icon-white"></i></a>
  </td>

</tr>
