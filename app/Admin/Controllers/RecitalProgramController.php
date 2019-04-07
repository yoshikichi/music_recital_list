<?php

namespace App\Admin\Controllers;

use App\RecitalProgram;
use App\Recital;
use App\Player;
use App\AdminUser;
use App\Musictitle;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RecitalProgramController extends Controller
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
            ->header('プログラム一覧')
            ->description('プログラムを閲覧・編集可能です')
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
            ->description('編集できます')
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
            ->header('新規登録')
            ->description('新規登録します')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RecitalProgram);

        $grid->id('Id');
        $grid->recital_id('Recital id');
        $grid->teacher_id('Teacher id');
        $grid->player_id('Player id');
        $grid->age('Age');
        $grid->school_year('School year');
        $grid->music1()->pluck('title');
        $grid->column('music1.title', '曲名1');
        $grid->music2_id('Music2 id');
        $grid->music3_id('Music3 id');
        $grid->music4_id('Music4 id');
        $grid->music5_id('Music5 id');
        $grid->chair_hight('Chair hight');
        $grid->foot_hight('Foot hight');
        $grid->pedal_hight('Pedal hight');
        $grid->stand_hight('Stand hight');
        $grid->subplayer_chair('Subplayer chair');
        $grid->paging_chair('Paging chair');
        $grid->remark('Remark');
        $grid->comment('Comment');
        $grid->enabled('Enabled');
        $grid->looked('Looked');
        $grid->comment1('Comment1');
        $grid->comment2('Comment2');
        $grid->comment3('Comment3');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(RecitalProgram::findOrFail($id));

        $show->id('Id');
        $show->recital_id('Recital id');
        $show->teacher_id('Teacher id');
        $show->player_id('Player id');
        $show->age('Age');
        $show->school_year('School year');
        $show->music1_id('Music1 id');
        $show->music2_id('Music2 id');
        $show->music3_id('Music3 id');
        $show->music4_id('Music4 id');
        $show->music5_id('Music5 id');
        $show->chair_hight('Chair hight');
        $show->foot_hight('Foot hight');
        $show->pedal_hight('Pedal hight');
        $show->stand_hight('Stand hight');
        $show->subplayer_chair('Subplayer chair');
        $show->paging_chair('Paging chair');
        $show->remark('Remark');
        $show->comment('Comment');
        $show->enabled('Enabled');
        $show->looked('Looked');
        $show->comment1('Comment1');
        $show->comment2('Comment2');
        $show->comment3('Comment3');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RecitalProgram);

        $form->select('recital_id', '発表会名')->options(
            Recital::pluck('name', 'id')
        );
        $form->select('teacher_id', '講師')->options(
            AdminUser::pluck('name', 'id')
        );
        $form->select('player_id', '発表者')->options(
            Player::pluck('name', 'id')
        );
        $form->text('age', '年齢');
        $form->text('school_year', '学年');
        $form->select('music1_id', '曲名1')->options(
                Musictitle::pluck('title', 'id')
        );
        $form->select('music2_id', '曲名2')->options(
                Musictitle::pluck('title', 'id')
        );
        $form->select('music3_id', '曲名3')->options(
                Musictitle::pluck('title', 'id')
        );
        $form->select('music4_id', '曲名4')->options(
                Musictitle::pluck('title', 'id')
        );
        $form->select('music5_id', '曲名5')->options(
                Musictitle::pluck('title', 'id')
        );
        $form->text('chair_hight', '椅子の高さ');
        $form->text('foot_hight', '足台の高さ');
        $form->text('pedal_hight', 'ペダル台の高さ');
        $form->text('stand_hight', 'ピアノ譜面立て');
        $form->text('subplayer_chair', '連弾いす');
        $form->text('paging_chair', '譜めくり椅子');
        $form->text('remark', '特記事項');
        $form->text('comment', 'コメント');
        $form->number('enabled', '有効');
        $form->number('looked', 'ロック');
        $form->text('comment1', 'コメント1');
        $form->text('comment2', 'コメント2');
        $form->text('comment3', 'コメント3');

        return $form;
    }
}
