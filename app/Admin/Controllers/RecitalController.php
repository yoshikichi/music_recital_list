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
            ->header('発表会マスター')
            ->description('発表会マスターを管理します')
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
            ->header('Detail')
            ->description('description')
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
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
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

        $grid->id('Id');
        $grid->name('発表会名');
        $grid->planeddate('開催日');
        $grid->enabled('有効');
        $grid->looked('ロック');
        $grid->comment1('コメント1');
        $grid->comment2('コメント2');
        $grid->comment3('コメント3');
        $grid->created_at('登録日');
        $grid->updated_at('更新日');

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
        $show->enabled('有効');
        $show->looked('ロック');
        $show->comment1('コメント1');
        $show->comment2('コメント2');
        $show->comment3('コメント3');
        $show->created_at('登録日');
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

        $form->text('name', '発表会名');
        $form->date('planeddate', '開催日')->default(date('Y-m-d'));
        $form->number('enabled', '有効');
        $form->number('looked', 'ロック');
        $form->text('comment1', 'コメント1');
        $form->text('comment2', 'コメント2');
        $form->text('comment3', 'コメント3');

        return $form;
    }
}
