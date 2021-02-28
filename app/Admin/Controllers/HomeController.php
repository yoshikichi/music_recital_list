<?php

namespace App\Admin\Controllers;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('発表会プログラム作成')
            ->description('発表会の演奏曲を編集できます。')
            ->row(Dashboard::title())
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    //$column->append(Dashboard::environment());
                    $column->append(Admin::user()->id.":".Admin::user()->roles[0]['slug']);
                });

                $row->column(4, function (Column $column) {
                    //$column->append(Dashboard::extensions());
                    //$column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    //$column->append(Dashboard::dependencies());
                    $column->append("");
                });

            });
    }
}
