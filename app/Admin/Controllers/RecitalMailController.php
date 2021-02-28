<?php

namespace App\Admin\Controllers;

use App\AdminUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\HasResourceActions;
//use Encore\Admin\Form;
//use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
//use Encore\Admin\Show;
use Request;

class RecitalMailController extends Controller
{
    use HasResourceActions;

    public function __construct(AdminUser $adminuser)
    {
		$this->adminuser = $adminuser;
    }
	
	
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {
            $content->header('メール送信');
            $content->description('　');
            $arrRec=0;
			$admid=0;
			$adminusers = AdminUser::select('id','name', 'email')->get()->toArray();
            $content->body($this->dummy("","未選択",$arrRec,$admid,$adminusers));
        });
    }

	protected function dummy($tablename,$dataname,$arrRec,$admid,$adminusers)
    {
		return view('Adminmail.recitalmail', [
            'tablename' => $tablename,
            'dataname' => $dataname,
			'records' => $arrRec,
			'admid'=> $admid,
			'adminusers' => $adminusers
        ]);
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
        $grid = new Grid(new AdminUser);

        $grid->id('Id');
        $grid->username('Username');
        $grid->password('Password');
        $grid->name('Name');
        $grid->avatar('Avatar');
        $grid->remember_token('Remember token');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->email('Email');

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
        $show = new Show(AdminUser::findOrFail($id));

        $show->id('Id');
        $show->username('Username');
        $show->password('Password');
        $show->name('Name');
        $show->avatar('Avatar');
        $show->remember_token('Remember token');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->email('Email');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdminUser);

        $form->text('username', 'Username');
        $form->password('password', 'Password');
        $form->text('name', 'Name');
        $form->image('avatar', 'Avatar');
        $form->text('remember_token', 'Remember token');
        $form->email('email', 'Email')->default(' ');

        return $form;
    }
}
