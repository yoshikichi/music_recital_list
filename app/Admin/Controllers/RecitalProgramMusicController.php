<?php

namespace App\Admin\Controllers;

use App\RecitalProgramMusic;
use App\Recital;
use App\Musictitle;
use App\Player;
use App\AdminUser;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Extensions\ExcelExpoter;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\MessageBag;

use DB;

class RecitalProgramMusicController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('曲予約と情報登録')
            ->description('プログラムの調整ができます。')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('詳細')
            ->description('曲予約と情報')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('編集')
            ->description('曲予約と情報')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('新規')
            ->description('曲予約と情報')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RecitalProgramMusic);
        $grid->exporter(new ExcelExpoter());
        $grid->rid('Id')->sortable();
        //$grid->recital_id('Recital id');
        //$grid->Recital()->name('発表会')->sortable();
		
		$grid->column('recital.name', '発表会')->display(function($text1) {
			return $text1; 
		})->sortable();	
		
        //$grid->admin_user_id('Admin user id');

        $grid->column('adminuser.name', '講師')->display(function($text2) {
		    if($this->admin_user_id!=Admin::user()->id && Admin::user()->roles[0]['slug']!="administrator") {
				$rtnname2="----";
			}else{
				$rtnname2=$text2;
			}
            return $rtnname2; 
        })->sortable();	
		
        $grid->column('player.name', '発表者')->display(function($text1) {
		    if($this->admin_user_id!=Admin::user()->id && Admin::user()->roles[0]['slug']!="administrator") {
				$rtnname="----";
			}else{
				$rtnname = $text1;
			}
            return $rtnname;
        })->sortable();
		
        $grid->column('player.classroom', '所属教室')->display(function($text3) {
		    if($this->admin_user_id!=Admin::user()->id && Admin::user()->roles[0]['slug']!="administrator") {
				$rtnname3="----";
			}else{
				$rtnname3 = $text3;
			}
            return $rtnname3;
        })->sortable();
        
        $grid->column('musictitle.title','曲名')->display(function($text) {
            $cnt = RecitalProgramMusic::where('recital_id',$this->recital_id)->where('musictitle_id',$this->musictitle_id)->count();
            if($cnt>1) {
                $text="<p style='color: rgb(255,50,50);'>_ かぶり _</p>".$text;
            }
            return $text;
        })->sortable();
        $grid->column('musictitle.composer','作曲者')->sortable();
        $grid->column('musictitle.dfc_level','難易度')->sortable();
        
        //$rctlid = $grid->recital_id();
        
        //$lk = Recital::select('looked')->where('id',$rctlid)->first();
        if(Admin::user()->roles[0]['slug']!="administrator") {
            $grid->rank('順番')->sortable();
        }else{
            $grid->rank('順番')->editable()->sortable();
        }
        
        $grid->age('年齢');
        
        $grid->school_year('学年');
        $grid->chair_hight('椅子の高さ');
        $grid->foot_hight('足台の高さ');
        $grid->pedal_hight('ペダル台の高さ');
        $grid->stand_hight('ピアノ譜面立て');
        $grid->subplayer_chair('連弾いす');
        $grid->paging_chair('譜めくり椅子');
        $grid->remark('特記事項');
        $grid->comment0('演奏時間');
        $grid->comment1('コメント1');
        $grid->comment2('コメント2');
        $grid->comment3('コメント3');
        //$grid->enabled('有効');
        //$grid->enabled('有効')->display(function ($enbl) {
        //    return $enbl?'有効':'無効';
        //});
        //$grid->looked('ロック');
        //$grid->looked('ロック')->display(function ($lk) {
        //    return $lk?'許可':'ロック';
        //});
       		

        
        $grid->actions(function ($actions) {
                if($actions->row->admin_user_id!=Admin::user()->id && Admin::user()->roles[0]['slug']!="administrator") {
                        $actions->disableDelete();
                        $actions->disableEdit();
                        $actions->disableView();
                }
                $rid = $actions->row->recital_id;
                $lk = Recital::select('looked')->where('id',$rid)->first();
                if($lk->looked == 0 && Admin::user()->roles[0]['slug']!="administrator") {
                        $actions->disableDelete();
                        $actions->disableEdit();
                        $actions->disableView();
                }
        });
        
        $rctenbl_ids = Recital::select('id')->where('enabled','1')->get();
