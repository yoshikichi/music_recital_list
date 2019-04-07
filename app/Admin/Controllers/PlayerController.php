<?php

namespace App\Admin\Controllers;

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
            ->header('発表者')
            ->description('発表者を登録編集できます。')
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
            ->description('発表者の編集ができます。')
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
            ->description('発表者の登録ができます。')
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

        $grid->id('Id');
        $grid->name('名前');
        $grid->sex('性別');
        $grid->teacher_id('講師');
        $grid->enabled('有効');
        $grid->comment('コメント');
        $grid->created_at('登録');
        $grid->updated_at('更新');

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
        $show->sex('性別');
        $show->teacher_id('講師');
        $show->enabled('有効');
        $show->comment('コメント');
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
        $form = new Form(new Player);

        $form->text('name', '名前');
        $form->text('sex', '性別');
        $form->select('teacher_id', '講師')->options(
            AdminUser::pluck('name', 'id')
        );
        $form->number('enabled', '有効');
        $form->text('comment', 'コメント');

        return $form;
    }
}
