<style type="text/css">
.pengumuman{
    margin-top: 15px;
    margin-bottom: 10px;
    background: #aaa;
    -webkit-border-radius: 5px;
        border-radius: 5px;
    border:1px solid #D8D9D6;
    background:#E7E9E6;
}
</style>
<!-- <div><p><h3><center>.:: <a href="javascript:void(0)" onclick="viewPengumuman();"> Kotak Informasi</a> ::.</p></h3></div> -->
<div class='pengumuman' style='padding:10px;'>
<div id="ticker">
<?php
foreach ($this->pengumumans as $i=>$pengumuman) {
    //echo Yii::app()->createUrl('sistemAdministrator/pengumuman/admin',array('id'=>$pengumuman->pengumuman_id));
    echo '<div class="">';
    echo '<b>'.$pengumuman->judul.'</b><br/>';
    echo '<p style="font-family:Georgia,Times New Roman,Times,serif; color:#808080"><i>'.$pengumuman->isi.'</i></p>';
    echo '<p style="text-align:right; color:#666"><span class="author-pengumuman" >'.$pengumuman->userCreate->nama_pemakai.' - '.$pengumuman->create_time.'</span></p><br/>';
    echo '</div>';
}
?>
</div>
</div>

<script type="text/javascript">
function tick(){
	$('#ticker div:first').slideUp( function () { $(this).appendTo($('#ticker')).slideDown(); });
}
setInterval(function(){ tick () }, 5000);

//function tick(){
//	$('#ticker li:first').animate({'opacity':0}, 200, function () { $(this).appendTo($('#ticker')).css('opacity', 1); });
//}
//setInterval(function(){ tick () }, 4000); javascript:chat(\''.$user->nama_pemakai.'\');



</script>

