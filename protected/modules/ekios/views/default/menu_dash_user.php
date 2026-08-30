<?php
                
               // $model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');     
                $criteria = new CDbCriteria();
                $criteria->select='instalasi_id,ruangan_nama,ruangan_image,ruangan_fasilitas,kelaspelayanan_nama';
                $criteria->group='instalasi_id,ruangan_nama,ruangan_image,ruangan_fasilitas,kelaspelayanan_nama';
               
                //$criteria->addCondition(" modul_id = '".Yii::app()->user->getState('modul_id')."' ");
                $criteria->addCondition('kamarruangan_aktif = true');
                $criteria->order = 'ruangan_nama ASC';
                
                $menu = INInformasikamarinapV::model()->findAll($criteria);
                
                $criteria1= new CDbCriteria();
                $criteria1->select='DISTINCT(instalasi_id),instalasi_id,ruangan_image';
                $criteria1->group='instalasi_id,ruangan_image';
                
                //$criteria->addCondition(" modul_id = '".Yii::app()->user->getState('modul_id')."' ");
                $criteria1->addCondition('kamarruangan_aktif = true');
                
                $criteria1->order = 'instalasi_id ASC';
                $ruang = INInformasikamarinapV::model()->findAll($criteria1);
                //$m = MenuModul::getMenuModulAdmin($menu);                                
                
                $infogen='';
                $namafakamar='';
                $gambar[]='';
                $namakamar=array();
                $namafasilitas=array();
                $idkamar=array();
                $gambarkamar=array();
                
                $fasilitaskamar='';
                //$fasilitaskamar=array();
                
               $row=0;
               
                
                 //var_dump($idkamar);die;
                 $row1=0;
                 
                 foreach ($ruang as $arrku){
                     //var_dump($arrku->instalasi_id); 
                    //var_dump($arrMenu);
                      if(empty($arrku->ruangan_image) || $arrku->ruangan_image==''){
                               $gambar=Params::urlKamarRuanganDirectory()."no_photo.jpeg";
                            
                       }else{
                           if((file_exists(Params::urlKamarRuanganDirectory().$arrku->ruangan_image))){
                               $gambar=Params::urlKamarRuanganDirectory().$arrku->ruangan_image;
                           }else{
                                $gambar=Params::urlKamarRuanganDirectory()."no_photo.jpeg";
                           }
                       }
                         $infogen .="<div class='panel panel-primary'data-rel='collapse'>
			<div class='panel-heading'>
				<div class='panel-title rim'>Kamar Perawatan ".$arrku->instalasi_id."</div>
				
				<div class='panel-options'>
					<a href='#' data-rel='collapse'><i class='entypo-down-open'></i>
					<a href='#' data-rel='close' class='bg'><i class='entypo-cancel'></i></a>
				</div>
			</div>
                        <div class='panel-body' style='display: block;'><div class='row'>";
                        $spasiku=1;
                       foreach ($menu as $arrMenu){
                           //var_dump($arrMenu->instalasi_id);
                           //var_dump($arrMenu->instalasi_id);
                          
                          // var_dump($tmp);
                           //var_dump($idkamar[$row1]);
                           if($arrku->instalasi_id == $arrMenu->instalasi_id){
                                      //var_dump("asd");
                                        
                                        
                                      $infogen.="
                                          
                                                <div class='col-md-2'>
                                                  
                                                        <article class='album'>
				
                                                                <header>

                                                                        <a href='extra-gallery-single.html'>
                                                                                <img class='imgruangan ' width='295' height='60' src='".$gambar."' alt=''>
                                                                        </a>

                                                                       
                                                                </header>

                                                                

                                                                <footer>

                                                                        <div class='album-images-count'>
                                                                                <i class='entypo-picture'></i>
                                                                                1
                                                                        </div>

                                                                       

                                                                </footer>

                                                        </article>
                                                </div>
                                                <div class='col-md-2'>    
                                                      <div class='tile-stats tile-aqua'>
                                                                <div class='icon'><i class='entypo-picture'></i></div>
                                                                     <div class='num'>".$arrMenu['ruangan_nama']."</div>
                                                  
                                                                    <div class='bs-example bs-baseline-top'>

                                                                            <h3>Fasilitas:</h3>.<br><p>".$arrMenu['kelaspelayanan_nama']."<br>".$arrMenu['ruangan_nama']."</p>
                                                                     </div>
                                                                </div>
                                                         </div> ";
                                                     
                                          if($spasiku==3){
                                           $infogen.="<div class='clear'></div>";
                                           $spasiku=0;
                                        }
                                         $spasiku++;
                           }else{
                              
                           //$infogen.="<h4 class='popover-title-pak'><".$arrMenu1['ruangan_nama']."</h4><div class='popover-content'><b>Fasilitas:</b><br>".$arrMenu1['ruangan_fasilitas']."</div>";
                           }
                       }
                        $infogen .="</div></div></div>";  
                     $row1++;
                 }
                 echo  $infogen;

