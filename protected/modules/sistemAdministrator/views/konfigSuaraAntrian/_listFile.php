<div class="col-sm-3">
    <div class="control-group">
        <div class="controls">
            <?php
                $adalaki = isset($val[Params::JENIS_KELAMIN_LAKI_LAKI])?$val[Params::JENIS_KELAMIN_LAKI_LAKI]:null;    

                echo CHtml::link("<i class='entypo-folder'></i>  ".strtoupper($key),'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary','style'=>'width:200px;','rel'=>'tooltip','data-original-title'=>'Klik untuk upload suara',)).'&nbsp;';    
                if (!empty($adalaki)){
                    echo CHtml::link("<i class='entypo-play'></i>",'javascript:;',array('panggil'=>$key,'jeniskelamin'=>Params::JENIS_KELAMIN_LAKI_LAKI,'onclick'=>'panggilSuara(this);','rel'=>'tooltip','data-original-title'=>'Klik untuk mengecek suara', 'class'=>'btn btn-danger'));
                }else{
                    //echo CHtml::link("<i class='entypo-cancel'></i>",'javascript:;',array('onclick'=>'toastr.error("File suara tidak ditemukan","Perhatian!")','rel'=>'tooltip','data-original-title'=>'Klik untuk mengecek suara', 'class'=>'btn btn-danger'));
                }                
                echo '<br/>'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse','rel'=>'tooltip','data-original-title'=>'Klik untuk mencari file suara','style'=>'color:red;'));
                echo '&nbsp;'.CHtml::link("<i class='entypo-upload'></i>",'javascript:;',array('panggil'=>$key,'jeniskelamin'=>Params::JENIS_KELAMIN_LAKI_LAKI,'onclick'=>'simpanSuara(this);','class'=>'buttonupload btn btn-info hide','rel'=>'tooltip','data-original-title'=>'Klik untuk upload suara','style'=>'margin:5px;'));
                echo "<div class='hide'>";
                echo CHtml::fileField('suara','',array( 'onchange'=>'cekFile(this);','accept'=>$tipe, 'class' => 'upload_file'));
                echo "</div>";                        

            ?>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php
                $adaperempuan = isset($val[Params::JENIS_KELAMIN_PEREMPUAN])?$val[Params::JENIS_KELAMIN_PEREMPUAN]:null;
                
                echo CHtml::link("<i class='entypo-folder'></i>  ".strtoupper($key),'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-success' ,'style'=>'width:200px;','rel'=>'tooltip','data-original-title'=>'Klik untuk upload suara',)).'&nbsp;';    
                if (!empty($adaperempuan)){
                    echo CHtml::link("<i class='entypo-play'></i>",'javascript:;',array('panggil'=>$key,'jeniskelamin'=>Params::JENIS_KELAMIN_PEREMPUAN,'onclick'=>'panggilSuara(this);','rel'=>'tooltip','data-original-title'=>'Klik untuk mengecek suara', 'class'=>'btn btn-danger'));
                }else{
                    //echo CHtml::link("<i class='entypo-cancel'></i>",'javascript:;',array('onclick'=>'toastr.error("File suara tidak ditemukan","Perhatian!")','rel'=>'tooltip','data-original-title'=>'Klik untuk mengecek suara', 'class'=>'btn btn-danger'));
                }
                echo '<br/>'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse','rel'=>'tooltip','data-original-title'=>'Klik untuk mencari file suara','style'=>'color:red;'));
                echo '&nbsp;'.CHtml::link("<i class='entypo-upload'></i>",'javascript:;',array('panggil'=>$key,'jeniskelamin'=>Params::JENIS_KELAMIN_PEREMPUAN,'onclick'=>'simpanSuara(this);','class'=>'buttonupload btn btn-info hide','rel'=>'tooltip','data-original-title'=>'Klik untuk upload suara','style'=>'margin:5px;'));
                echo "<div class='hide'>";
                echo CHtml::fileField('suara','',array( 'onchange'=>'cekFile(this);','accept'=>$tipe, 'class' => 'upload_file'));
                echo "</div>";                        
                
            ?>
        </div>
    </div>
</div>

<?php 
    if ($i % 4 == 0 ){
        echo "<div class='clear'></div>";
    }
?>