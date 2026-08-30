<script type="text/javascript">
/**
 * mencetak karcis farmasi
 */
function printKarcisFarmasi(antrianfarmasi_id, caraprint)
{
    id = $(".antrianfarmasiId").val();
    window.open("<?php echo $this->createUrl('PrintKarcisFarmasi') ?>&id="+antrianfarmasi_id+"&caraprint="+caraprint,"",'location=_new, width=240px, height=480px, left=640px, top=100px');
}

</script>