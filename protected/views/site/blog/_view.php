<?php
/**
 * digunakan untuk modul portal rs informasi Berita
 * perubahan format hari
 * RSST-2445
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
?>

<style>
   
   .images {

  display: inline-block;

}
.fade {
  animation-name: fade;
  animation-duration: 5s;
  animation-fill-mode: forwards;
  
}

@keyframes fade {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/lozad"></script>

<article class="post post-large" style="margin-top:20px;">
    <div class="post-date">
        <span class="day" style="color:#009efb"><?php echo date('d', strtotime($data->post_tgl)); ?></span>
        <span class="month" style="background-color:#009efb"><?php echo MyFormatter::getDayUser(date('w', strtotime($data->post_tgl))); ?></span>
    </div>
    <div class="">
        <h2><a href="<?php echo $this->createUrl('viewblog', array('id' => CHtml::encode($data->post_id))); ?>"><?php echo CHtml::encode($data->post_judul); ?></a></h2>
      <h3></h3>
        <?php if (!empty($data->post_gambar)) { ?>
        
      <div class="headline-news" style="width:100%; padding:8px;">
          <div class="images"><img class="img-responsive lozad" loading="lazy" style="float:left; margin:0 10px 5px 0;" data-src="<?php echo Params::urlBeritaGambar() . $data->post_gambar; ?>" alt="" width="100%" style=" margin:0"></div>
          <div class="text-news"><p style="text-align:justify;">
                    
                <?php
                $string = strip_tags($data->post_desc);
                if (strlen($string) > 500) {
                    $stringCut = substr($string, 0, 500);
                    $string = substr($stringCut, 0, strrpos($stringCut, ' '));
                }
                echo $string;
                ?> [...]
                </p></div>
                
            </div>
        <?php } else { ?>
            <div class="row" style="width:100%; padding:8px;">
                <div class="col-12">
                    <p style="text-align:justify;">
                    <?php
                    $string = strip_tags($data->post_desc);
                    if (strlen($string) > 500) {
                        $stringCut = substr($string, 0, 500);
                        $string = substr($stringCut, 0, strrpos($stringCut, ' '));
                    }
                    echo $string;
                    ?> [...]
                    </p>
                </div>
            </div>
        <?php } ?>
        <div class="post-meta">
            <?php
            $modul = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
            if (!empty($modul->nama_pemakai)) {
                $namapemakai = $modul->nama_pemakai;
            }
            $modul = KategoripostM::model()->findByPk($data->kategoripost_id);
            if (!empty($modul->kategoripost_id)) {
                $kategori = $modul->kategoripost_nama;
            }
            ?>
                <!-- <span><i class="fa fa-calendar"></i> <?php echo date('F d, Y', strtotime($data->post_tgl)); ?> </span> -->
            <span><i class="entypo-user"></i> Oleh <a href="#"><?php echo isset($data->create_loginpemakai_id) ? CHtml::encode($namapemakai) : 'Unknown'; ?></a> </span>
            <span><i class="entypo-tag"></i> <a href="#"><?php echo isset($data->kategoripost_id) ? CHtml::encode($kategori) : 'Unknown'; ?></a> </span>
            <span><i class="entypo-comment"></i> <a href="<?php echo $this->createUrl('viewblog', array('id' => CHtml::encode($data->post_id))); ?>"><?php echo ($data->getJumlahComment() > 0) ? $data->getJumlahComment() . ' Comments' : 'Ketik Komentar..'; ?></a></span>
            <a style="margin-top:-10px" href="<?php echo $this->createUrl('viewblog', array('id' => CHtml::encode($data->post_id))); ?>" class="btn btn-info btn-me pull-right">Baca Selengkapnya</a>
        </div>
    </div>
</article>

<script>

// Initialize library
lozad('.lozad', {
    threshold: 0.1,
    enableAutoReload: true,
    load: function(el) {
        
        el.src = el.dataset.src;
        el.onload = function() {
            el.classList.add('fade')
        }
    }
}).observe()



</script>