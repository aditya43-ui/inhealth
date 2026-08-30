<?php
/**
* Digunakan untuk menyimpan fungsi yang berhubungan dengan view Informasirujukanpenunjangkeluar_v
* hanya untuk di modul laboratorium
*
* @category     modules
* @author       Muhammad Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
* @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class LBInformasirujukanpenunjangkeluarV extends InformasirujukanpenunjangkeluarV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable(){
            $criteria = $this->searchCriteria();
            
             return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchPrint(){
            $criteria = $this->searchCriteria();
            $criteria->limit = -1;
            
             return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination' => false
            ));
        }
        
        public function searchGrafik(){
            $criteria = $this->searchCriteria();
            $criteria->select = " count(kirimsamplelab_id) as jumlah, labklinikrujukan_nama as data ";
            $criteria->group = " data ";
            $criteria->order = " jumlah DESC ";
            //if ($_GET['tampilGrafik'] == 'wilayah'){
            
             return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,                    
            ));
        }
        
        public function searchCriteria(){
            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('DATE(tglkirimsample)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
            if (!empty($this->labklinikrujukan_id)){
                if (is_array($this->labklinikrujukan_id)){
                    $criteria->addInCondition("labklinikrujukan_id",$this->labklinikrujukan_id);
                }else{
                    $criteria->addCondition("labklinikrujukan_id = '".$this->labklinikrujukan_id."' ");
                }
            }
            
            
                    
            return $criteria;
        }
}