<div class="panel panel-primary panel-success">
  <div class="panel-heading">
      <div class="panel-title">Oksigen</div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-12">
        <div class="control-group ">
            <?php echo CHtml::label('Waktu Pemberian', 'waktu_pemberianoksigen', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="form-inline">
                  <?php echo CHtml::radioButtonList('waktu_pemberianoksigen','',array("Pagi"=>"Pagi","Siang"=>"Siang","Malam"=>"Malam"), array('class'=>'waktu_pemberianoksigen','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;'));?>
              </div>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Jam Pemberian', '', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker',array(
                  'id'=>'jam_pemberianoksigen',
                  'name'=>'jam_pemberianoksigen',
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
            <?php echo CHtml::label('Jumlah', 'jumlahoksigen', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('jumlahoksigen', '',array('class'=>'span3 float2'));
              ?>
              <?php echo CHtml::dropDownList('satuan_jumlahoksigen', '', LookupM::getItems('satuancairan'), array('class'=>'span2','empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('List Oksigen', 'list_oksigen', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textArea('list_oksigen', '',array('class'=>'span3'));
              ?>
            </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah',
              array('onclick'=>'tambahOksigen(this);return false;',
                    'class'=>'btn btn-primary',
                    'id'=>'tomboltambah',
                    'onkeypress'=>"tambahOksigen(this);return false;",
                    'rel'=>"tooltip",
                    'title'=>"Klik untuk menambahkan ke tabel Oksigen")); ?>
    </div>
    <div style="overflow: auto;">
      <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblOksigen">
        <thead>
          <tr>
              <th style="width:50px">No</th>
              <th style="width:100px">Waktu Pemberian</th>
              <th style="width:100px">Jam Pemberian</th>
              <th style="width:50px">Jumlah</th>
              <th style="width:150px">List Oksigen</th>
              <th style="width:80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($modDetOksigen)){
              $htmloksigen = "";
              $nourut = 0;
              foreach($modDetOksigen as $i => $det){
                $nourut++;
                $htmloksigen .= "<tr>";
                $htmloksigen .= "<td>";
                $htmloksigen .= CHtml::hiddenField('BalancecairanoksigenT['.$i.'][waktu_pemberian]',$det->waktu_pemberian,array('class'=>'waktu_pemberian'));
                $htmloksigen .= CHtml::hiddenField('BalancecairanoksigenT['.$i.'][jumlah]',$det->jumlah,array('class'=>'jumlah'));
                $htmloksigen .= CHtml::hiddenField('BalancecairanoksigenT['.$i.'][list_oksigen]',$det->list_oksigen,array('class'=>'list_oksigen'));
                $htmloksigen .= CHtml::hiddenField('BalancecairanoksigenT['.$i.'][jam_pemberian]',$det->jam_pemberian,array('class'=>'jam_pemberian'));
                $htmloksigen .= CHtml::hiddenField('BalancecairanoksigenT['.$i.'][satuan_jumlah]',$det->satuan_jumlah,array('class'=>'satuan_jumlah'));
                $htmloksigen .= '<span class="nourut">'.$nourut.'</span>';
                $htmloksigen .= "</td>";
                $htmloksigen .= "<td><span>".$det->waktu_pemberian."</span></td>";
                $htmloksigen .= "<td><span>".$det->jam_pemberian."</span></td>";
                $htmloksigen .= "<td><span>".$det->jumlah." ".$det->satuan_jumlah."</span></td>";
                $htmloksigen .= "<td><span>".$det->list_oksigen."</span></td>";
                $htmloksigen .= '<td style="text-align: center;"><a onclick="batalOksigen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Oksigen"><i class="icon-remove"></i></a></td>';
                $htmloksigen .= "</tr>";
              }
              echo $htmloksigen;
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
