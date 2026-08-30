<div class="panel panel-primary panel-success">
  <div class="panel-heading">
      <div class="panel-title">Cairan Keluar</div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Cairan', 'nama_cairankeluar', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::dropDownList('nama_cairankeluar', '',LookupM::getItems('cairankeluar'),array('empty'=>'Pilih','class'=>'span3','onchange'=>'setCairanKeluar();'));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Waktu Pemberiksaan', 'waktu_pemberiankeluar', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="form-inline">
                  <?php echo CHtml::radioButtonList('waktu_pemberiankeluar','',array("Pagi"=>"Pagi","Siang"=>"Siang","Malam"=>"Malam"), array('class'=>'waktu_pemberiankeluar','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;'));?>
              </div>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Jam', '', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker',array(
                  'id'=>'jam',
                  'name'=>'jam',
                    'mode'=>'time',
                    'options'=> array(
                            'showOn' => false,
                    ),
                    'htmlOptions'=>array(
                      'readonly'=>TRUE,
                      'class'=>'span2',
                      'placeholder'=>'00:00:00',
                      'onkeyup'=>"return $(this).focusNextInputField(event),",
                    ),
                  ));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Jumlah', 'jumlahkeluar', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('jumlahkeluar', '',array('class'=>'span3 float2'));
              ?>
              <?php echo CHtml::dropDownList('satuan_jumlahkeluar', '', LookupM::getItems('satuancairan'), array('class'=>'span2','empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="control-group " id="statusPeg">
            <?php echo CHtml::label('Status Penggunaan', 'statuspenggunaankeluar', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="controls">
                <div class="form-inline">
                    <?php echo CHtml::radioButtonList('statuspenggunaankeluar','',array("1"=>"Ya","0"=>"Tidak"), array('class'=>'statuspenggunaankeluar','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'statusPenggunaCairanKeluar()'));?>
                </div>
              </div>
            </div>
        </div>
        <div class="control-group " id="keteranganKeluar">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              echo CHtml::dropDownList('keterangankeluar', '',array('Pasang'=>'Pasang','Lepas'=>'Lepas'),array('empty'=>'Pilih','class'=>'span3'));
              ?>
            </div>
        </div>
        <div class="control-group " id="keteranganKeluarV2">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              echo CHtml::textField('keterangankeluar_v2', '',array('class'=>'span3','maxlength'=>'200'));
              ?>
            </div>
        </div>
        <div class="control-group " id="balanceCair" hidden>
            <?php echo CHtml::label('Balance Cairan', 'balance_cairan', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('balance_cairan', '',array('class'=>'span3','maxlength'=>'200'));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Waktu Pemasangan', 'waktu_pemasangankeluar', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker', array(
                  'id' => 'waktu_pemasangankeluar',
                  'name' => 'waktu_pemasangankeluar',
                  'mode' => 'datetime',
                  'options' => array(
                      'dateFormat' => Params::DATE_FORMAT,
                  ),
                  'htmlOptions' => array(
                      'readonly' => true,
                      'onkeypress' => "return $(this).focusNextInputField(event)",
                      'class'=>'span3',
                  ),
              ));
              ?>
            </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah',
              array('onclick'=>'tambahCairanKeluar(this);return false;',
                    'class'=>'btn btn-primary',
                    'id'=>'tomboltambah',
                    'onkeypress'=>"tambahCairanKeluar(this);return false;",
                    'rel'=>"tooltip",
                    'title'=>"Klik untuk menambahkan ke tabel Cairan Keluar")); ?>
    </div>
    <div style="overflow: auto;">
      <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblCairanKeluar">
        <thead>
          <tr>
              <th style="width:50px">No</th>
              <th style="width:100px">Nama Cairan</th>
              <th style="width:100px">Waktu Pemeriksaan</th>
              <th style="width:100px">Jam</th>
              <th style="width:50px">Jumlah</th>
              <th style="width:150px">Status Penggunaan</th>
              <th style="width:150px">Keterangan</th>
              <th style="width:80px">Waktu Pemasangan</th>
              <th style="width:80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($modDetCairankeluar)){
              $htmlcairankeluar = "";
              $nourut = 0;
              foreach($modDetCairankeluar as $i => $det){
                $nourut++;
                $htmlcairankeluar .= "<tr>";
                $htmlcairankeluar .= "<td>";
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][nama_cairan]',$det->nama_cairan,array('class'=>'nama_cairan'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][waktu_pemberian]',$det->waktu_pemberian,array('class'=>'waktu_pemberian'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][jumlah]',$det->jumlah,array('class'=>'jumlah'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][statuspenggunaan]',$det->statuspenggunaan,array('class'=>'statuspenggunaan'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][keterangan]',$det->keterangan,array('class'=>'keterangan'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][waktu_pemasangan]',$det->waktu_pemasangan,array('class'=>'waktu_pemasangan'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][balance_cairan]',$det->balance_cairan,array('class'=>'balance_cairan'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][jam]',$det->jam,array('class'=>'jam'));
                $htmlcairankeluar .= CHtml::hiddenField('BalancecairankeluarT['.$i.'][satuan_jumlah]',$det->satuan_jumlah,array('class'=>'satuan_jumlah'));
                $htmlcairankeluar .= '<span class="nourut">'.$nourut.'</span>';
                $htmlcairankeluar .= "</td>";
                $htmlcairankeluar .= "<td><span>".$det->nama_cairan."</span></td>";
                $htmlcairankeluar .= "<td><span>".$det->waktu_pemberian."</span></td>";
                $htmlcairankeluar .= "<td><span>".$det->jam."</span></td>";
                $htmlcairankeluar .= "<td><span>".$det->jumlah." ".$det->satuan_jumlah."</span></td>";
                $htmlcairankeluar .= "<td><span>".$det->statuspenggunaan."</span></td>";
                $htmlcairankeluar .= "<td><span>".$det->keterangan."</span></td>";
                $htmlcairankeluar .= "<td><span>".(!empty($det->waktu_pemasangan)?MyFormatter::formatDateTimeForUser($det->waktu_pemasangan):"")."</span></td>";
                $htmlcairankeluar .= '<td style="text-align: center;"><a onclick="batalCairanKeluar(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Cairan Keluar"><i class="icon-remove"></i></a></td>';
                $htmlcairankeluar .= "</tr>";
              }
              echo $htmlcairankeluar;
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
