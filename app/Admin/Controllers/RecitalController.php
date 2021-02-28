<?php

namespace App\Admin\Controllers;

use App\Recital;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RecitalController extends Controller
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
            ->header('発表会')
            ->description('発表会を管理します')
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
            ->description('発表会管理')
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
            ->description('発表会管理')
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
            ->description('発表会管理')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Recital);

        $grid->id('Id')->sortable();
        $grid->name('発表会名')->sortable();
        $grid->planeddate('開催日')->sortable();
        //$show->enabled('有効');
        $states = [
            'on'  => ['value' => 1, 'text' => '有効', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '無効', 'color' => 'default'],
        ];
        $grid->enabled('有効')->switch($states);
        //$show->looked('ロック');
        $states2 = [
            'on'  => ['value' => 1, 'text' => '許可', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => 'ロック', 'color' => 'default'],
        ];
        $grid->looked('ロック')->switch($states2);   
        $grid->comment1('コメント1');
        $grid->comment2('コメント2');
        $grid->comment3('コメント3');
        $grid->created_at('作成日')->sortable();
        $grid->updated_at('更新日')->sortable();
		$grid->disableRowSelector();
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
        $show = new Show(Recital::findOrFail($id));

        $show->id('Id');
        $show->name('発表会名');
        $show->planeddate('開催日');
        //$show->enabled('有効');
        $show->enabled('有効')->as(function ($released) {
            return $released ? '有効' : '無効';
        });
        //$show->looked('ロック');
        $show->looked('ロック')->as(function ($released) {
            return $released ? '許可' : 'ロック';
        });      
        $show->comment1('コメント1');
        $show->comment2('コメント2');
        $show->comment3('コメント3');
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
        $form = new Form(new Recital);

        $form->text('name', '発表会名')->rules('required');
        $form->date('planeddate', '開催日')->default(date('Y-m-d'))->rules('required');
        //$form->number('enabled', 'Enabled');
                $states = [
                    'on' => ['value'=>1, 'text'=>'有効'],
                    'off' => ['value'=>0, 'text'=>'無効'],
                ];
                $form->switch('enabled', '有効')->states($states);
        //$form->number('looked', 'Looked');
                $states2 = [
                    'on' => ['value'=>1, 'text'=>'許可'],
                    'off' => ['value'=>0, 'text'=>'ロック'],
                ];
                $form->switch('looked', '許可')->states($states2);
        $form->text('comment1', 'コメント1');
        $form->text('comment2', 'コメント2');
        $form->text('comment3', 'コメント3');

        return $form;
    }
}
