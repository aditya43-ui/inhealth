
<script type="text/javascript">
function pencarian() {    
    var pencarian = $('#searchPetunjuk').val();
    $('.loadPencarianPetunjuk').addClass("animation-loading");
    $.ajax({
        type:'GET',
        url:'<?php echo $this->createUrl('loadPencarian'); ?>',
        data: {search:pencarian},
        dataType: "json",
        success:function(data){
            $('.loadPencarianPetunjuk').html(data);
            setMenuDefault();
            $('.loadPencarianPetunjuk').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $('.loadPencarianPetunjuk').html('Data Pencarian Bantuan Petunjuk Penggunaan Tidak Ditemukan!!'); $('.loadPencarianPetunjuk').removeClass("animation-loading");}
    });
}

function setMenuKlik(obj){
   var idmodul = $(obj).attr('id_modul');
   menuNonAktif();
   $('#menuLi_'+idmodul).addClass('activeMenuBantuan');
   $('#menuIcon_'+idmodul).fadeIn();
   $('#content_bantuan_'+idmodul).fadeIn();
}

function menuNonAktif(){
    $('.menuLi').each(function(){
        var idmodul = $(this).find('a').attr('id_modul');
        $(this).removeClass('activeMenuBantuan');
        $(this).find('a').find('i').fadeOut();
        $('#content_bantuan_'+idmodul).fadeOut();
        petunjukNonAktif(idmodul);
    });
}

function petunjukNonAktif(modul_id){
    $('.menu_'+modul_id).each(function(){
        var idmenu = $(this).attr('id_menu');
        $(this).removeClass('activepetunjuk');
        $('#menu_'+modul_id+'_'+idmenu).removeClass('textbold');
        $('#menucontent_'+modul_id+'_'+idmenu).fadeOut();
            
    });
}

function setPetunjukKlik(obj){
   var idmodul = $(obj).attr('id_modul');
   var idmenu = $(obj).attr('id_menu');
   petunjukNonAktif(idmodul);
   $('#menucontent_'+idmodul+'_'+idmenu).addClass('activepetunjuk');
   $('#menucontent_'+idmodul+'_'+idmenu).fadeIn();
   $('#menu_'+idmodul+'_'+idmenu).addClass('textbold');
   
}

function setMenuDefault(){
    if($('.menuLi').eq(0).find('a') != undefined){
        setMenuKlik($('.menuLi').eq(0).find('a'));
    }
}
$(document).ready(function(){
    pencarian();

    $('#searchPetunjuk').on('keyup',function(e){
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            pencarian();
        }
    })
});

</script>