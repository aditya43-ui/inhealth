  <div class="panel-body overflow-x" >
<table id="table-pengiriman" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>No. Kantong Darah</th>
            <th>Jenis Komponen Darah</th>
            <th>Jenis Kantong</th>
            <th>Golongan Darah</th>
            <th>Rhesus</th>
            <th style="text-align: center;">Pilih<br/>Semua</br>
            <?php echo CHtml::checkBox('check_semua',true, array('rel' => 'tooltip', 'title' => 'Pilih semua', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked')) ?>
            </th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
  </div>

