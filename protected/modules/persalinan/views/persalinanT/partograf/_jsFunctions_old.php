<?php
/**
* - digunakan untuk menampung semua script javascript, agar mudah di tracing untuk tabulasi partograf
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
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
                                                        $("#tabel-partograf-detail > tbody > tr.periksaCatatWaktu > td:last").after(data.tbody.catatwaktu);
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
                var getJam = 0;	
                var getJamMax = 0;
		
		$('#tabel-partograf-detail > thead > tr > td').each(function(){
			if (!$(this).hasClass("label-periksa")){
				$(this).find(".noperiksa").html("P"+(i+1));			
				i++;
			}
		});
		
		$("#tabel-partograf-detail > tbody > tr.periksaDjj, tr.periksaAirKetuban, tr.periksaPenyusupan, tr.periksaServiks, tr.periksaKepala, tr.periksaWaktu, tr.periksaKontraksiJumlah, tr.periksaKontraksiDetik, tr.periksaOksilosin, tr.periksaTetes, tr.periksaUrinProtein, tr.periksaUrinAsolon, tr.periksaUrinVolume, tr.periksaSuhu, tr.periksaTekananDarah, tr.periksaNadi, tr.periksaObat, tr.periksaPenyulit, tr.periksaCatatWaktu").each(function(){		
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
				
				
	//	$('.numbers-only').keyup(function() {
	//		setNumbersOnly(this);
	//	});

		
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
				}else{
                                    if (getJam<=9){
                                            getJam = '0'+getJam
                                    }
                                }
											
				$(this).html(getJam+":"+jam[1]+":"+jam[2]);
				
				row++;
			});
		});
                
                
   }
   
   function generatePicker(){    
        var jamMin = [];
        var jamMax = [];
        var menit = [];
        var detik = [];
        var w = 0;        
        
        setTimeout(function(){
            $("#tabel-partograf-detail > tbody > tr.periksaWaktu > td:not(.label-periksa)").each(function(){
                //waktu            
                if ($(this).find(".waktu").val() != ''){                
                    var waktu = $(this).find(".waktu").val();   
                    var jam = waktu.split(':');
                    jamMin[w] = parseInt(jam[0]);
                    jamMax[w] = parseInt(jam[0]);
                    menit[w] = parseInt(jam[1]);
                    detik[w] = parseInt(jam[2]);

                    if (jamMin[w] == 23){
                        jamMax[w] = jamMin[w];
                    }else{
                        jamMax[w] = jamMin[w]+1;
                    }

                    if (menit[w] == 0){
                        menit[w] = menit[w];
                    }else{
                        menit[w] = menit[w];
                    }

                    if (detik[w] == 0){
                        detik[w] = detik[w];
                    }else{
                        detik[w] = detik[w];
                    }

                    w++;
                }                                           
            });
            
            var i = 0;
            $('#tabel-partograf-detail > tbody > tr.periksaCatatWaktu > td:not(.label-periksa)').each(function(){                
                $($(this).find('.waktucatat')).timepicker('destroy');
                $($(this).find('.waktucatat')).timepicker(
                    jQuery.extend(
                           {
                                showMonthAfterYear:false,
                                hourMin: parseInt(jamMin[i]),
                                minuteMin: 0,
                                secondMin: 0,
                                hourMax: parseInt(jamMax[i]),
                                minuteMax: parseInt(menit[i]),
                                secondMax: parseInt(detik[i]),                                
                                onSelect : function(){
                                    generateGrafik();
                                },
                           }, 
                           
                           jQuery.timepicker.regional['id'],
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
        
                i++;
            });
        },500);
        
                           
    }
      
   $(document).ready(function(){
		<?php if ($modPartograf->ada_detail == true){ ?>
			renameDetailPartograf();
                        generatePicker();
		<?php } ?>	
			
		$(".decimalfloat").keyup(function(){
			
		})
		
   });
		
</script>