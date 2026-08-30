<style type="text/css">
	.imgruangan{
		width: 295px;
		height: 150px;
	}
        body{
            
        }
</style>
<style>
    .paket{
        
    }    
</style>
<div class="block-kioskmodule" id="kamarperawatan" name="kamarperawatan">
	<legend class="rim">KAMAR PERAWATAN</legend>
	<div class="contentKamar" style="max-height:400px;overflow-y: scroll;">
		<ul id="main-menu" class="" style="margin:0 !important;">
            <li id="search" class="root-level">
               
                    <form method="POST" action="" id="cari_menu_dynamic">
                            <div class="form-group has-aqua ">
                                <label >Search</label>
                                <input id="cari_menu" name="q" class="form-control" placeholder="Ketikan Nama Menu" type="text" onchange="carimenu();"> 
                            </div>  
                           
                    </form>
                 </div>   
            </li>
        </ul>

	</div>
        <div id="generateMenu">
                <?php $this->renderPartial('menu_dash_user',array()) ?>
    </div>
</div>	
<script>
function carimenu(){
    var term = $("#cari_menu").val();
    
    $('#generateMenu').addClass("animation-loading");
        
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Genimage'); ?>',
        data: {term:term},
        dataType: "json",
        success:function(data){
            $('#generateMenu').html(data.html);
            $('#generateMenu').removeClass("animation-loading");
            setup_sidebar_menu();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}


$(document).ready(function()
{   
    $("#cari_menu_dynamic").submit(function(event){
        event.preventDefault();
        $("#cari_menu").focus();
        return false;
    });
    
    

});
</script>

