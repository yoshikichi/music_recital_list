<?php

namespace App\Admin\Controllers;

use App\Musictitle;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;
use App\AdminUser;
use Encore\Admin\Facades\Admin;

class MusictitleController extends Controller
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
            ->header('楽曲登録')
            ->description('楽曲登録リスト')
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
            ->description('楽曲登録')
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
            ->description('楽曲登録')
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
            ->description('楽曲登録')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Musictitle);

        $grid->id('Id')->sortable();
        $grid->title('曲名')->sortable();
        $grid->title_furikana('フリカナ')->sortable();
        $grid->composer('作曲者')->sortable();
        $grid->composer_furikana('フリカナ')->sortable();
        $grid->enabled('有効')->display(function ($enbl) {
            return $enbl?'有効':'無効';
        })->sortable()->sortable();
        $grid->created_at('作成日')->sortable();
        $grid->updated_at('更新日')->sortable();
        $grid->disableRowSelector();
	$grid->actions(function ($actions) {
                if(Admin::user()->roles[0]['slug']!="administrator") {
                        $actions->disableDelete();
                        $actions->disableEdit();
                        $actions->disableView();
                }
        });
        $grid->model()->orderBy('composer_furikana')->orderBy('title_furikana');
        $grid->filter(function($filter){
            $filter->like('title', '曲名');
            $filter->like('composer', '作曲者');
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
        $show = new Show(Musictitle::findOrFail($id));

        $show->id('Id');
        $show->title('曲名');
        $show->title_furikana('フリカナ');
        $show->composer('作曲者');
        $show->composer_furikana('フリカナ');
        $show->enabled('有効')->as(function ($released) {
            return $released ? '有効' : '無効';
        });
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
        $form = new Form(new Musictitle);

        $form->text('title', '曲名')->rules('required');
        $form->text('title_furikana', 'フリカナ')->rules('required');
        $form->text('composer', '作曲者')->rules('required');
        $form->text('composer_furikana', 'フリカナ')->rules('required');
		
        if(Admin::user()->roles[0]['slug']!="administrator") {
                $form->hidden('enabled')->default(1); //有効
        }else{
                $states = [
                        'on' => ['value'=>1, 'text'=>'有効'],
                        'off' => ['value'=>0, 'text'=>'無効'],
                        ];
                $form->switch('enabled', '有効')->states($states);
        }
	 
        $form->saving(function ($form) {
            $mtid = $form->model()->id;  //UpdateかInsertか判別に使う
            $ttl = $form->title;
            $cmp = $form->composer;
            $cnt = Musictitle::where('title',$ttl)->where('composer',$cmp)->count();
            
            if($cnt>0 && $mtid==null){
                $success = new MessageBag([
                    'title'   => 'エラー',
                    'message' => $ttl.'  '.$cmp.'は既に登録されています。',
                ]);

                return back()->with(compact('success'));                
            }

        });
        
        $form->saved(function (Form $form) {
//            $form->model()->id;
//            $success = new MessageBag([
//                'title'   => 'title...',
//                'message' => 'message....',
//            ]);
//
//            return back()->with(compact('success'));
         });

        return $form;
    }
}