//        $grid->model()->whereIn('recital_id',$rctenbl_ids)->orderBy('recital_id')->orderBy('age')->orderBy('player_id')->orderBy('rank');
        //$grid->model()->whereIn('recital_id',$rctenbl_ids)->orderBy('recital_id')->orderBy('birthday','DESC')->orderBy('player_id')->orderBy('rank');
        $grid->model()->select(
                 '*'
                ,'recital_program_musics.id as id'
                ,'recital_program_musics.id as rid'
                ,'recital_program_musics.created_at as rpm_created_at'
                ,'recital_program_musics.updated_at as rpm_updated_at')
                ->join('players as pl', 'pl.id', '=', 'recital_program_musics.player_id')
                ->whereIn('recital_id',$rctenbl_ids)
                ->orderBy('recital_id')->orderBy('pl.birthday','DESC')->orderBy('player_id')->orderBy('rank');
        $grid->disableRowSelector();
        
        $grid->rpm_created_at('作成日')->sortable();
        $grid->rpm_updated_at('更新日')->sortable();
        
        $grid->filter(function($filter){
            //$filter->like('recital_id', '発表会');
            //$filter->equal('recital_id', '発表会')->select(Recital::pluck('name','id'));
            $rctenbl_ids = Recital::select('id')->where('enabled','1')->get();
            $filter->equal('recital_id', '発表会')->select(Recital::whereIn('id',$rctenbl_ids)->pluck('name','id'));
            $filter->equal('musictitle_id', '曲名')->select(Musictitle::pluck('title','id'));
            
            $filter->where(function ($query) { 
                    $input = $this->input; 
                    $query->whereHas('Player', function ($query) use ($input) { 
                        $query->where('classroom', $input); 
                    }); 
                }, '所属教室')->select(Player::distinct()->pluck('classroom', 'classroom'));
            if(Admin::user()->roles[0]['slug']!="administrator"){    
                $filter->equal('player_id', '発表者')->select(Player::where('teacher_id',Admin::user()->id)->orderBy('furikana')->pluck('name', 'id'));
            }else{
                $filter->equal('player_id', '発表者')->select(Player::orderBy('furikana')->pluck('name', 'id'));
            }
        });

        return $grid;

    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(RecitalProgramMusic::findOrFail($id));

        $show->id('ID');
        $show->recital_id('発表会id');
        $show->admin_user_id('講師id');
        $show->admin_user_id('講師')->as(function ($tid) {
            $ttcr= AdminUser::findOrFail($tid);
            return $ttcr->name;
        });
        $show->player_id('発表者id');
        $show->player_id('発表者名')->as(function ($tid) {
            $ttcr= Player::findOrFail($tid);
            return $ttcr->name;
        });
        $show->player_id('所属教室')->as(function ($tid) {
            $ttcr= Player::findOrFail($tid);
            return $ttcr->classroom;
        });
        $show->musictitle_id('楽曲名id');
        $show->musictitle_id('楽曲名')->as(function ($tid) {
            $ttcr= Musictitle::findOrFail($tid);
            return $ttcr->title." ".$ttcr->composer;
        });
        $show->age('年齢');
        $show->school_year('学年');
        $show->chair_hight('椅子の高さ');
        $show->foot_hight('足台の高さ');
        $show->pedal_hight('ペダル台の高さ');
        $show->stand_hight('ピアノ譜面立て');
        $show->subplayer_chair('連弾いす');
        $show->paging_chair('譜めくり椅子');
        $show->remark('特記事項');
        $show->comment0('演奏時間');
        //$show->enabled('有効');
        //$show->enabled('有効')->as(function ($released) {
        //    return $released ? '有効' : '無効';
        //});
        //$show->looked('ロック');
        //$show->looked('ロック')->as(function ($released) {
        //    return $released ? '許可' : 'ロック';
        //});
        $show->comment1('コメント1');
        $show->comment2('コメント2');
        $show->comment3('コメント3');
        $show->rank('順番');
        $show->created_at('作成日');
        $show->updated_at('更新日');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RecitalProgramMusic);

        //$form->number('recital_id', 'Recital id');
