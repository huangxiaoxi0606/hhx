<?php

namespace App\Admin\Controllers;

use App\Models\Daily;
use App\Models\DirectionLog;
use App\Models\HhxTravel;
use App\Models\TravelTraffic;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TravelTrafficController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = '旅行交通';

    public function index(Content $content)
    {
        return $content
            ->header($this->commName)
            ->description('列表')
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
            ->header($this->commName)
            ->description('详情')
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
            ->header($this->commName)
            ->description('编辑')
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
            ->header($this->commName)
            ->description('创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TravelTraffic);

        $grid->id('Id');
        $grid->img('图片')->image();
        $grid->name('名字');
        $grid->illustrate('说明');
        $grid->money('金额');
        $grid->ok('Ok')->using([0 => '0k', 2 => 'bad']);
        $grid->travel_at('旅行时间');
        $grid->status('状态')->select([0 => '未出发', 1 => '已出发']);
        $grid->hhx_travel_id('旅行Id')->display(function ($hhx_travel_id) {
            return HhxTravel::where('id', $hhx_travel_id)->value('name');
        });
        $grid->created_at('创建时间');
        $grid->model()->where('status', 0);
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
        $show = new Show(TravelTraffic::findOrFail($id));

        $show->id('Id');
        $show->img('图片');
        $show->name('名字');
        $show->illustrate('说明');
        $show->money('金额');
        $show->ok('Ok')->using([0 => '0k', 2 => 'bad']);
        $show->travel_at('旅行时间');
        $show->status('状态')->using([0 => '未出发', 1 => '已出发']);
        $show->direction_id('Direction id');
        $show->daily_id('Daily id');
        $show->hhx_travel_id('Hhx travel id');
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
        $form = new Form(new TravelTraffic);

        $form->image('img', '图片')->move('travel/img');
        $form->text('name', '名字');
        $form->text('illustrate', '说明');
        $form->decimal('money', '金额')->default(0.00);
        $form->select('ok', 'Ok')->options([0 => '0k', 2 => 'bad'])->default(0);
        $form->date('travel_at', '出发时间')->default(date('Y-m-d'));
        $form->select('status', '状态')->options([0 => '未出发', 1 => '已出发'])->default(0);
        $data1 = DirectionLog::getIllustration();
        $data1[0] = 0;
        $form->select('direction_id', '方向LogId')->options($data1)->default(key($data1));
        $data = Daily::getTimeDay();
        $data[0] = 0;
        $form->select('daily_id', '日常Id')->options($data)->default(key($data));
        $form->select('hhx_travel_id', 'Hhx旅行Id')->options(HhxTravel::getName());
        return $form;
    }
}
