<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>                  
            <th>No.</th>
            <th class="hide">No. Register Pendonor</th>
            <th class="hide">No. Identitas Pendonor</th>
            <th>No.Barcode Utama/No Barcode Sampel</th>
            <th>Golongan Darah /Rhesus</th>
            <th>Batal</th>
        
        </tr>
    </thead>
    <tbody>
        <?php
            $i=1;
            foreach($modDetail as $det ){
                
        ?>
        <tr>
            <td><?php echo $i?></td>
            <td class="hide"><?php echo $det->no_pendonor ?></td>
            <td class="hide"><?php echo $det->no_identitas ?></td>
            <td><?php echo $det->nomorbarcode_utama; ?></td>
            <td><?php echo $det->gol_darah." / ".$det->rhesus ?></td>
            <td><?php echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('batal').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;','class'=>'hapus','onclick'=>"deleteRecord(this,'".$det->nomorbarcode_sample."')", "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus data",'data-placement'=>'left')); ?></td>

        </tr>
        
        
        <?php
        $i++;
            }
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
        ?>
    </tbody>
</table>

<script>
 function deleteRecord(obj,id){
        var id = id;
        var url = '<?php echo $url."/batalCoolbox"; ?>';
        myConfirm('Apakah Anda yakin ingin menghapus data ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'berhasil'){

                                $(obj).parent().parent().hide();
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
</script>