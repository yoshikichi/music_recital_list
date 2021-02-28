<?php

namespace App\Admin\Controllers;
use Encore\Admin\Facades\Admin;
use App\Player;
use App\AdminUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PlayerController extends Controller
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
            ->header('生徒登録')
            ->description('生徒を登録編集できます。')
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
            ->description('生徒登録')
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
            ->description('生徒登録')
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
            ->description('生徒登録')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Player);

        $grid->id('Id')->sortable();
        $grid->name('名前')->sortable();
        $grid->furikana('ふりがな')->sortable();
        $grid->sex('性別')->sortable();
        $grid->birthday('生年月日')->sortable();
        $grid->classroom('所属教室')->sortable();
        //$grid->AdminUser()->name('講師')->sortable();
        $grid->teacher_id('講師')->display(function($text) {
            return AdminUser::where('id',$text)->value('name');
        })->sortable();
        $grid->enabled('有効')->display(function ($enbl) {
            return $enbl?'有効':'無効';
        })->sortable();
        $grid->comment('コメント')->sortable();
        $grid->created_at('作成日')->sortable();
        $grid->updated_at('更新日')->sortable();
        $grid->disableRowSelector();
        $grid->actions(function ($actions) {
                if($actions->row->teacher_id!=Admin::user()->id && Admin::user()->roles[0]['slug']!="administrator") {
                        $actions->disableDelete();
                        $actions->disableEdit();
                        $actions->disableView();
                }
        });

        if(Admin::user()->roles[0]['slug']=="administrator") {
            $grid->model()->orderBy('furikana');
        }else{
                $grid->model()->where('teacher_id',Admin::user()->id)->orderBy('furikana');
        }
        
        if(Admin::user()->roles[0]['slug']=="administrator") {
            $grid->filter(function($filter){
                $filter->like('name', '名前');
                $filter->equal('classroom', '所属教室')->select(['東伏見教室' => '東伏見教室', '玉川上水教室' => '玉川上水教室', '小川駅前教室' => '小川駅前教室', '鷹の台教室' => '鷹の台教室']);
                $filter->equal('teacher_id', '講師')->select(AdminUser::pluck('name','id'));
            });
        }else{
            $grid->filter(function($filter){
                $filter->like('name', '名前');
                $filter->equal('classroom', '所属教室')->select(['東伏見教室' => '東伏見教室', '玉川上水教室' => '玉川上水教室', '小川駅前教室' => '小川駅前教室', '鷹の台教室' => '鷹の台教室']);
            });
        }
		
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
        $show = new Show(Player::findOrFail($id));

        $show->id('Id');
        $show->name('名前');
        $show->furikana('ふりがな');
        $show->sex('性別');
        $show->bithday('生年月日');
        $show->classroom('所属教室');
        $show->teacher_id('講師')->as(function ($tid) {
            $ttcr= AdminUser::findOrFail($tid);
            return $ttcr->name;
        });
        //$show->enabled('有効');
        $show->enabled('有効')->as(function ($released) {
            return $released ? '有効' : '無効';
        });
        $show->comment('コメント');
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
        $form = new Form(new Player);

        $form->text('name', '名前')->rules('required');
        $form->text('furikana','ふりがな')->rules('required');       
        $states2 = [
            'on' => ['value'=>'男', 'text'=>'男','color' => 'success'],
            'off' => ['value'=>'女', 'text'=>'女','color' => 'danger'],
        ];
        $form->switch('sex', '性別')->states($states2)->default('女');  
        $form->date('birthday', '生年月日')->default(date('Y-m-d'));
        $form->select('classroom', '所属教室')->options(['東伏見教室' => '東伏見教室', '玉川上水教室' => '玉川上水教室', '小川駅前教室' => '小川駅前教室', '鷹の台教室' => '鷹の台教室']);
        if(Admin::user()->roles[0]['slug']=="administrator") {
			$form->select('teacher_id', '講師')->options(
				AdminUser::pluck('name', 'id')
			)->rules('required');
		}else{
			$form->select('teacher_id', '講師')->options(
				AdminUser::where('id', Admin::user()->id)->pluck('name', 'id')
			)->rules('required');
		}
		//$form->number('enabled', 'Enabled');
        $states = [
            'on' => ['value'=>1, 'text'=>'有効'],
            'off' => ['value'=>0, 'text'=>'無効'],
        ];
        $form->switch('enabled', '有効')->states($states)->default(1);
        $form->text('comment', 'コメント');

        return $form;
    }
}
