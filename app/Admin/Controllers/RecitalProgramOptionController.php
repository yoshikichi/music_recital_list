<?php

namespace App\Admin\Controllers;

use App\RecitalProgramOptions;
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

class RecitalProgramOptionController extends Controller
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
            ->header('Index')
            ->description('description')
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
        $grid = new Grid(new RecitalProgramOptions);

        $grid->id('Id');
        $grid->recital_program_music_id('Recital program music id');
        $grid->recital_id('Recital id');
        $grid->Recital()->name('発表会')->sortable();
        $grid->admin_user_id('Admin user id');
        $grid->AdminUser()->name('講師')->sortable();
        $grid->player_id('Player id');
        $grid->Player()->name('発表者')->sortable();
        $grid->age('Age');
        $grid->school_year('School year');
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
        $show = new Show(RecitalProgramOptions::findOrFail($id));

        $show->id('Id');
        $show->recital_program_music_id('Recital program music id');
        $show->recital_id('Recital id');
        $show->admin_user_id('Admin user id');
        $show->player_id('Player id');
        $show->age('Age');
        $show->school_year('School year');
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
        $form = new Form(new RecitalProgramOptions);

        $form->number('recital_program_music_id', 'Recital program music id');
        $form->number('recital_id', 'Recital id');
        $form->number('admin_user_id', 'Admin user id');
        $form->number('player_id', 'Player id');
        $form->text('age', 'Age');
        $form->text('school_year', 'School year');
        $form->text('chair_hight', 'Chair hight');
        $form->text('foot_hight', 'Foot hight');
        $form->text('pedal_hight', 'Pedal hight');
        $form->text('stand_hight', 'Stand hight');
        $form->text('subplayer_chair', 'Subplayer chair');
        $form->text('paging_chair', 'Paging chair');
        $form->text('remark', 'Remark');
        $form->text('comment', 'Comment');
        $form->number('enabled', 'Enabled');
        $form->number('looked', 'Looked');
        $form->text('comment1', 'Comment1');
        $form->text('comment2', 'Comment2');
        $form->text('comment3', 'Comment3');

        return $form;
    }
}
