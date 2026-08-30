<table class="table-condensed">
    <tr>
        <td width="50%">
            <div class="box">
                <?php foreach($modJenisTindakan as $i=>$jenisTindakan){ 
                        $ceklist = false;
                ?>
                        <div class="boxtindakan">
                            <h6><?php echo $jenisTindakan->jenistindakanrm_nama; ?></h6>
                            <?php foreach ($modTindakan as $j => $tindakanRM) {
                                      if($jenisTindakan->jenistindakanrm_id == $tindakanRM->jenistindakanrm_id) {
                                         echo CHtml::checkBox("tindakanrm_id[]", $ceklist, array('value'=>$tindakanRM->tindakanrm_id,
                                                                                                  'onclick' => "inputTindakan(this)"));
                                         echo "<span>".$tindakanRM->tindakanrm_nama."</span><br/>";
                                     }
                                 } ?>
                        </div>
                <?php } ?>
            </div>
        </td>
        <td width="50%">
            <table id="tblFormTindakanRM" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>
                            <a class="btn btn-primary" onclick="checkRahasia('kingCheck','ceklis');return false;" href="#" data-original-title="Klik untuk cek semua operasi" rel="tooltip">
                                <i class="icon-check icon-white"></i>
                        </a>
                        <?php echo CHtml::checkBox('kingCheck', true, array('onclick'=>'checkAll("ceklis",this);',
                                            'data-original-title'=>'Klik untuk cek semua operasi' ,'rel'=>'tooltip','style'=>'display:none;')) ?>
                        </th>
                        <th>Jenis Tindakan/<br/>Tindakan</th>
                        <th>Tarif</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Cyto</th>
                        <th>Tarif Cyto</th>
                    </tr>
                </thead>
            </table>
        </td>
    </tr>
</table>
 
</fieldset>
<script>
function inputTindakan(obj)
{
    if($(obj).is(':checked')) {
        var idPemeriksaanRM = obj.value;
        var kelasPelayan_id = <?php echo $model->kelaspelayanan_id ?>;
        
        if(kelasPelayan_id==''){
                $(obj).attr('checked', 'false');
                myAlert('Anda Belum Memilih Kelas Pelayanan');
                
            }
        else{
        jQuery.ajax({'url':'<?php echo $this->createUrl('loadFormPemeriksaanRMPendRM')?>',
                 'data':{idPemeriksaanRM:idPemeriksaanRM,kelasPelayan_id:kelasPelayan_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         $('#tblFormTindakanRM').append(data.form);
                 } ,
                 'cache':false});
        }     
    } else {
            
        myConfirm("Apakah anda akan membatalkan pemeriksaan ini?","Perhatian!",
        function(r){
            if(r){
                batalPeriksa(obj.value);
            }else{
                $(obj).attr('checked', 'checked');
            }
        }); 
    }
}

function batalPeriksa(idTindakan)
{
    $('#tblFormTindakanRM #tindakan_'+idTindakan).detach();
}


function hitungCyto(id,obj)
{
    if(obj == 1)
    {
        var persen_cytotind = $('#RMTindakanpelayananT_persencyto_tind_'+id+'').val(); 
        var harga_tarif = $('#RMTindakanpelayananT_tarif_tindakan_'+id+'').val(); 
        var tarif_cyto = harga_tarif * (persen_cytotind/100);

        $('#RMTindakanpelayananT_tarif_cyto_'+id+'').val(tarif_cyto);
    }
    else
    {
        $('#RMTindakanpelayananT_tarif_cyto_'+id+'').val(0);
    }
    
}


function checkRahasia(patokan,kelas)
{
    if($('#'+patokan+'').is(':checked')) {
        $('#'+patokan+'').removeAttr('checked');
        $('.'+kelas+'').each(function() {
            $(this).removeAttr('checked');
        });
    }
    else
    {
         $('#'+patokan+'').attr('checked', 'checked');
        $('.'+kelas+'').each(function() {
            $(this).attr('checked', 'checked');
        });
    }
}
function checkAll(kelas,obj)
{
    if(obj.checked) {
        $('.'+kelas+'').each(function() {
            $(this).attr('checked', 'checked');
        });
    }
    else
    {
        obj.checked = false;
        $('.'+kelas+'').each(function() {
            $(this).removeAttr('checked');
        });
    }
}
</script>