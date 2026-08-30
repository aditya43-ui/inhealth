<div class="panel panel-primary panel-success">
  <div class="panel-heading">
      <div class="panel-title">Diet</div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-12">
        <div class="control-group ">
            <?php echo CHtml::label('Waktu Pemberian', 'waktu_pemberiadiet', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="form-inline">
                  <?php echo CHtml::radioButtonList('waktu_pemberiadiet','',array("Pagi"=>"Pagi","Siang"=>"Siang","Malam"=>"Malam"), array('class'=>'waktu_pemberiadiet','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;'));?>
              </div>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Jam Pemberian', '', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker',array(
                  'id'=>'jam_pemberiandiet',
                  'name'=>'jam_pemberiandiet',
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
            <?php echo CHtml::label('Jumlah', 'jumlahdiet', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('jumlahdiet', '',array('class'=>'span3 float2'));
              ?>
              <?php echo CHtml::dropDownList('satuan_jumlahdiet', '', LookupM::getItems('satuancairan'), array('class'=>'span2','empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Keterangan', 'keterangandiet', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('keterangandiet', '',array('class'=>'span3'));
              ?>
            </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah',
              array('onclick'=>'tambahDiet(this);return false;',
                    'class'=>'btn btn-primary',
                    'id'=>'tomboltambah',
                    'onkeypress'=>"tambahDiet(this);return false;",
                    'rel'=>"tooltip",
                    'title'=>"Klik untuk menambahkan ke tabel Diet")); ?>
    </div>
    <div style="overflow: auto;">
      <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblDiet">
        <thead>
          <tr>
              <th style="width:50px">No</th>
              <th style="width:100px">Waktu Pemberian</th>
              <th style="width:100px">Jam Pemberian</th>
              <th style="width:50px">Jumlah</th>
              <th style="width:150px">Keterangan</th>
              <th style="width:80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($modDetDiet)){
              $htmldiet = "";
              $nourut = 0;
              foreach($modDetDiet as $i => $det){
                $nourut++;
                $htmldiet .= "<tr>";
                $htmldiet .= "<td>";
                $htmldiet .= CHtml::hiddenField('BalancecairandietT['.$i.'][waktu_pemberian]',$det->waktu_pemberian,array('class'=>'waktu_pemberian'));
                $htmldiet .= CHtml::hiddenField('BalancecairandietT['.$i.'][jumlah]',$det->jumlah,array('class'=>'jumlah'));
                $htmldiet .= CHtml::hiddenField('BalancecairandietT['.$i.'][keterangan]',$det->keterangan,array('class'=>'keterangan'));
                $htmldiet .= CHtml::hiddenField('BalancecairandietT['.$i.'][jam_pemberian]',$det->jam_pemberian,array('class'=>'jam_pemberian'));
                $htmldiet .= CHtml::hiddenField('BalancecairandietT['.$i.'][satuan_jumlah]',$det->satuan_jumlah,array('class'=>'satuan_jumlah'));
                $htmldiet .= '<span class="nourut">'.$nourut.'</span>';
                $htmldiet .= "</td>";
                $htmldiet .= "<td><span>".$det->waktu_pemberian."</span></td>";
                $htmldiet .= "<td><span>".$det->jam_pemberian."</span></td>";
                $htmldiet .= "<td><span>".$det->jumlah." ".$det->satuan_jumlah."</span></td>";
                $htmldiet .= "<td><span>".$det->keterangan."</span></td>";
                $htmldiet .= '<td style="text-align: center;"><a onclick="batalDiet(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Diet"><i class="icon-remove"></i></a></td>';
                $htmldiet .= "</tr>";
              }
              echo $htmldiet;
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
