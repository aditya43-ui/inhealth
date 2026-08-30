<script>
    function showRiwayatObat2(nama_obat,dosis_obat,carapemberian,tglpemberian) {
       var readonly = 0;
       <?php if(isset($_GET['mode'])) { ?>
               var readonly = 1;
       <?php } ?>
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormRiwayatObat'); ?>',
            data: {nama_obat:nama_obat,dosis_obat:dosis_obat,carapemberian:carapemberian,tglpemberian:tglpemberian, readonly:readonly},
            dataType: "json",
            success:function(data){
			   if(data.pesan !== ""){
				   window.parent.myAlert(data.pesan);
				   return false;
			   }
                            $('#tbl-RiwayatObat > tbody').append(data.form);
                            renameInputRowRiwayatObat($("#tbl-RiwayatObat"));
                            
		},
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
   
      
    
  }
  
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Pengobatan Sebelumnya</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">  
            <div class="col-sm-12">
            <table id="tbl-RiwayatObat" class="form-utama table table-striped table-condensed" del="obatsebelum">
                   <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Dosis</th>
                        <th>Cara Pemberian</th>
                        <th>Waktu/Tanggal Pemberian</th>
                        <th>Aksi <a href="javascript:void(0)" onclick="AddRowObat()"><i class="fa fa-plus-circle"></i></a></th>
                    </tr>
                    </thead>
                    <tbody class="form-body">
                       <?php

                            if(!empty($modAsesmenAwalMedis->asesmen_awal_medis_id)){                                
                                if (!empty($modAsesmenAwalMedis->set_riwayat_obat_sebelum)){
                                    foreach($modAsesmenAwalMedis->set_riwayat_obat_sebelum as $i => $row){  
                                        $modDet = new RIRiwayatobatsebelumnyaT;
                                        $modDet->attributes = $row->attributes;
                                        $modDet->riwayatobatsebelumnya_id = $row->riwayatobatsebelumnya_id;
                                        $modDet->tglpemberian = !empty($row->tglpemberian)? MyFormatter::formatDateTimeForUser($row->tglpemberian):null;

                                         echo $this->renderPartial($this->path_view.'_formAddRiwayatObatHemodialisa',['model'=>$modDet,'i'=>$i], true);
                                    }
                                }
                            }else{                                                               
                                if (!empty($modAsesmenAwalMedis->set_obat_alkes_pasien)){                                    
                                    foreach($modAsesmenAwalMedis->set_obat_alkes_pasien as $i => $row){                                    
                                        $modDet = new RIRiwayatobatsebelumnyaT;
                                        $modDet->nama_obat  = $row->obatalkes_nama;
                                        $modDet->dosis_obat  = $row->satuankekuatan_oa;
                                        $modDet->carapemberian  = $row->carapakai;
                                        $modDet->tglpemberian  = MyFormatter::formatDateTimeForUser($row->tglpelayanan);                                         

                                         echo $this->renderPartial($this->path_view.'_formAddRiwayatObatHemodialisa',['model'=>$modDet,'i'=>$i], true);
                                    }
                                }
                            }
                        ?>
                    </tbody>
            </table> 
            </div>
        </div>
    </div>
</div>


