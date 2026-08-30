<div class="control-group">
    <label class="control-label">Nama File Baru</label>
    <div class="controls">
        <?php echo CHtml::textField('fileBaru', '',array('class'=>'span3 all-lower nama-file-suara' ,'onblur'=>'tambahSuara(this);','onkeypress'=>'return $(this).focusNextInputField(event)')
            ); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Jenis Suara</label>
    <div class="controls">
        <?php echo CHtml::dropDownList('jenisSuara', '',LookupM::getItemsUrutan('jeniskelamin'),array('class'=>'span3 all-lower nama-file-suara' ,'onblur'=>'tambahSuara(this);','onkeypress'=>'return $(this).focusNextInputField(event)')
            ); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">&nbsp;</label>
    <div class="controls">
        <?php            
            echo CHtml::link("Upload File Suara",'javascript:;',array('onclick'=>'fileLoad(this,"tambahbaru");','class'=>'btn btn-success' ,'style'=>'width:200px;','rel'=>'tooltip','data-original-title'=>'Klik untuk upload suara',)).'&nbsp;';                
            echo '<br/>'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this,"tambahbaru");','class'=>'labelbrowse','rel'=>'tooltip','data-original-title'=>'Klik untuk mencari file suara','style'=>'color:red;'));
            echo '&nbsp;'.CHtml::link("<i class='entypo-upload'></i>",'javascript:;',array('onclick'=>'simpanSuara(this,"tambahbaru");','class'=>'buttonupload btn btn-info hide','rel'=>'tooltip','data-original-title'=>'Klik untuk upload suara','style'=>'margin:5px;'));
            echo "<div class='hide'>";
            echo CHtml::fileField('suara','',array('onchange'=>'cekFile(this);','accept'=>'.mp3,audio/mp3', 'class' => 'upload_file btn-tambah-suara'));
            echo "</div>";                        
        ?>
    </div>
</div>