<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExpoter extends AbstractExporter
{
    public function export()
    {
        Excel::create('Filename', function($excel) {

            $excel->sheet('Sheetname', function($sheet) {
                // This logic get the columns that need to be exported from the table data
				$midashi = [];
				/*$midashi = ["recital.name","recital.planeddate","recital.comment1","recital.comment2","recital.comment3",
						"admin_user.name","musictitle.title","musictitle.composer","player.name","player.sex","rank","age","school_year",
						"chair_hight","foot_hight","pedal_hight","stand_hight","subplayer_chair","paging_chair",
						"remark","comment","comment1","comment2","comment3"
						];*/
				$midashi = ["発表会名","発表会日","発表会コメント1","発表会コメント2","発表会コメント3",
						"プログラムNo","講師","曲名","作曲者","発表者名","性別","年齢","学年","特記事項","コメント",
						"椅子の高さ","足台の高さ","ペダル高さ","譜面スタンド","連弾椅子","譜めくり椅子",
						"コメント1","コメント2","コメント3"
						];
				$sheet->rows(array($midashi));

                $rows = collect($this->getData())->map(function ($item) {
					//var_dump($item);exit;
					//return array_only($item, ['recital.name', 'id', 'age', 'school_year']);

						$keys = ["recital.name","recital.planeddate","recital.comment1","recital.comment2","recital.comment3",
						"rank","adminuser.name","musictitle.title","musictitle.composer","player.name","player.sex","age","school_year","remark","comment",
						"chair_hight","foot_hight","pedal_hight","stand_hight","subplayer_chair","paging_chair",
						"comment1","comment2","comment3"];
					
						$flattened = array_dot($item);//array_onlyで多重配列の奥までいけないみたいなので
						$arrrd=array();
						foreach ($keys as $key) {
							if (array_key_exists($key, $flattened)) {
								if ($flattened[$key]) {
									$arrrd = array_merge($arrrd,array($key=>$flattened[$key]));
								}else{
									$arrrd = array_merge($arrrd,array($key=>""));
								}	
							}else{
								$arrrd = array_merge($arrrd,array($key=>""));
							}
						}
						return $arrrd;
                });

                $sheet->rows($rows);

            });

        })->export('xls');
    }
}

