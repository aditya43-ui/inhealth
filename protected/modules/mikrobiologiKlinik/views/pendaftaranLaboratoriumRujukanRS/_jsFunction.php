<script type="text/javascript">
    
 /**
 * print status 
 */
function printAntrianFoto(pasienkirimkeunitlain_id,pasienmasukpenunjang_id)
{
    window.open('<?php echo $this->createUrl('PrintAntrianFoto'); ?>&pasienkirimkeunitlain_id='+pasienkirimkeunitlain_id+'&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=480,height=640');
}
    /**
    * load permintaan ke penunjang:
    * - pasienkirimkeunitlain_id
    */ 
    function setPermintaanKePenunjang(){
        $('#form-tindakanpemeriksaan').addClass("animation-loading");
        var penjamin_id = $("#penjamin_id").val();
        var pasienkirimkeunitlain_id = '<?= $modKunjungan->pasienkirimkeunitlain_id; ?>';
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetPermintaanKePenunjang'); ?>',
            data: {penjamin_id:penjamin_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},
            dataType: "json",
            success:function(data){
                $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
                $('#form-tindakanpemeriksaan').removeClass("animation-loading");
                renameInputRow($("#form-tindakanpemeriksaan"));
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    /**
    * rename input row yang terakhir di tambahkan
    * @param {type} obj_table
    */
    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).find('span').each(function(){ //element <span>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 4){
                    $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            row++;
        });

    }

    $( document ).ready(function(){
        <?php if(isset($_GET['pasienkirimkeunitlain_id'])){ ?>
            $("#pendaftaran-rujukanrs-form :input").attr("readonly",true);
            $(".add-on").remove();
        <?php } ?>
        <?php if(isset($_GET['pasienkirimkeunitlain_id']) && !isset($_GET['pasienmasukpenunjang_id'])){ ?>
            setPermintaanKePenunjang();
        <?php } ?>
    })
</script>