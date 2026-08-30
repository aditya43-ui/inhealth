<?php
/**
 * untuk menampung fungsi - fungsi javascript pada menu tabulasi parograf partograf
 * issue RSST-1589, RSST-2474
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<script>
   function addPartografDetail(){
	   var tr = $("#tabel-partograf-detail > thead > tr").length;
	   var td = $("#tabel-partograf-detail > thead > tr > td").length;
	   	   
	   $.ajax({
			type:'POST',
			url: '<?php echo $this->createUrl('addPartografDetail') ?>',					
			dataType: "json",
			data: {tr:tr, td:td},
			success: function(data){
					if (data.sukses == 1){	                               
						if (data.tr == 0){
							$("#tabel-partograf-detail > thead ").html(data.thead);
						}else{
							$("#tabel-partograf-detail > thead > tr > td:last").after(data.thead);							
							$("#tabel-partograf-detail > tbody > tr.periksaDjj > td:last").after(data.tbody.djj);
							$("#tabel-partograf-detail > tbody > tr.periksaAirKetuban > td:last").after(data.tbody.airketuban);
							$("#tabel-partograf-detail > tbody > tr.periksaPenyusupan > td:last").after(data.tbody.penyusupan);
							$("#tabel-partograf-detail > tbody > tr.periksaServiks > td:last").after(data.tbody.serviks);
							$("#tabel-partograf-detail > tbody > tr.periksaKepala > td:last").after(data.tbody.kepala);
							$("#tabel-partograf-detail > tbody > tr.periksaWaktu > td:last").after(data.tbody.waktu);
							$("#tabel-partograf-detail > tbody > tr.tampilWaktu > td:last").after(data.tbody.waktulabel);
							$("#tabel-partograf-detail > tbody > tr.periksaKontraksiJumlah > td:last").after(data.tbody.kontraksijumlah);
							$("#tabel-partograf-detail > tbody > tr.periksaKontraksiDetik > td:last").after(data.tbody.kontraksidetik);
							$("#tabel-partograf-detail > tbody > tr.periksaOksilosin > td:last").after(data.tbody.oksilosin);
							$("#tabel-partograf-detail > tbody > tr.periksaTetes > td:last").after(data.tbody.tetes);
							$("#tabel-partograf-detail > tbody > tr.periksaObat > td:last").after(data.tbody.obat);
							$("#tabel-partograf-detail > tbody > tr.periksaTekananDarah > td:last").after(data.tbody.tekanandarah);
							$("#tabel-partograf-detail > tbody > tr.periksaNadi > td:last").after(data.tbody.nadi);
							$("#tabel-partograf-detail > tbody > tr.periksaPenyulit > td:last").after(data.tbody.penyulit);
							$("#tabel-partograf-detail > tbody > tr.periksaSuhu > td:last").after(data.tbody.suhu);
							$("#tabel-partograf-detail > tbody > tr.periksaUrinProtein > td:last").after(data.tbody.urinprotein);
							$("#tabel-partograf-detail > tbody > tr.periksaUrinAsolon > td:last").after(data.tbody.urinasolon);
							$("#tabel-partograf-detail > tbody > tr.periksaUrinVolume > td:last").after(data.tbody.urinvolume);
							
							$(".colstabel").attr("colspan",td+1);
						}
						
						renameDetailPartograf();
					}else{
						alert(data.pesan);
					}
			},
			error: function (jqXHR, textStatus, errorThrown) { 					
					console.log(errorThrown);
			}
	});
   }
   
   function renameDetailPartograf(){
		var row = 0;
		var i = 0;
		var td = $('#tabel-partograf-detail > thead > tr > td').length;	
		var a = 1;
		var tgl = $("#PSPemeriksaanpartografT_tglperiksa").val();
		var tglsplit = tgl.split(" ");
		var jam = tglsplit[1].split(":");
		var bagi = 0;
		var td = 0;
		var row4 = 0;
				
		
		$('#tabel-partograf-detail > thead > tr > td').each(function(){
			if (!$(this).hasClass("label-periksa")){
				$(this).find(".noperiksa").html("P"+(i+1));			
				i++;
			}
		});
		
		$("#tabel-partograf-detail > tbody > tr.periksaDjj, tr.periksaAirKetuban, tr.periksaPenyusupan, tr.periksaServiks, tr.periksaKepala, tr.periksaWaktu, tr.periksaKontraksiJumlah, tr.periksaKontraksiDetik, tr.periksaOksilosin, tr.periksaTetes, tr.periksaUrinProtein, tr.periksaUrinAsolon, tr.periksaUrinVolume, tr.periksaSuhu, tr.periksaTekananDarah, tr.periksaNadi, tr.periksaObat, tr.periksaPenyulit").each(function(){		
			row = 0;			
			row4 = 0;
			$(this).find('input,select,textarea').each(function(){ //element <input>
				var old_name = $(this).attr("name").replace(/]/g,"");
				var old_name_arr = old_name.split("[");
				var valueid = $(this).attr("valueid");																
				
				//if(old_name_arr.length == 4){
				//	$(this).attr("id",old_name_arr[0]+"_"+row+"_"+valueid+"_"+old_name_arr[3]);
				//	$(this).attr("name",old_name_arr[0]+"["+row+"]["+valueid+"]["+old_name_arr[3]+"]");
				//}
				if(old_name_arr.length == 3){
					if ($(this).hasClass('manyinput')){
						a = Math.floor(row/valueid);												
						
						$(this).attr("id",old_name_arr[0]+"_"+a+"_"+old_name_arr[2]);
						$(this).attr("name",old_name_arr[0]+"["+a+"]["+old_name_arr[2]+"]");
					}else{
						$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
						$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
					}
				}	
				
				if(old_name_arr.length == 4){
					$(this).attr("id",old_name_arr[0]+"_"+row4+"_"+old_name_arr[2]+"_"+old_name_arr[3]);
					$(this).attr("name",old_name_arr[0]+"["+row4+"]["+old_name_arr[2]+"]["+old_name_arr[3]+"]");
					
					row4++;
				}	
				
				if (old_name_arr[2] == 'p3_waktu'){
					bagi = Math.floor(row/2);
										
					var getJam = parseInt(jam[0])+bagi;
										
					if (getJam >= 24){
						getJam = getJam-24;

						if (getJam<=9){
							getJam = '0'+getJam;
						}
					}
					
					$(this).val(getJam+":"+jam[1]+":"+jam[2]);
				}
								
				row++;								
			});													
		});		
		
		getWaktuLabel();
						
		$('#tabel-partograf-detail').find("tbody > tr").each(function(){									
			jQuery('[data-toggle="tooltip"]').each(function(i, el)
			{
				var $this = jQuery(el),
					placement = attrDefault($this, 'placement', 'top'),
					trigger = attrDefault($this, 'trigger', 'hover'),
					popover_class=$this.hasClass('tooltip-secondary') ? 'tooltip-secondary' : ($this.hasClass('tooltip-primary') ? 'tooltip-primary' : ($this.hasClass('tooltip-default') ? 'tooltip-default' : ''));

				$this.tooltip({
					placement: placement,
					trigger: trigger
				});

				$this.on('shown.bs.tooltip', function(ev)
				{
					var $tooltip = $this.next();

					$tooltip.addClass(popover_class);
				});
			});		
			
			
		});	
					
   }
   
   function getWaktuLabel(){
		var row = 0;
		var tgl = $("#PSPemeriksaanpartografT_tglperiksa").val();
		var tglsplit = tgl.split(" ");
		var jam = tglsplit[1].split(":");	
		var getJam = 0;
   
		$("#tabel-partograf-detail > tbody > tr.tampilWaktu").each(function(){	
			row = 0;
			$(this).find('.waktulabel').each(function(){
																	
				getJam = parseInt(jam[0])+parseInt(row);
												
				if (getJam >= 24){
					getJam = getJam-24;
					
					if (getJam<=9){
						getJam = '0'+getJam
					}
				}
											
				$(this).html(getJam+":"+jam[1]+":"+jam[2]);
				
				row++;
			});
		});
   }
   
   function tambahPartografLain(jenis,no){              
       
       if (jenis != 'dialog'){
           var lainlain = $("#form-partograflainlain").find('input,select,textarea').serialize();
           var form = $("#form-partograflainlain");
       }else{
           var lainlain = $("#form-dialog-ubah").find('input,select,textarea').serialize();
           var form = $("#form-dialog-ubah");
       }
       
        if (requiredCheck(form)){  
            $.ajax({
                 type:'POST',
                 url: '<?php echo $this->createUrl('tambahPartografLain') ?>',					
                 dataType: "json",
                 data: {lainlain:lainlain},
                 success: function(data){
                     if (data.sukses == 1){	  
                         if (jenis == 'dialog'){                                               
                            $("#partograf-lainlain > tbody > tr").each(function(){
                                 if ($(this).find('.nourut-data').val() == no){                            
                                     $(this).replaceWith(data.tr);
                                 }
                                 $("#dialogUbah").dialog('close');
                             });
                         }else{
                             $("#partograf-lainlain > tbody ").append(data.tr);
                             resetFormLain();
                         }
                            renameInput($("#partograf-lainlain"));
                     }else{
                             toastr.error(data.pesan);
                     }
                 },
                 error: function (jqXHR, textStatus, errorThrown) { 					
                                 console.log(errorThrown);
                 }
             });
        }
   }   
   
   function tambahPartografKontrol(jenis,no){   
    
        if (jenis != 'dialog'){
            var lainlain = $("#form-partografkontrol").find('input,select,textarea').serialize();
            var form = $("#form-partografkontrol");
         }else{
            var lainlain = $("#form-dialog-ubah").find('input,select,textarea').serialize();
            var form = $("#form-dialog-ubah");
         }
    
        if (requiredCheck(form)){                                        
           $.ajax({
                type:'POST',
                url: '<?php echo $this->createUrl('tambahPartografKontrol') ?>',
                dataType: "json",
                data: {kontrol:lainlain},
                success: function(data){
                    if (data.sukses == 1){	                          
                        if (jenis == 'dialog'){                                               
                           $("#partograf-kontrol > tbody > tr").each(function(){
                                if ($(this).find('.nourut-data').val() == no){                            
                                    $(this).replaceWith(data.tr);
                                }
                                $("#dialogUbah").dialog('close');
                            });
                        }else{
                            $("#partograf-kontrol > tbody ").append(data.tr);
                            resetFormKontrol();
                        }                    
                        $(".tab_iv").empty();
                        renameInput($("#partograf-kontrol")); 
                        loadTotalPeriksa($("#form-partografkontrol"));
                        generateGrafik();
                    }else{
                            toastr.error(data.pesan);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) { 					
                                console.log(errorThrown);
                }
            });
        }
        
        return false;
   }   
   
   function ubahData(obj,jenis){
    
        if (jenis == 'lainlain'){
            var submit = $("#form-partograflainlain").find('input,select,textarea').serialize();
        }else  if (jenis == 'lainlain'){
            var submit = $("#form-partografkontrol").find('input,select,textarea').serialize();
        }
              
        $.ajax({
            type:'POST',
            url: '<?php echo $this->createUrl('generateForm') ?>',
            dataType: "json",
            data: {lainlain:submit,jenis:jenis},
            success: function(data){
                if (data.sukses == 1){
                    if (jenis == 'lainlain'){
                       $("#partograf-lainlain > tbody ").html(data.tr);
                       renameInput($("#partograf-lainlain"));
                    }else{
                        $("#partograf-kontrol > tbody ").html(data.tr);
                        renameInput($("#partograf-kontrol"));
                    }
                }else{
                        toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { 					
                            console.log(errorThrown);
            }
	});
   }        
   
   function resetFormKontrol(){
        $("#form-partografkontrol").find('input, select, textarea').each(function(){
           $(this).val(''); 
        });
   }
   
   function resetFormLain(){
       $("#form-partograflainlain").find('input, select, textarea').each(function(){
           $(this).val(''); 
        });
   }
   
   function hapusBaris(obj,form){
        window.parent.myConfirm("Apakah Anda yakin akan menghapus data ini?","Perhatian !",function(r){
            if (r){
                
                var id = $(obj).parents("tr").find('.id').val();
                
                if (form == 'lainlain'){
                    var del = '<tr><td><input type="hidden" value="'+id+'" name="delete[lainlain][]"></td></tr>';
                    $("#tabel-lainlain-hapus > tbody").append(del);                                        
                    
                    $(obj).parents("tr").detach();
                    
                    renameInput($("#partograf-lainlain"));
                }else if(form == 'kontrol'){
                    var del = '<tr><td><input type="hidden" value="'+id+'" name="delete[kontrol][]"></td></tr>';
                    $("#tabel-kontrol-hapus > tbody").append(del);                         
                    
                    loadTotalPeriksa($("#form-partografkontrol"));                    
                    
                    $(obj).parents("tr").detach();
                    
                    renameInput($("#partograf-kontrol")); 
                }                                                                                
            }
        });
   }
   
   function renameInput(obj_table){
        var row = 0;
        var tgl = $("#PSPemeriksaanpartografT_tglperiksa").val();
        var tglsplit = tgl.split(" ");
        var jam = tglsplit[1].split(":");
        var bagi = 0;
                
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find(".nourut-data").val(row);                        
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
                
                var getJam = 0;
                var getJamMax = 0;
                
                if (old_name_arr[2] == 'p3_waktu'){
                    var periksa_ke = parseInt($(this).parents("tr").find('.periksa_ke').val());    
                    
                    if (!isNaN(periksa_ke)) {
                    
                        bagi = Math.floor((periksa_ke-1)/2);                   

                        getJam = parseInt(jam[0])+bagi;	
                        getJamMax = 0;
                        if (getJam >= 24){                                            
                                getJam = getJam-24;
                                if (getJam<=9){
                                    getJam = '0'+getJam;                                                        
                                    if (getJam <= 8){
                                        getJamMax = '0'+(getJam+1);
                                    }else{
                                        getJamMax = getJam+1;
                                    }
                                }else{
                                    if (getJam == 23){
                                        getJamMax = getJam;
                                    }else{
                                        getJamMax = getJam+1;
                                    }
                                }                                                
                        }else{
                            if (getJam<=9){
                                getJam = '0'+getJam;                                                        
                                if (getJam <= 8){
                                    getJamMax = '0'+(getJam+1);
                                }else{
                                    getJamMax = getJam+1;
                                }
                            }else{
                                if (getJam == 23){
                                    getJamMax = getJam;
                                }else{
                                    getJamMax = getJam+1;
                                }
                            }                                                
                        }                                        
                        $(this).val(getJam+":"+jam[1]+":"+jam[2]);      
                    }
                }   
            });            
            row++;
        });        
    }
    
    function setDokterPartoLain(nama,id,generate){
        if (generate == 'generate'){
            $("#<?php echo CHtml::activeId($modPartoLain, 'dokter_id') ?>").val(id);
            $("#<?php echo CHtml::activeId($modPartoLain, 'dokter_nama') ?>").val(nama);

            $("#<?php echo CHtml::activeId($modPartoLain, 'dokter_nama') ?>").blur();
        }else{
            $("#<?php echo CHtml::activeId($modPartoLain, 'dokter_id') ?>").val(id);
            $("#<?php echo CHtml::activeId($modPartoLain, 'dokter_nama') ?>").val(nama);

            $("#<?php echo CHtml::activeId($modPartoLain, 'dokter_nama') ?>").blur();
        }
    }
    
    function setBidanPartoLain(nama,id,generate){
        if (generate == 'generate'){
            $("#<?php echo CHtml::activeId($modPartoLain, 'bidan_id') ?>").val(id);
            $("#<?php echo CHtml::activeId($modPartoLain, 'bidan_nama') ?>").val(nama);
        
            $("#<?php echo CHtml::activeId($modPartoLain, 'bidan_nama') ?>").blur();
        }else{
            $("#<?php echo CHtml::activeId($modPartoLain, 'bidan_id') ?>").val(id);
            $("#<?php echo CHtml::activeId($modPartoLain, 'bidan_nama') ?>").val(nama);
        
            $("#<?php echo CHtml::activeId($modPartoLain, 'bidan_nama') ?>").blur();
        }
    }
    
    function setPerawatPartoLain(nama,id,generate){                
        if (generate == 'generate'){
             $("#<?php echo CHtml::activeId($modPartoLain, 'perawat_id') ?>").val(id);
            $("#<?php echo CHtml::activeId($modPartoLain, 'perawat_nama') ?>").val(nama);                

            $("#<?php echo CHtml::activeId($modPartoLain, 'perawat_nama') ?>").blur();
        }else{
            $("#<?php echo CHtml::activeId($modPartoLain, 'perawat_id') ?>").val(id);
            $("#<?php echo CHtml::activeId($modPartoLain, 'perawat_nama') ?>").val(nama);                

            $("#<?php echo CHtml::activeId($modPartoLain, 'perawat_nama') ?>").blur();
        }
    }
                    
    function generateForm(obj,jenis,no){
        var id = $(obj).parents("tr").find('.id').val();
        var no = parseInt($(obj).parents("tr").find('.nourut-data').val());
        
        $(".noUrut").val(no);                   
               
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('GenerateForm'); ?>',
            data: {                
                id:id,
                jenis:jenis,
                no:no,
                formdata:$(obj).parents("tr").find('input,select,textarea').serialize()
             },
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){
                    $("#dialogUbah").dialog("open");
                    $("#form-dialog-ubah").html(data.html);       
                    $('#form-partografkontrol .angkacoma-only').keyup(function (e) {
                        setAngkaComaOnly(this);
                    });
                    $('#form-partografkontrol .numbers-only').keyup(function (e) {
                        setNumbersOnly(this);
                    });
                    
                    setTimeout(generatePicker(jenis),500);
                }else{
                    window.parent.myAlert(data.pesan);
                }
            },
            //error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });	
    }
    
    function hitungCGS()
    {
        var gcs_eye =  $('#<?php echo CHtml::activeId($modDet, 'gsc_eye') ?>').val();
        var gcs_motorik =  $('#<?php echo CHtml::activeId($modDet, 'gsc_motorik') ?>').val();
        var gcs_verbal =  $('#<?php echo CHtml::activeId($modDet, 'gsc_verbal') ?>').val();
        if((gcs_eye!='') && (gcs_motorik!='') &&(gcs_verbal!='')){
           $.post("<?php echo Yii::app()->createUrl(""); ?>",{gcs_eye: gcs_eye,gcs_motorik:gcs_motorik,gcs_verbal:gcs_verbal},
           function(data){
                  if(data.pesan==null){
                    $('#<?php echo CHtml::activeId($modDet, 'gcs_totalskor') ?>').val(data);
                  }else{
                       window.parent.myAlert(data.pesan);
                  }    
            },"json");
        }
    }
    
    function generatePicker(jenis){
        if (jenis == 'kontrol'){
            $("#form-dialog-ubah").find('.p3_waktu').timepicker(
                jQuery.extend(
                    {
                        showMonthAfterYear:false
                    }, 
                    jQuery.datepicker.regional['id'],
                    {                   
                        'timeText':'Waktu',
                        'hourText':'Jam',
                        'minuteText':'Menit',
                        'secondText':'Detik',
                        'showSecond':true,
                        'timeOnlyTitle':'Pilih Waktu',
                        'timeFormat':'hh:mm:ss',                    
                        'showAnim':'fold',                    
                    }
                )
            );
        }else if(jenis == 'lainlain'){            
            $("#form-dialog-ubah").find('.dokter').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':3,
                    'focus':function(event, ui )
                    {
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui )
                    {
                        setDokterPartoLain(ui.item.label,ui.item.pegawai_id,'generate');
                        return false;
                    },
                    'source':function(request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('/ActionAutoComplete/DropDokterRuangan',array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')));?>",
                            dataType: "json",
                            data:{
                                term: request.term,                                
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    }
                }
            );
            
            $("#form-dialog-ubah").find('.perawat').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':3,
                    'focus':function(event, ui )
                    {
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui )
                    {
                        setPerawatPartoLain(ui.item.label,ui.item.pegawai_id,'generate');
                        return false;
                    },
                    'source':function(request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('/ActionAutoComplete/dropPetugasRuangan');?>",
                            dataType: "json",
                            data:{
                                term: request.term,    
                                ruangan_id: <?php echo Yii::app()->user->getState('ruangan_id'); ?>,
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    }
                }
            );
            
            $("#form-dialog-ubah").find('.bidan').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':3,
                    'focus':function(event, ui )
                    {
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui )
                    {
                        setBidanPartoLain(ui.item.label,ui.item.pegawai_id,'generate');
                        return false;
                    },
                    'source':function(request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('/ActionAutoComplete/dropPetugasRuangan');?>",
                            dataType: "json",
                            data:{
                                term: request.term,    
                                ruangan_id: <?php echo Yii::app()->user->getState('ruangan_id'); ?>,
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    }
                }
            );
        }
           
    }
    
    function cekForm(obj){        
        $("#form-partografkontrol").html('');
        $("#form-partograflainlain").html('');

        $(".submit").attr('disabled',true);

        setTimeout(obj.submit(),100);
    }
    
    function loadTotalPeriksa(obj){
        var count = $("#partograf-kontrol > tbody > tr").length;
        
        if (count > 0){
            for(var i = 1;i<=count;i++){
                if (typeof $("#partograf-kontrol > tbody > tr").find('[class=periksa_ke][value='+i+']').val() === 'undefined'){
                    count = i-1;
                }
            }
        }
        
        $(obj).find('.periksake').val(parseInt(count)+1);
    }
    
    function tambahObat(data) {
        
        var ada = false;
        $(".tab_iv tr").each(function() {
            if ($(this).data('id') == data.obatalkes_id) {
                ada = true;
            }
        });
        
        if (ada) {
            myAlert("Data Obat sudah ditambahkan.");
            return false;
        }
        
        var str = '<tr data-id="' + data.obatalkes_id + '">';
        
        str += '<td>' + data.obatalkes_nama + '</td>';
        str += '<td><input type="text" name="qty[' + data.obatalkes_id + ']" value="1" class="span1 qty_oa_iv" style="text-align:right;"></td>';
        str += '<td><?php echo CHtml::htmlButton('-', array('class' => 'btn btn-default', 'onclick'=>'removeRow(this);')); ?></td>';
        
        str += '<tr>';
        
        $(".tab_iv").append(str);
        
    }
    
    function removeRow(obj) {
        $(obj).parents('tr').remove();
    }
    
      
   $(document).ready(function($){
		<?php if ($modPartograf->ada_detail == true){ ?>
			renameDetailPartograf();
		<?php } ?>	
			generateGrafik();		
                                        
        loadTotalPeriksa($("#form-partografkontrol"));
   });
   
   
		
</script>