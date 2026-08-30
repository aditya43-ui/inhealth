<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table laporanrencanadiklatinternal_v, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class KPLaporanrencanadiklatinternalV extends LaporanrencanadiklatinternalV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

	/**
	 * - digunakan untuk mengenerate data di tabel  realisasi diklat internal
	 * @return  \CActiveDataProvider
	 * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @category		action
	 * @website		<piindonesia.co.id>
	 * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/> 
	 */
	public function searchTable(){
		$criteria = $this->searchCriteria();
		$criteria->order = " tglrencanadiklat ";
		
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  realisasi diklat internal
	 * @return \CActiveDataProvider
	 * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @category		action
	 * @website		<piindonesia.co.id>
	 * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/> 
	 */
	public function searchPrint(){
		$criteria = $this->searchCriteria();
		$criteria->order = " tglrencanadiklat ";
		
		$criteria->limit = -1;

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data  realisasi diklat internal dalam bentuk grafik
	 * @return \CActiveDataProvider
	 * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @category		action
	 * @website		<piindonesia.co.id>
	 * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/> 
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(rencanadiklat_id) as jumlah, namapelatihan as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		//if ($_GET['tampilGrafik'] == 'wilayah'){

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,                    
		));
	}

	/**
	 * - digunakan untuk memfilter datanya berdasarkan pencarian yang ada
	 * @return \CActiveDataProvider
	 * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @category		action
	 * @website		<piindonesia.co.id>
	 * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/> 
	 */
	public function searchCriteria(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('DATE(tglrencanadiklat)', $this->tgl_awal, $this->tgl_akhir);				
		$criteria->addNotInCondition(" status_rencana ", array(Params::STATUS_RENCANA_DIKLAT_REALISASI));
		
		return $criteria;
	}
}

?>
