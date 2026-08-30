<?php
class AKSaldorekeningrasioV extends SaldorekeningrasioV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SaldorekeningrasioV the static model class
	 */
        public $tglAwal, $tglAkhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getRatio(){
            $sql = "SELECT sum(kasdansetarakas) AS kasdansetarakas,sum(kewajiban) AS kewajiban,sum(persediaan) AS persediaan,"
                    . "sum(aktivalancar) AS aktivalancar,sum(aktiva) AS aktiva,sum(labarugi) AS labarugi,"
                    . "sum(pendapatan) AS pendapatan,sum(ekuitas) AS ekuitas,sum(piutang) AS piutang,sum(investasilancar) AS investasilancar,"
                    . "sum(beban) AS beban,sum(bebanpenyusutandanamortisasi) AS bebanpenyusutandanamortisasi,sum(aktivatetap) AS aktivatetap,"
                    . "sum(akumulasipenyusutanaktivatetap) AS akumulasipenyusutanaktivatetap,"
                    . "(NULLIF(SUM(kasdansetarakas),0) / NULLIF(SUM(kewajiban),0)) AS cash_ratio, "
                    . "((NULLIF(SUM(aktivalancar),0) - NULLIF(SUM(persediaan),0)) / NULLIF(SUM(kewajiban),0)) AS quick_ratio, "
                    . "(NULLIF(SUM(aktivalancar),0) / NULLIF(SUM(kewajiban),0)) AS current_ratio, "
                    . "(NULLIF(SUM(aktiva),0) / NULLIF(SUM(kewajiban),0)) AS solvabilitas_ratio, "
                    . "(NULLIF((SUM(labarugi)),0) / NULLIF(SUM(pendapatan),0)) AS total_margin, "
                    . "(NULLIF((SUM(labarugi)),0) / NULLIF(SUM(ekuitas),0)) AS return_equity, "
                    . "(NULLIF(SUM(kewajiban),0) / NULLIF(SUM(ekuitas),0)) AS debt_equity, "
                    . "(NULLIF(SUM(kewajiban),0) / NULLIF(SUM(aktiva),0)) AS liability_total, "
                    . "(NULLIF(SUM(ekuitas),0) / NULLIF(SUM(aktiva),0)) AS equity_total, "
                    . "(NULLIF(SUM(pendapatan),0) / NULLIF(SUM(persediaan),0)) AS inventory_turn, "
                    . "(NULLIF(SUM(pendapatan),0) / NULLIF(SUM(piutang),0)) AS receivable_turn, "
                    . "(NULLIF((SUM(kasdansetarakas) + SUM(investasilancar)),0) / (NULLIF(SUM(beban),0) / 365)) AS days_cash, "
                    . "(NULLIF(SUM(piutang),0) / (NULLIF(SUM(pendapatan),0) / 365)) AS days_revenue, "
                    . "(NULLIF(SUM(pendapatan),0) / NULLIF(SUM(aktivalancar),0)) AS current_asset, "
                    . "(NULLIF(SUM(pendapatan),0) / NULLIF(SUM(aktivatetap),0)) AS fixed_asset, "
                    . "(NULLIF(SUM(pendapatan),0) / NULLIF(SUM(aktivalancar),0)) AS total_asset, "
                    . "(NULLIF(SUM(akumulasipenyusutanaktivatetap),0) / NULLIF(SUM(bebanpenyusutandanamortisasi),0)) AS average_age "
                    . "FROM saldorekeningrasio_v";
            $row = Yii::app()->db->createCommand($sql)->queryRow();
            return $row;  
        }
        
        
}