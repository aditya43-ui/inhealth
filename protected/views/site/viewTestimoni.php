<div><p><h3><center>.:: Testimonial ::.</p></h3></div>

<div id="ticker" style="height: 550px;overflow: hidden; padding-left:10px;padding-top:0;width:240px;">
<?php
foreach ($modTestimonis as $i=>$testimoni) {
    echo '<div class="alert alert-info">';
    echo '<b>'.$testimoni->namakomentar.' - '.$testimoni->instanasi.'</b><br/>';
    echo ''.$testimoni->deskripsikomentat.'';
    echo '<span class="author-pengumuman">'.$testimoni->emailkomentar.' - '.$testimoni->websitekomentar.'</span><br/>';
    echo '</div>';
}
?>
</div>

<script type="text/javascript">
function tick(){
    $('#ticker div:first').slideUp( function () { $(this).appendTo($('#ticker')).slideDown(); });
}
setInterval(function(){ tick() }, 8000);

function getTestimoni(){
    $.post('<?php //echo $this->createUrl('ajaxViewTestimoni') ?>', {}, function(data){
        $('#ticker').html(data);
    }, 'json');
}
setInterval(function(){ getTestimoni() }, 16000);
//function tick(){
//	$('#ticker li:first').animate({'opacity':0}, 200, function () { $(this).appendTo($('#ticker')).css('opacity', 1); });
//}
//setInterval(function(){ tick () }, 4000); javascript:chat(\''.$user->nama_pemakai.'\');
</script>
