<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Tanda Vital</div>
    </div>
    <div class="panel-body">
      <?php
      $modRiwayat = new GrafiktandavitalT();
      $modRiwayat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modRiwayat->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

      $this->widget('ext.bootstrap.widgets.BootGridView', array(
          'id' => 'riwayattandavital-grid',
          'dataProvider' => $modRiwayat->searchRiwayat(),
          'template' => "{summary}\n{items}\n{pager}",
          'itemsCssClass' => 'table table-bordered table-striped table-condensed',
          'columns' => array(
            array(
                'header' => 'No',
                'type' => 'raw',
                'value' => '$row+1',
            ),
            array(
                'header' => 'Tanggal',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_monitoring)',
            ),
            array(
                'header' => 'Suhu',
                'type' => 'raw',
                'value' => '$data->suhu',
            ),
            array(
                'header' => 'Tekanan Darah',
                'type' => 'raw',
                'value' => '$data->td_systolic."/".$data->td_dyastolic',
            ),
            array(
                'header' => 'Nadi/Pulse',
                'type' => 'raw',
                'value' => '$data->nadi',
            ),
            array(
                'header' => 'Pernapasan',
                'type' => 'raw',
                'value' => '$data->pernapasan',
            ),
            array(
                'header' => 'Waktu Tindakan',
                'type' => 'raw',
                'value' => '$data->jam_monitoring',
            ),
          ),
          'afterAjaxUpdate' => 'function(id, data){
      			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
      			}',
      ));
      ?>
    </div>
</div>
