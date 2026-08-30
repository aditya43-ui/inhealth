<?php
/**
* - digunakan untuk memanggil view gambartubuh_m, hanya untuk modul bedah sentral
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
class BSGambartubuhM extends GambartubuhM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GambartubuhM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFileNameGambar(){
		$model = BSGambartubuhM::model()->find('gambartubuh_aktif = true AND ispemeriksaanfisik IS TRUE ORDER BY gambartubuh_urutan ASC');
		return $model->nama_file_gbr;
	}
	public function getDataGambarAnatomi(){
		$model = BSGambartubuhM::model()->find('gambartubuh_aktif = true AND ispemeriksaanfisik IS TRUE ORDER BY gambartubuh_urutan ASC');
		return $model;
	}
    
    public function getAllDataGambarAnatomi() {
        $model = BSGambartubuhM::model()->findAll('gambartubuh_aktif = true AND ispemeriksaanfisik IS TRUE ORDER BY gambartubuh_urutan ASC');
		return $model;
    }
	
	/**
	 * - digunakan untuk memanggil gambar khusus area bedah dan jenis kelamin tertentu
	 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @param type $jeniskelamin
	 * @return type
	 */
	public function getAllGambarAreaBedah($jeniskelamin='') {
		
		$cri = new CDbCriteria();
		$cri->addCondition(" gambartubuh_aktif = TRUE ");
		$cri->addCondition(" isareabedah = TRUE ");
		if (!empty($jeniskelamin)){
			$cri->addCondition(" jeniskelamin = '".$jeniskelamin."' ");
		}
		$cri->order = " gambartubuh_urutan ASC ";
		
        $model = BSGambartubuhM::model()->findAll($cri);

		return $model;
    }
}