
<div class="gallery-env">
    <?php
        foreach ($eResep as $i => $e){
    ?>
    <div class="col-sm-3">
        <article class="album" url_data="<?php echo Params::urlResepturDirectory().$e->eresep_image; ?>.png" onclick="cekDialog(this);">				
                <header>

                        <a href="javascript:void(0);">
                            <img src="<?php echo Params::urlResepturDirectory().$e->eresep_image; ?>.png">
                        </a>

                        <a href="#" class="album-options">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                Lihat
                        </a>
                </header>     
                <footer>
                    <label>eResep <?php echo $i+1; ?></label>
                </footer>
        </article>
    </div>
    <?php 
        }
    ?>
</div>

<script>
    function cekDialog(obj){
        window.parent.dialogShow($(obj).attr('url_data'));
    }
    
    
</script>