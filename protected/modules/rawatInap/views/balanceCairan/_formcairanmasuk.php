<div class="panel panel-primary panel-success">
  <div class="panel-heading">
      <div class="panel-title">Cairan Masuk</div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Cairan', 'nama_obat', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::dropDownList('nama_cairan', '',LookupM::getItems('cairanmasuk'),array('empty'=>'Pilih','class'=>'span3'));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Waktu Pemberian', 'waktu_pemberian', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="form-inline">
                  <?php echo CHtml::radioButtonList('waktu_pemberian','',array("Pagi"=>"Pagi","Siang"=>"Siang","Malam"=>"Malam"), array('class'=>'waktu_pemberian','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;'));?>
              </div>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Jam Pemberian', '', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker',array(
                  'id'=>'jam_pemberian',
                  'name'=>'jam_pemberian',
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
            <?php echo CHtml::label('Jumlah', 'jumlah', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('jumlah', '',array('class'=>'span3 float2'));
              ?>
              <?php echo CHtml::dropDownList('satuan_jumlah', '', LookupM::getItems('satuancairan'), array('class'=>'span2','empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Status Penggunaan', 'statuspenggunaan', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="controls">
                <div class="form-inline">
                    <?php echo CHtml::radioButtonList('statuspenggunaan','',array("1"=>"Ya","0"=>"Tidak"), array('class'=>'statuspenggunaan','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'statusPenggunaCairanMasuk()'));?>
                </div>
              </div>
            </div>
        </div>
        <div class="control-group " id="keteranganMasuk">
            <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              echo CHtml::dropDownList('keterangan', '',array('Pasang'=>'Pasang','Lepas'=>'Lepas'),array('empty'=>'Pilih','class'=>'span3'));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Waktu Pemasangan', 'waktu_pemasangan', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker', array(
                  'id' => 'waktu_pemasangan',
                  'name' => 'waktu_pemasangan',
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
              array('onclick'=>'tambahCairanMasuk(this);return false;',
                    'class'=>'btn btn-primary',
                    'id'=>'tomboltambah',
                    'onkeypress'=>"tambahCairanMasuk(this);return false;",
                    'rel'=>"tooltip",
                    'title'=>"Klik untuk menambahkan ke tabel Cairan Masuk")); ?>
    </div>
    <div style="overflow: auto;">
      <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblCairanMasuk">
        <thead>
          <tr>
              <th style="width:50px">No</th>
              <th style="width:100px">Nama Cairan</th>
              <th style="width:100px">Waktu Pemberian</th>
              <th style="width:100px">Jam Pemberian</th>
              <th style="width:50px">Jumlah</th>
              <th style="width:150px">Status Penggunaan</th>
              <th style="width:150px">Keterangan</th>
              <th style="width:80px">Waktu Pemasangan</th>
              <th style="width:50px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($modDetCairanmasuk)){
              $htmlcairanmasuk = "";
              $nourut = 0;
              foreach($modDetCairanmasuk as $i => $det){
                $nourut++;
                $htmlcairanmasuk .= "<tr>";
                $htmlcairanmasuk .= "<td>";
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][nama_cairan]',$det->nama_cairan,array('class'=>'nama_cairan'));
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][waktu_pemberian]',$det->waktu_pemberian,array('class'=>'waktu_pemberian'));
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][jumlah]',$det->jumlah,array('class'=>'jumlah'));
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][statuspenggunaan]',$det->statuspenggunaan,array('class'=>'statuspenggunaan'));
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][keterangan]',$det->keterangan,array('class'=>'keterangan'));
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][waktu_pemasangan]',$det->waktu_pemasangan,array('class'=>'waktu_pemasangan'));
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][jam_pemberian]',$det->jam_pemberian,array('class'=>'jam_pemberian'));
                $htmlcairanmasuk .= CHtml::hiddenField('BalancecairanmasukT['.$i.'][satuan_jumlah]',$det->satuan_jumlah,array('class'=>'satuan_jumlah'));
                $htmlcairanmasuk .= '<span class="nourut">'.$nourut.'</span>';
                $htmlcairanmasuk .= "</td>";
                $htmlcairanmasuk .= "<td><span>".$det->nama_cairan."</span></td>";
                $htmlcairanmasuk .= "<td><span>".$det->waktu_pemberian."</span></td>";
                $htmlcairanmasuk .= "<td><span>".$det->jam_pemberian."</span></td>";
                $htmlcairanmasuk .= "<td><span>".$det->jumlah." ".$det->satuan_jumlah."</span></td>";
                $htmlcairanmasuk .= "<td><span>".$det->statuspenggunaan."</span></td>";
                $htmlcairanmasuk .= "<td><span>".$det->keterangan."</span></td>";
                $htmlcairanmasuk .= "<td><span>".(!empty($det->waktu_pemasangan)?MyFormatter::formatDateTimeForUser($det->waktu_pemasangan):"")."</span></td>";
                $htmlcairanmasuk .= '<td style="text-align: center;"><a onclick="batalCairanMasuk(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Cairan Masuk"><i class="icon-remove"></i></a></td>';
                $htmlcairanmasuk .= "</tr>";
              }
              echo $htmlcairanmasuk;
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
