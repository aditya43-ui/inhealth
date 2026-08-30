         
<table id="tblFormRencanaOperasi" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Jenis Operasi</th>
            <th>Operasi</th>
            <!--<th>Tarif</th>-->
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<!--<table class="table table-bordered table-condensed">
	<tr><td width="70%" style="text-align: right;">Total Biaya Pemeriksaan</td><td><?php // echo CHtml::textField('totalTarif', '',array('class'=>'span2', 'style'=>'text-align:right;', 'disabled'=>'disabled'));?></td></tr>
</table>-->

<script>
function inputOperasi(obj)
{
    if($(obj).is(':checked')) {
        var operasi_id = obj.value;
        var kelaspelayanan_id = <?php echo $modPendaftaran->kelaspelayanan_id; ?>;
        var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id; ?>;
        
        if(kelaspelayanan_id==''){
                $(obj).attr('checked', 'false');
                window.parent.myAlert('Anda Belum Memilih Kelas Pelayanan');
                
            }
        else{
        jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('perawatanIntensif/bedahSentralTPI/loadFormPermintaanOperasi')?>',
                 'data':{operasi_id:operasi_id,kelaspelayanan_id:kelaspelayanan_id,pendaftaran_id:pendaftaran_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         $('#tblFormRencanaOperasi > tbody').append(data.form);
                         $("#tblFormRencanaOperasi > tbody > tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
                         $('.integer').each(function(){this.value = formatNumber(this.value)});
						 hitungTotal();
                 } ,
                 'cache':false});
        }     
    } else {
        window.parent.myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
            if(r){
                batalPeriksa(obj.value);
				hitungTotal();
            }else{
                $(obj).attr('checked', 'checked');
            }
        });
    }
}

function batalPeriksa(operasi_id)
{
    $('#tblFormRencanaOperasi #operasi_'+operasi_id).detach();
}

function getOperasi(item)
{
    $('#operasi').val(item[0]);    
    $('#BSRencanaOperasiT_operasi_id').val(item[1]);    
}

function hitungCyto(id,obj)
{
    if(obj == 1)
    {
        var persen_cytotind = $('#BSTindakanPelayananT_persencyto_tind_'+id+'').val(); 
        var harga_tarif = $('#BSTindakanPelayananT_tarif_tindakan_'+id+'').val(); 
        var tarif_cyto = harga_tarif * (persen_cytotind/100);

        $('#BSTindakanPelayananT_tarif_cyto_'+id+'').val(tarif_cyto);
    }
    else
    {
        $('#BSTindakanPelayananT_tarif_cyto_'+id+'').val(0);
    }
    
}
</script>
