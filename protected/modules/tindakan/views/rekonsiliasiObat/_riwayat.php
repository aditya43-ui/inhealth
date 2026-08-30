<table class="table table-bordered table-striped table-condensed">
  <thead>
    <tr>
      <th>Obat Alergi</th>
      <th>Obat Sebelum Admisi</th>
      <th>Obat Saat Transfer</th>
      <th>Obat Saat Discharge</th>
      <th>Print</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="text-align: center;">
        <?php echo CHtml::link(
            '<icon class="icon-form-detail"></icon>', "javascript:void(0)",
            array(
                // "target"=>"iframeObatAlergi",
                "onclick"=> "checkOpenDialogAll('alergi');",
                "rel"=>"tooltip",
                "title"=>"Klik untuk Melihat Detail Obat Alergi",

            )); ?>
      </td>
      <td style="text-align: center;">
        <?php echo CHtml::link(
            '<icon class="icon-form-detail"></icon>', "javascript:void(0)",
            array(
                // "target"=>"iframeObatAlergi",
                "onclick"=>"checkOpenDialogAll('admisi');",
                "rel"=>"tooltip",
                "title"=>"Klik untuk Melihat Detail Obat Sebelum Admisi",

            )); ?>
      </td>
      <td style="text-align: center;">
        <?php echo CHtml::link(
            '<icon class="icon-form-detail"></icon>', "javascript:void(0)",
            array(
                // "target"=>"iframeObatAlergi",
                "onclick"=>"checkOpenDialogAll('transfer');",
                "rel"=>"tooltip",
                "title"=>"Klik untuk Melihat Detail Obat Saat Transfer",

            )); ?>
      </td>
      <td style="text-align: center;">
        <?php echo CHtml::link(
            '<icon class="icon-form-detail"></icon>', "javascript:void(0)",
            array(
                // "target"=>"iframeObatAlergi",
                "onclick"=>"checkOpenDialogAll('discharge');",
                "rel"=>"tooltip",
                "title"=>"Klik untuk Melihat Detail Obat Saat Discharge",

            )); ?>
      </td>
      <td style="text-align: center;">
        <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type'=>'primary',
            'buttons'=>array(
                array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'javascript:void(0)', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
                array('label'=>'', 'items'=>array(
                    array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'javascript:void(0)', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                    array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'javascript:void(0)', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),

                )),
            ),
            'htmlOptions'=>array('style'=>'float:right')
        )); ?>

      </td>
    </tr>
  </tbody>
</table>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogObatAlergi',
        'options' => array(
            'title' => 'Detail Obat Alergi',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
  <?php $this->renderPartial($this->path_view.'_riwayatObatAlergi',array('modPendaftaran'=>$modPendaftaran)); ?>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogObatDischarge',
        'options' => array(
            'title' => 'Detail Obat Discharge ',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
  <?php $this->renderPartial($this->path_view.'_riwayatObatDischarge',array('modPendaftaran'=>$modPendaftaran)); ?>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogObatAdmisi',
        'options' => array(
            'title' => 'Detail Obat Admisi ',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
  <?php $this->renderPartial($this->path_view.'_riwayatObatAdmisi',array('modPendaftaran'=>$modPendaftaran)); ?>
<?php $this->endWidget(); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogObatTransfer',
        'options' => array(
            'title' => 'Detail Obat Transfer ',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
  <?php $this->renderPartial($this->path_view.'_riwayatObatTransfer',array('modPendaftaran'=>$modPendaftaran)); ?>
<?php $this->endWidget(); ?>

<script type="text/javascript">
  function print(caraPrint)
  {
    var pendaftaran_id = $('#<?php echo CHtml::activeId($modPendaftaran,'pendaftaran_id') ?>').val();
    if(pendaftaran_id != ''){
      window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }else{
      myAlert('Silakan isi data pasien!!');
    }
  }

  function checkOpenDialogAll(type){
    var pendaftaran_id = $('#<?php echo CHtml::activeId($modPendaftaran,'pendaftaran_id') ?>').val();

    if(pendaftaran_id != ''){
      if(type == 'alergi'){
        $.fn.yiiGridView.update('riwayatAlergiObat-grid', { data: $(this).serialize() });
        $('#dialogObatAlergi').dialog('open');
      }else if(type == 'admisi'){
        $.fn.yiiGridView.update('riwayatAlergiAdmisi-grid', { data: $(this).serialize() });
        $('#dialogObatAdmisi').dialog('open');
      }else if(type == 'transfer'){
        $.fn.yiiGridView.update('riwayatAlergiTransfer-grid', { data: $(this).serialize() });
        $('#dialogObatTransfer').dialog('open');
      }else if(type == 'discharge'){
        $.fn.yiiGridView.update('riwayatAlergiDischarge-grid', { data: $(this).serialize() });
        $('#dialogObatDischarge').dialog('open');
      }
    }else{
      myAlert('Silakan isi data pasien!!');
    }

  }
</script>
