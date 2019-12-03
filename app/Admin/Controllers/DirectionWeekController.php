<?php

namespace App\Admin\Controllers;

use App\Handlers\DailyHandler;
use App\Models\Direction;
use App\Http\Controllers\Controller;
use App\Models\DirectionLog;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Encore\HhxEchart\HhxEchart;

class DirectionWeekController extends Controller
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
            ->header('本周账单')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Direction);
        $grid->name('Name');
        $week_again = date("Y-m-d", strtotime("this week"));
        $grid->id('本周')->display(function ($id) use ($week_again) {
            return DirectionLog::whereBetween('created_at', [$week_again, Carbon::now()])->where('direction_id', $id)->sum('money');
        });
        $grid->column('列表详情')->modal(function () use ($week_again) {
            $data = DirectionLog::whereBetween('created_at', [$week_again, Carbon::now()])->where('direction_id', $this->id)->select('illustration', 'money', 'created_at')->get()->toArray();
            return new Table(['说明', '金额', '创建时间'], $data);
        });
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();

        return $grid;
    }

    public function mouth(Content $content)
    {

        return $content
            ->header('本周账单')
            ->description('列表')
            ->body($this->table());
    }

    protected function table()
    {
        //获取个月的总和
        $data = DailyHandler::getMouth();

        $headers = ['Time', 'Love', 'Shop', 'Product', 'Food', 'Study', 'Trail', 'Family', 'Coffee', 'Extra'];
        $table = new Table($headers, $data);
        return $table;

    }


}
