<div class="panel panel-primary panel-success">
  <div class="panel-heading">
      <div class="panel-title">Program Infus</div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Program', 'nama_program', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="form-inline">
                <?php
                   echo CHtml::textField('nama_program', '',array('class'=>'span3'));
                ?>
              </div>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Waktu', 'waktu', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker', array(
                  'id' => 'waktu',
                  'name' => 'waktu',
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
        <div class="control-group ">
            <?php echo CHtml::label('Jenis', 'jenis', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('jenis', '',array('class'=>'span3'));
              ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Jumlah', 'jumlahinfus', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('jumlahinfus', '',array('class'=>'span3 float2'));
              ?>
              <?php echo CHtml::dropDownList('satuan_jumlahinfus', '', LookupM::getItems('satuancairan'), array('class'=>'span2','empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Tetes', 'tetes', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('tetes', '',array('class'=>'span3'));
              ?> x/menit
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Keterangan', 'keteranganinfus', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textArea('keteranganinfus', '',array('class'=>'span3'));
              ?>
            </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah',
              array('onclick'=>'tambahInfus(this);return false;',
                    'class'=>'btn btn-primary',
                    'id'=>'tomboltambah',
                    'onkeypress'=>"tambahInfus(this);return false;",
                    'rel'=>"tooltip",
                    'title'=>"Klik untuk menambahkan ke tabel Infus")); ?>
    </div>
    <div style="overflow: auto;">
      <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblInfus">
        <thead>
          <tr>
              <th style="width:200px">Nama Program</th>
              <th style="width:100px">Pukul</th>
              <th style="width:100px">Jenis</th>
              <th style="width:100px">Jumlah</th>
              <th style="width:100px">Tetes</th>
              <th style="width:150px">Keterangan</th>
              <th style="width:80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($modDetInfus)){
              $htmlinfus = "";
              $nourut = 0;
              foreach($modDetInfus as $i => $det){
                $nourut++;
                $htmlinfus .= "<tr>";
                $htmlinfus .= "<td>";
                $htmlinfus .= CHtml::hiddenField('PrograminfusT['.$i.'][nama_program]',$det->nama_program,array('class'=>'nama_program'));
                $htmlinfus .= CHtml::hiddenField('PrograminfusT['.$i.'][waktu]',$det->waktu,array('class'=>'waktu'));
                $htmlinfus .= CHtml::hiddenField('PrograminfusT['.$i.'][jenis]',$det->jenis,array('class'=>'jenis'));
                $htmlinfus .= CHtml::hiddenField('PrograminfusT['.$i.'][jumlah]',$det->jumlah,array('class'=>'jumlah'));
                $htmlinfus .= CHtml::hiddenField('PrograminfusT['.$i.'][tetes]',$det->tetes,array('class'=>'tetes'));
                $htmlinfus .= CHtml::hiddenField('PrograminfusT['.$i.'][keterangan]',$det->keterangan,array('class'=>'keterangan'));
                $htmlinfus .= CHtml::hiddenField('PrograminfusT['.$i.'][satuan_jumlah]',$det->satuan_jumlah,array('class'=>'satuan_jumlah'));
                $htmlinfus .= '<span>'.$det->nama_program.'</span>';
                $htmlinfus .= "</td>";
                $htmlinfus .= "<td><span>".(!empty($det->waktu)?MyFormatter::formatDateTimeForUser($det->waktu):"")."</span></td>";
                $htmlinfus .= "<td><span>".$det->jenis."</span></td>";
                $htmlinfus .= "<td><span>".$det->jumlah." ".$det->satuan_jumlah."</span></td>";
                $htmlinfus .= "<td><span>".$det->tetes."</span></td>";
                $htmlinfus .= "<td><span>".$det->keterangan."</span></td>";
                $htmlinfus .= '<td style="text-align: center;"><a onclick="batalInfus(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Program Infus"><i class="icon-remove"></i></a></td>';
                $htmlinfus .= "</tr>";
              }
              echo $htmlinfus;
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
