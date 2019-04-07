<?php

namespace App\Admin\Controllers;

use App\Musictitle;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

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
            ->header('楽曲マスター')
            ->description('楽曲マスターリスト')
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
            ->header('編集')
            ->description('楽曲マスターを編集します')
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
            ->header('楽曲新規登録')
            ->description('楽曲マスターに新規登録できます')
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

        $grid->id('Id');
        $grid->title('曲名');
        $grid->composer('作曲者');
        $grid->enabled('有効');
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
        $show = new Show(Musictitle::findOrFail($id));

        $show->id('Id');
        $show->title('曲名');
        $show->composer('作曲者');
        $show->enabled('有効');
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
        $form = new Form(new Musictitle);

        $form->text('title', '曲名');
        $form->text('composer', '作曲者');
        $form->number('enabled', '有効');

        return $form;
    }
}
