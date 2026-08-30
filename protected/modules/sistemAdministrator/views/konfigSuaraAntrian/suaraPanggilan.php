<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/js.sound/jquery.jplayer.min.js'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/howler.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/suara.antrian.js'; ?>"></script>
<?php 

$jenissuara = $jeniskelamin;

?>
<script type="text/javascript">
/**
 * untuk membuat element jplayer
 * @param {type} i
 * @param {type} ii
 * @param {type} file
 * @returns {undefined}
 */   
    
/**
 * untuk membuat element jplayer yang dimainkan pertama
 * @param {type} i
 * @param {type} ii
 * @param {type} file
 * @returns {undefined}
 */    
function setPlaylist() {
    $("#jquery_jplayer_0").jPlayer( {
        ready: function () {
            jQuery(this).jPlayer("setMedia", {
                mp3: "<?php echo Yii::app()->request->baseUrl.'/data/sounds/antrian/mp3/'.$jenissuara.'/'.$nama.$ext ?>",
            });
        },
        play: function() { // To avoid both jPlayers playing together.
                $(this).jPlayer("pauseOthers");
        },
        repeat: function(event) { // Override the default jPlayer repeat event handler
                if(event.jPlayer.options.loop) {
                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {
                                $(this).jPlayer("play");
                        });
                }else {
                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {                           
                            $("#jquery_jplayer_0_tes").jPlayer("play");                           
                        });
                }
        },
        swfPath: "<?php echo Yii::app()->request->baseUrl;?>/js/js.sound",
        supplied: "<?php echo $ext; ?>",
        wmode: "window",
        cssSelectorAncestor: "#jp_interface_0_tes",
    });
}
</script>

<div id="jplayer_0">    
    <div id="jquery_jplayer_0_tes" class="jp-jplayer"></div>
</div>

<script type="text/javascript">
   
    setPlaylist();
  
</script>
        


<script type="text/javascript">


$(document).ready(function() {    
    
    var soundTru = [];
    var soundDat = [
        
            {name: "<?php echo $nama; ?>"},                    
    ];        
    setJenisSuaraAntrian("<?php echo Yii::app()->request->baseUrl;?>/data/sounds/antrian/mp3/<?php echo $jenissuara; ?>/");
    registerSuaraAntrian(soundDat);
});










</script>
