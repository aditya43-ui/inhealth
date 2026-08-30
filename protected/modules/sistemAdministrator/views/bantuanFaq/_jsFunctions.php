
<script type="text/javascript">
function pencarianFaq() {    
    var pencarian = $('#searchFaq').val();
    $('.loadPencarianFaq').addClass("animation-loading");
    $.ajax({
        type:'GET',
        url:'<?php echo $this->createUrl('loadPencarianFaq'); ?>',
        data: {search:pencarian},
        dataType: "json",
        success:function(data){
            $('.loadPencarianFaq').html(data);
            setMenuDefault();
            $('.loadPencarianFaq').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $('.loadPencarianFaq').removeClass("animation-loading");}
    });
}

function setMenuKlik(obj){
   var idmodul = $(obj).attr('id_modul');
   menuNonAktif();
   $('#menuLi_'+idmodul).addClass('activeMenuFaq');
   $('#menuIcon_'+idmodul).fadeIn();
   $('#content_faq_'+idmodul).fadeIn();
}

function menuNonAktif(){
    $('.menuLi').each(function(){
        var idmodul = $(this).find('a').attr('id_modul');
        $(this).removeClass('activeMenuFaq');
        $(this).find('a').find('i').fadeOut();
        $('#content_faq_'+idmodul).fadeOut();
            
    });
}
function setMenuDefault(){
    if($('.menuLi').eq(0).find('a') != undefined){
        setMenuKlik($('.menuLi').eq(0).find('a'));
    }
}
$(document).ready(function(){
    pencarianFaq();

    $('#searchFaq').on('keyup',function(e){
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            pencarianFaq();
        }
    })
});

</script>