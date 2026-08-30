<?php
class RKRl4bMorbiditasrjV extends Rl4bMorbiditasrjV
{
        public $jmlpsn;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}      
                
        public function getSumDiagnosa($diagnosa_id,$golonganumur_id,$jeniskelamin){
            
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'diagnosa_id, golonganumur_id, jeniskelamin';

            $criteria->addCondition('diagnosa_id = '.$diagnosa_id);
            $criteria->addCondition('golonganumur_id = '.$golonganumur_id);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($jeniskelamin),true);
            $criteria->select = $criteria->group.', sum(jmljeniskelamin) AS jmljeniskelamin';
            $modMorbiditas = RKRl4bMorbiditasrjV::model()->findAll($criteria);
            $totPasien = 0;
                foreach($modMorbiditas as $key=>$jml){
                    $totPasien += $jml->jmljeniskelamin;
                }
            return $totPasien;
        }
        
        public function getSumKeluar($diagnosa_id,$jeniskelamin){
            
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'diagnosa_id, jeniskelamin';

            $criteria->addCondition('diagnosa_id = '.$diagnosa_id);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($jeniskelamin),true);
            $criteria->select = $criteria->group.', count(kasusdiagnosa) AS jmlpsn';
            $modMorbiditas = RKRl4bMorbiditasrjV::model()->findAll($criteria);
            $totPasien = 0;
                foreach($modMorbiditas as $key=>$jml){
                    $totPasien += $jml->jmlpsn;
                }
            return $totPasien;
        }
        
        public function getSumKeluarTotal($jeniskelamin){
            
             $format = new MyFormatter();
             $criteria=new CDbCriteria();
             $criteria->group = 'jeniskelamin';

             $criteria->compare('LOWER(jeniskelamin)',strtolower($jeniskelamin),true);
             $criteria->select = $criteria->group.', count(jmljeniskelamin) AS jmlpsn';
             $modMorbiditas = RKRl4bMorbiditasrjV::model()->findAll($criteria);
             $totPasien = 0;
                foreach($modMorbiditas as $key=>$jml){
                    $totPasien += $jml->jmlpsn;
                }
             return $totPasien;
        }
        
        public function getTotalKeluar($diagnosa_id,$status){
            
             $format = new MyFormatter();
             $criteria=new CDbCriteria();
             $criteria->group = 'diagnosa_id, kasusdiagnosa';

             $criteria->addCondition('diagnosa_id = '.$diagnosa_id);
             $criteria->compare('LOWER(kasusdiagnosa)',strtolower($status),true);
             $criteria->select = $criteria->group.', count(kasusdiagnosa) AS jmlpsn';
             $modMorbiditas = RKRl4bMorbiditasrjV::model()->findAll($criteria);
             $totPasien = 0;
                foreach($modMorbiditas as $key=>$jml){
                    $totPasien += $jml->jmlpsn;
                }
             return $totPasien;
        }
        
        public function getSumTotalKeluar($status){
            
             $format = new MyFormatter();
             $criteria=new CDbCriteria();
             $criteria->group = 'kasusdiagnosa';

             $criteria->compare('LOWER(kasusdiagnosa)',strtolower($status),true);
             $criteria->select = $criteria->group.', count(kasusdiagnosa) AS jmlpsn';
             $modMorbiditas = RKRl4bMorbiditasrjV::model()->findAll($criteria);
             $totPasien = 0;
                foreach($modMorbiditas as $key=>$jml){
                    $totPasien += $jml->jmlpsn;
                }
             return $totPasien;
        }

        public function getSumTotalDiagnosa($golonganumur_id,$jeniskelamin){
          
            
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'golonganumur_id,jeniskelamin';

            $criteria->addCondition('golonganumur_id = '.$golonganumur_id);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($jeniskelamin),true);
            $criteria->select = $criteria->group.', count(jmlgolumur) AS jmlgolumur';
            $modMorbiditas = RKRl4bMorbiditasrjV::model()->findAll($criteria);
            $totPasien = 0;
                foreach($modMorbiditas as $key=>$jml){
                    $totPasien += $jml->jmlgolumur;
                }
             return $totPasien;
        }

}