$form->tab('基本情報', function ($form) {
        $form->select('recital_id', '発表会名')->options(
            Recital::where('looked',1)->where('enabled',1)->pluck('name', 'id')
        )->rules('required');

        if(Admin::user()->roles[0]['slug']=="administrator") {
			$form->select('admin_user_id', '講師')->options(
				AdminUser::orderBy('name', 'asc')->pluck('name', 'id')
			)->rules('required');
		}else{
			$form->select('admin_user_id', '講師')->options(
				AdminUser::where('id', Admin::user()->id)->pluck('name', 'id')
			)->rules('required');
		}

        if(Admin::user()->roles[0]['slug']=="administrator") {
			$form->select('player_id', '発表者')->options(
				Player::where('enabled',1)->orderBy('furikana', 'asc')->pluck('name', 'id')
			)->rules('required');
		}else{
			$form->select('player_id', '発表者')->options(
				Player::where('teacher_id', Admin::user()->id)->where('enabled',1)->orderBy('furikana', 'asc')->pluck('name', 'id')
			)->rules('required');			
		}

        $form->select('musictitle_id', '曲名')->options(
                Musictitle::select(DB::raw("CONCAT(composer,'　',title) AS name"),'id')->where('enabled',1)->orderBy('composer_furikana', 'asc')->orderBy('title_furikana', 'asc')->pluck('name', 'id')
        )->rules('required');
        $form->number('rank', '順番')->value('0');

        $form->number('age', '年齢')->value('0')->help('生徒登録で生年月日を登録している場合、発表会当日の年齢で自動登録されます。');
        
        
        $form->select('school_year', '学年')->options(['未就園' =>'未就園', '年少' => '年少', '年中' => '年中', '年長' => '年長', 
			'小１' => '小１','小２' => '小２','小３' => '小３','小４' => '小４','小５' => '小５','小６' => '小６', '中１' => '中１', '中２' => '中２', '中３' => '中３', 
			'高１' => '高１','高２' => '高２','高３' => '高３', '大１' => '大１', '大２' => '大２','大３' => '大３','大４' => '大４','大人' => '大人'])->help('生徒登録で生年月日を登録している場合、発表会当日の学年（小１～中３のみ）で自動登録されます。');
})->tab('詳細', function ($form) {
		//$form->text('chair_hight', '椅子の高さ');
	    $form->select('chair_hight', '椅子の高さ')->options(['低' => '低','低中' => '低中','中' => '中', '中高' => '中高','高' => '高']);
        //$form->text('foot_hight', '足台の高さ');
		$form->select('foot_hight', '足台の高さ')->options(['無' => '無','低' => '低','低中' => '低中','中' => '中', '中高' => '中高','高' => '高']);
        //$form->text('pedal_hight', 'ペダル台の高さ');
		$form->select('pedal_hight', 'ペダル台の高さ')->options(['無' => '無','低' => '低','低中' => '低中','中' => '中', '中高' => '中高','高' => '高']);
        //$form->text('stand_hight', 'ピアノ譜面立て');
		$form->select('stand_hight', 'ピアノ譜面立て')->options(['無' => '無','有' => '有', '連弾のみ' => '連弾のみ']);
        //$form->text('subplayer_chair', '連弾いす');
		$form->select('subplayer_chair', '連弾いす')->options(['無' => '無', '有１脚' => '有１脚', '有２脚' => '有２脚', '連弾のみ' => '連弾のみ']);
        //$form->text('paging_chair', '譜めくり椅子');
		$form->select('paging_chair', '譜めくり椅子')->options(['無' => '無','有' => '有', '連弾のみ' => '連弾のみ']);
        $form->text('remark', '特記事項')->rules('max:100');
        $form->time('comment0', '演奏時間');
        $form->text('comment1', 'コメント1')->rules('max:100');
        $form->text('comment2', 'コメント2')->rules('max:100');
        $form->text('comment3', 'コメント3')->rules('max:100');

        //$form->number('enabled', 'Enabled');
//                $states = [
//                    'on' => ['value'=>1, 'text'=>'有効'],
//                    'off' => ['value'=>0, 'text'=>'無効'],
//                ];
//                $form->switch('enabled', '有効')->states($states);
        //$form->number('looked', 'Looked');
//                $states2 = [
//                    'on' => ['value'=>1, 'text'=>'許可'],
//                    'off' => ['value'=>0, 'text'=>'ロック'],
//                ];
//                $form->switch('looked', 'ロック')->states($states2);

});

        $form->saving(function ($form) {
            //$mtid = $form->model()->id;  //UpdateかInsertか判別に使う
            //年齢計算
            $birthday = "";
            $rctldate = "";
            $rctlid = $form->recital_id;
            $ply_id = $form->player_id;
            $ply_birth = Player::where('id',$ply_id)->value('birthday');
            if($ply_birth!=null){
                $birthday = str_replace("-", "", $ply_birth);//ハイフンを除去しています。
                $rctl_date = Recital::where('id',$rctlid)->value('planeddate');
                $rctldate = str_replace("-", "", $rctl_date);//ハイフンを除去しています。
                $form->age = floor(($rctldate-$birthday)/10000);

				//学年計算小１から中３
				//両方とも年度基準にする
				$rctlyaer=0;
				if(substr($rctldate, -4)>"0401"){
					$rctlyaer=(int)substr($rctldate,0,4);
				}else{
					$rctlyaer=(int)substr($rctldate,0,4)-1;//前年を年度とする
				}

				$birthyaer=0;
				if(substr($birthday, -4)>"0401"){
					$birthyaer=(int)substr($birthday,0,4);
				}else{
					$birthyaer=(int)substr($birthday,0,4)-1;//早生まれ年度
				}
				$diffyaers=$rctlyaer-$birthyaer;
				//echo $diffyaers;exit;
				$gakunen = "";
                switch (true){
                    case $diffyaers < 7:
                        break;
                    case $diffyaers >= 7 && $diffyaers < 8:
                        $gakunen = "小１";
                        break;
                    case $diffyaers >= 8 && $diffyaers < 9:
                        $gakunen = "小２";
                        break;
                    case $diffyaers >= 9 && $diffyaers < 10:
                        $gakunen = "小３";
                        break;
                    case $diffyaers >= 10 && $diffyaers < 11:
                        $gakunen = "小４";
                        break;
                    case $diffyaers >= 11 && $diffyaers < 12:
                        $gakunen = "小５";
                        break;
                    case $diffyaers >= 12 && $diffyaers < 13:
                        $gakunen = "小６";
                        break;
                    case $diffyaers >= 13 && $diffyaers < 14;
                        $gakunen = "中１";
                        break;
                    case $diffyaers >= 14 && $diffyaers < 15:
                        $gakunen = "中２";
                        break;
                    case $diffyaers >= 15 && $diffyaers < 16:
                        $gakunen = "中３";
                        break;
                    case $diffyaers >= 16:
                        break;
					default:
						break;
                }
                //echo $gakunen;
				if($gakunen != ""){
					if(!$form->school_year){
						$form->school_year = $gakunen;
					}
				}
			}
            
        });

        $form->saved(function (Form $form) {
            //$form->model()->id;
			
			DB::update('UPDATE recital_program_musics as rpm left join players on players.id = rpm.player_id SET rpm.birthday=players.birthday WHERE rpm.id = ? ', [$form->model()->id]);
			
            $recid = $form->recital_id;
            $recname = Recital::where('id',$recid)->first();
            $mscttl = $form->musictitle_id;
            $mscttlname = Musictitle::where('id',$mscttl)->first();
            
            $cnt = RecitalProgramMusic::where('recital_id',$recid)->where('musictitle_id',$mscttl)->count();
            
            if($cnt>1){
                $success = new MessageBag([
                    'title'   => '既に同じ曲を選んだ方がいます。（'.$recname->name.'） '.$mscttlname->title,
                    'message' => 'あなたの生徒様は、最初に選んだ生徒様と調整がついた場合、演奏できます。',
                ]);

                return back()->with(compact('success'));                
            }

         });

        return $form;
    }
}
