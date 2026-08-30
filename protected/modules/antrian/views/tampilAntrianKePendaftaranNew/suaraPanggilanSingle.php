<div id="player">
    <div id="jquery_jplayer_antrian" class="jp-jplayer"></div>
    <div id="jquery_jplayer_kodeantri" class="jp-jplayer"></div>
    <?php 
    if(count($noantrian_split) > 0){
        foreach($noantrian_split as $i => $nomor){
    ?>
        <div id="jquery_jplayer_<?php echo $i; ?>" class="jp-jplayer"></div>
    <?php 
        }
    }
    ?>
    <div id="jquery_jplayer_keloket" class="jp-jplayer"></div>
    <div id="jquery_jplayer_loket" class="jp-jplayer"></div>
</div>

<script type="text/javascript">

    function setPlaylist(id,file) {
        $("#jquery_jplayer_" +id).jPlayer( {
            ready: function () {
                jQuery(this).jPlayer("setMedia", {
                    mp3: "<?php echo Yii::app()->request->baseUrl.'/data/sounds/mp3/'?>"+file+".mp3",
                    oga: "<?php echo Yii::app()->request->baseUrl.'/data/sounds/ogg/'?>"+file+".ogg",
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
                                if(id == "kodeantri"){ //setelah kodeantri di play
                                    $("#jquery_jplayer_0").jPlayer("play");
                                }else if(id == "keloket"){ //setelah keloket di play
                                    $("#jquery_jplayer_loket").jPlayer("play");
                                }else if(id == "loket"){ //setelah loket di play
                                    
                                }else{
                                    var next_id = parseInt(id) + 1;
                                    if(next_id < <?php echo count($noantrian_split); ?>){
                                        $("#jquery_jplayer_"+next_id).jPlayer("play");
                                    }else{ //setelah noantrian di play
                                        $("#jquery_jplayer_keloket").jPlayer("play");
                                    }
                                }
                                
                            });
                    }
            },
            swfPath: "<?php echo Yii::app()->request->baseUrl;?>/js/js.sound",
            supplied: "mp3, oga",
            wmode: "window",
            cssSelectorAncestor: "#jp_interface_" + id,
        });
    }
    function mainkan(){
        $("#jquery_jplayer_antrian").jPlayer({
            ready: function () {
                    $(this).jPlayer("setMedia", {
                            mp3: "<?php echo Yii::app()->request->baseUrl;?>/data/sounds/mp3/antrian.mp3",
                            oga:  "<?php echo Yii::app()->request->baseUrl;?>/data/sounds/ogg/antrian.ogg"
                    }).jPlayer("play");
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
                    } else {
                            $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
                            $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {
                                    $("#jquery_jplayer_kodeantri").jPlayer("play",0);
                            });
                    }
            },
            swfPath: "<?php echo Yii::app()->request->baseUrl;?>/js/js.sound",
            supplied: "mp3, oga",
            wmode: "window",
            autoPlay : true
        });
    }
    
    setPlaylist("kodeantri","<?php echo strtolower(trim($modLoket->loket_singkatan)); ?>");
    setPlaylist("keloket","keloket");
    setPlaylist("loket","<?php echo strtolower(trim($modLoket->loket_nourut)); ?>");
    
    <?php 
    if(count($noantrian_split) > 0){
        foreach($noantrian_split as $j => $nomor){
    ?>
                setPlaylist("<?php echo $j ?>","<?php echo $nomor?>");
    <?php 
            }
        }
    ?>
$(document).ready(function(){
    mainkan();
});
</script>