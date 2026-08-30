
<div id="">
    <?php
    $criteria1  = new CDbCriteria();
    $criteria2  = new CDbCriteria();
    // $cr->join =  'LEFT JOIN daftartindakan_m ON t.kelompoktindakan_id = daftartindakan_m.kelompoktindakan_id';
    // $cr->condition = 't.kelompoktindakan_aktif=true';
    // $cr->condition = 'daftartindakan_m.daftartindakan_aktif=true';
    // $cr->condition = 'daftartindakan_m.daftartindakan_ekios=true';
    // $cr->order = 't.kelompoktindakan_urutan';
    // $modKelompokTindakan = KelompoktindakanM::model()->findAll($cr);

    // $modKelompokTindakan = KelompoktindakanM::model()->findAllByAttributes(array('kelompoktindakan_aktif' => true), array('order' => 'kelompoktindakan_urutan'));
    // $modDaftarTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_aktif' => true,'daftartindakan_ekios' => true), array('order' => 'daftartindakan_id'));
    // $kelompoktindakanIds = [];
    // foreach($modDaftarTindakan as $modDT){
    //     $kelompoktindakanIds[]= $modDT->kelompoktindakan_id;
    // }
    // $cr  = new CDbCriteria();
    // $cr->addInCondition('kelompoktindakan_id',$kelompoktindakanIds);
    // $modKelompokTindakan = KelompoktindakanM::model()->findAll($cr);

                 // $criteria2->addCondition("daftartindakan_nama ilike '%" . $kelompoktindakan_nama . "%'");
                // $criteria2->addCondition("daftartindakan_aktif=true");
                // $criteria2->addCondition("daftartindakan_ekios=true");
                // $modDaftarTindakan = DaftartindakanM::model()->findAll($criteria2);
if(isset($modDaftarTindakan) && count($modDaftarTindakan) > 0) {
                $arr = [];
                foreach ($modDaftarTindakan as $dt) {
                    $arr[] = $dt->kelompoktindakan_id;
                }
                $criteria1->addInCondition('kelompoktindakan_id', $arr);
                $modKelompokTindakan = KelompoktindakanM::model()->findAll($criteria1);

    ?>

   
    <table id="tblFormPemeriksaanLab" class="table table-bordered table-striped table-condensed" style="margin-top:10px">
        <thead>
            <tr>
                <th>Uraian Tindakan</th>
                <th>Nominal Tarif</th>
                <th>Hapus</th>

            </tr>
        </thead>
        <tbody>
                <!--<tr id="trPeriksaLabKosong"><td colspan="5"></td></tr>-->
        </tbody>
    </table>
    <table class="table bordered table-striped table-condensed">
        <tr><td width="70%" style="text-align: right;"><a href="#" data-toggle="tooltip" data-placement="left" title="Discalimer: Harga tersebut adalah harga estimasi dan belum termasuk biaya APD level 3 sebesar 110rb ,yang digunakan oleh tenaga medis kami dan proteksi set  yang digunakan oleh pasien untuk menjaga keselamatan dan mengurangi risiko infeksi silang antar pasien. <br> Terimakasih"><i class="fa fa-info-circle"></i></a>Total Biaya Tindakan</td><td><?php echo CHtml::textField('periksaTotal', '', array('class' => 'span2 integer', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td></tr>
    </table>
    <div class="row">
        <div class="col-md-12">
             <div class="input-group">
                 <input type="text" class="form-control input-lg" id="search" placeholder="pencarian">
                    
                    <span class="input-group-btn">
                      
                            <button class="btn btn-primary btn-lg"  type="button">cari</button>
                       
                    </span>
            </div>
            <br>
        </div>
        <div class="col-md-12">
        <?php
            echo  
             '<label class="checkbox inline">' . CHtml::activeCheckBox($modPPBuatJanjiPoli,'is_kontrol', array('onclick' => "inputkontrol(this);"));
        echo "<span>Kontrol</span></label><br/>";
        ?>
        </div>
     
    </div>
    <div class="row" id="tampil">
      
       
        <?php if(count($modDaftarTindakan) > 0) {
            // $tindakanUnique = arary_unique(array_column($modDaftarTindakan,'daftartindakan_id'));

            // echo "<pre>";
            // print_r($tindakanUnique);

        foreach ($modKelompokTindakan as $i => $kelompoktindakan) {
            $ceklist = false;
//											$patologi = $kelompoktindakan->jenispemeriksaanlab_kelompok;
            ?>
            <div class="col-xs-4 form-awal">
                <div class="boxtindakan" style="">
                    <div class="panel panel-success panel-shadow" >
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo $kelompoktindakan->kelompoktindakan_nama; ?></div>
                        </div>
                        <div class="panel-body" >
                            <?php
                            foreach ($modDaftarTindakan as $j => $DaftarTindakan) {
                                if ($kelompoktindakan->kelompoktindakan_id == $DaftarTindakan->kelompoktindakan_id) {
                                    echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array('value' => $DaftarTindakan->daftartindakan_id,
                                        'onclick' => "inputperiksa(this);"));
                                    echo "<span>" . $DaftarTindakan->daftartindakan_nama . "</span></label><br/>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        <?php }}
        ?>
    </div>
<?php } ?>

</div> 

<script>
        $(document).ready(function () {


        $('#search').on('keyup', function () {
            $("#tampil").addClass("animation-loading");
            $('#tampil').html("");
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('SetTindakan'); ?>',
                data: {kelompoktindakan_nama: $(this).val(), tgl:$('#BuatjanjipoliT_tgljadwal').val(),jam:$('#BuatjanjipoliT_jambooking').val()}, //
                dataType: "json",
                success: function (data) {
                    // var arr = ['foo', 'bar', 'bar'];
                    // Array.from(new Set(arr));

                    $('#tampil').html(data.form);
                    $('#tampil').removeClass("animation-loading");
                    $('.form-awal').html("");

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    });
        </script>