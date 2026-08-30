<style>
    .datadaftin {
        height: 200px;
    }

    /*    background-color:#c31884;*/
    .tile-purple {
        background-color: white !important;
        border: 2px solid #c31884;
    }

    .tile-stats.tile-purple {
        background-color: white !important
    }

    .tile-stats.tile-purple .num {
        color: #c31884;
    }

    .tile-stats.tile-purple h3 {
        color: black;
    }

    #seaset,
    li a:hover {
        color: #57a595;
    }
</style>
<div class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <b style="font-size:16px">Nominal Tarif</b>
        </div>
        <div class="panel-body">
            <div class="row" style="position:relative">
                <div class="col-md-11" style="position:absolute;left:0;z-index:2">
                    <div id="barset">
                        <ul style="text-align:center">
                            <li><a href="#" onclick="cari('<?php echo "all" ?>')"><?php echo "All" ?></a></li>
                            <?php
                            $modkelompok = KelompoktindakanM::model()->findAllByAttributes(array("kelompoktindakan_aktif" => true), array(
                                'order' => 'kelompoktindakan_urutan ASC',
                                'limit' => 3,
                            ));

                            foreach ($modkelompok as $row) {
                            ?>
                                <li><a href="#" onclick="cari(<?php echo $row->kelompoktindakan_id ?>)"><?php echo $row->kelompoktindakan_nama ?></a></li>

                            <?php } ?>
                        </ul>
                    </div>

                </div>
                <div class="col-md-12" id="setindexcol" style="position:absolute;right:0;">

                    <div id="sb-search" class="sb-search">
                        <form id="sb-search">
                            <input class="sb-search-input" placeholder="Cari Tindakan..." type="text" value="" name="search" id="search">
                            <!-- <input class="sb-search-submit" type="submit" value=""> -->
                            <span class="sb-icon-search" id="seaset"></span>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <div id="tampil" class="row" style="position:relative;margin-top:60px">

                <?php
                $no = 1;

                // $moddaftartindakan = DaftartindakanM::model()->findAll();
                $moddaftartindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_aktif' => true, 'daftartindakan_ekios' => true), array('order' => 'daftartindakan_id'));
                // $kelompoktindakanIds = [];
                // foreach($modDaftarTindakan as $modDT){
                //     $kelompoktindakanIds[]= $modDT->kelompoktindakan_id;
                // }
                // $cr  = new CDbCriteria();
                // $cr->addInCondition('kelompoktindakan_id',$kelompoktindakanIds);
                // $modKelompokTindakan = KelompoktindakanM::model()->findAll($cr);
                foreach ($moddaftartindakan as $row) {
                ?>
                    <div class="col-sm-12 col-md-3 ">
                        <div class="tile-stats tile-purple datadaftin">
                            <div class="icon"><i class="entypo-basket"></i></div>
                            <div class="num" style="font-size:16pt"><?php echo $row->daftartindakan_nama ?></div>
                            <?php $modtarif = TariftindakanM::model()->findByAttributes(array("daftartindakan_id" => $row->daftartindakan_id)) ?>
                            <h3 style="font-size:20pt">Rp <?php echo isset($modtarif->harga_tariftindakan) ? number_format($modtarif->harga_tariftindakan, 2) : 0 ?></h3>


                        </div>


                    </div>

                <?php } ?>
            </div>

        </div>
        <div class="panel-footer">

        </div>
    </div>


</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#search").on('keyup', function(e) {

            $("#tampil").addClass("animation-loading");
            $('#tampil').html("");
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('SetDaftarTindakan'); ?>',
                data: {
                    daftartindakan_nama: $(this).val()
                }, //
                dataType: "json",
                success: function(data) {
                    console.log(data.form)

                    $('#tampil').html(data.form);
                    $('#tampil').removeClass("animation-loading");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            // }

            // return false;
        });

        $("#sb-search").submit(function(e) {
            e.preventDefault();

            if (e.key === 'Enter' || e.keyCode === 13) {
                // Do something
                alert(e.target)
                console.log(e.target.value)
                $("#tampil").addClass("animation-loading");
                $('#tampil').html("");
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetDaftarTindakan'); ?>',
                    data: {
                        daftartindakan_nama: e.target.value
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $('#tampil').html(data.form);
                        $('#tampil').removeClass("animation-loading");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                return false;
            } else {
                $("#tampil").addClass("animation-loading");
                $('#tampil').html("");
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetDaftarTindakan'); ?>',
                    data: {
                        daftartindakan_nama: $(this).val()
                    }, //
                    dataType: "json",
                    success: function(data) {
                        console.log(data.form)

                        $('#tampil').html(data.form);
                        $('#tampil').removeClass("animation-loading");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

            // return false;
        });
        //
    });

    function cari(kelompoktindakan_id) {
        $("#tampil").addClass("animation-loading");
        $('#tampil').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('SetDaftarTindakan'); ?>',
            data: {
                kelompoktindakan_id: kelompoktindakan_id
            }, //
            dataType: "json",
            success: function(data) {
                console.log(data.form)
                $('#tampil').html(data.form);
                $('#tampil').removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>
<script>
    new UISearch(document.getElementById('sb-search'));
</script>