<div class="span12">
    <table width="100%"id="tableGagal">
        <tr>
            <td width="20%">
                &nbsp;<?php echo $form->checkBox($model,'bb_rendah',array('class'=>'gagal', 'onclick' => 'cekBB(); ')); ?> <label>BB < 45kg </label>
            </td>
            <td> </td>
            <td width="20%">
                &nbsp;<?php echo $form->checkBox($model,'perilakuberesiko',array('class'=>'gagal', 'onclick' => 'cekPerilakuBeresiko(); ')); ?> <label>Perilaku Beresiko</label>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td>
                &nbsp;<?php echo $form->checkBox($model,'usia_kurang',array('class'=>'gagal')); ?> <label> Usia < 17 Tahun</label>
            </td>
            <td> </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'perilakuberesiko_homo',array('class'=>'gagal perilaku')); ?> <label>Homo</label>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td>
                &nbsp;<?php echo $form->checkBox($model,'hb_rendah',array('class'=>'gagal')); ?> <label>HB <</label>
            </td>
            <td> </td>
            <td> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'perilakuberesiko_tatto',array('class'=>'gagal perilaku', 'onclick'=>'cekRadioPerilaku(this)')); ?> <label>Tato</label>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td> 
                &nbsp;<?php echo $form->checkBox($model,'medis_lain',array('class'=>'gagal','onclick'=>'cekLain2(this)')); ?> <label>Medis Lain :</label>
            </td>
            <td> </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'perilakuberesiko_freesx',array('class'=>'gagal perilaku','onclick'=>'cekRadioPerilaku(this)')); ?> <label>Free Sx</label>
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'medis_tk_tinggi',array('class'=>'lain2 gagal', 'onclick' => 'cekTekDarah(); cekRadioMedis(this)')); ?> <label> Hypertensi </label>
            </td>
            <td> </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'perilakuberesiko_penasun',array('class'=>'gagal perilaku', 'onclick'=>'cekRadioPerilaku(this)')); ?> <label>Penasun</label>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'medis_td_rendah',array('class'=>'lain2 gagal', 'onclick' => 'cekTekDarah(); cekRadioMedis(this)')); ?> <label> Hypotensi </label>
            </td> 
            <td> </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'perilakuberesiko_napi',array('class'=>'gagal perilaku', 'onclick'=>'cekRadioPerilaku(this)')); ?> <label>Napi</label>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'minum_obat',array('class'=>'lain2 gagal', 'onclick' => 'cekRadioMedis(this)')); ?> <label>Minum Obat</label>
            </td>
            <td> </td>
            <td>  <?php echo $form->checkBox($model,'riwberpergian',array('class'=>'gagal', 'onclick' => 'cekRiwayat();')); ?> <label>Riwayat Bepergian</label>  </td>
            <td> </td>
        </tr>
        <tr>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'medis_pasca_op',array('class'=>'lain2 gagal', 'onclick' => 'cekRadioMedis(this)')); ?> <label>Pasca Op</label> </td>
            <td></td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'riwbepergian_endemik',array('class'=>'riw_bepergian gagal', 'onclick' => 'cekRadioRiwayat(this)')); ?> <label>Daerah Endemik</label>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'medis_hb_17',array('class'=>'lain2 gagal', 'onclick' => 'cekRadioMedis(this)')); ?> <label>HB > 17,0 gr %</label>
            </td>
            <td></td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'riwbepergian_hiv',array('class'=>'riw_bepergian gagal', 'onclick' => 'cekRadioRiwayat(this)')); ?> <label>Negara dg Kasus HIV </label>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'medis_vaksin',array('class'=>'lain2 gagal', 'onclick' => 'cekRadioMedis(this)')); ?> <label>Sakit / vaksin / haid / busui</label>
            </td>
            <td></td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'riwbepergian_sapigila',array('class'=>'riw_bepergian gagal', 'onclick' => 'cekRadioRiwayat(this)')); ?> <label>Negara dg Kasus Sapi Gila</label>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'medis_bb_lebih',array('class'=>'lain2 gagal', 'onclick' => 'cekRadioMedis(this)')); ?> <label>BB >></label>
            </td>
            <td></td>
            <td>
                &nbsp;<?php echo $form->checkBox($model,'lain_lain',array('class'=>'gagal', 'onclick' => 'cekLain();')); ?> <label>Lain-lain</label>

            </td>
            <td></td>
        </tr>
        <tr>
            <td> </td>
            <td> </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'lain_lain_tdkkembali',array('class'=>'lain gagal', 'onclick' => 'cekRadioLain(this)')); ?> <label>Tidak Kembali</label>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td> </td>
            <td> </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->radiobutton($model,'lain_lain_donortua',array('class'=>'lain gagal', 'onclick' => 'cekRadioLain(this)')); ?>  <label>Donor Pertama Usia > 65Th</label>
            </td>
            <td> </td>
        </tr>
    </table>
</div>