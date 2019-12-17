<?php

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\HhxTravel;
use App\Models\TravelEquip;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TravelEquipController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = '旅行装备';

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
        $grid = new Grid(new TravelEquip);

        $grid->id('Id');
        $grid->name('名字');
        $grid->hhx_travel_id('旅行Id')->display(function ($hhx_travel_id) {
            return HhxTravel::where('id', $hhx_travel_id)->value('name');
        });
        $grid->status('状态')->select([0 => '购买', '1' => '已有', '2' => '需复查', '3' => '复查', '4' => '形成结束', '5' => '不带']);
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

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
        $show = new Show(TravelEquip::findOrFail($id));

        $show->id('Id');
        $show->name('名字');
        $show->hhx_travel_id('旅行Id');
        $show->status('状态')->using([0 => '购买', '1' => '已有', '2' => '需复查', '3' => '复查', '4' => '形成结束', '5' => '不带']);
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TravelEquip);

        $form->text('name', 'Name');
        $form->select('hhx_travel_id', 'Hhx travel id')->options(HhxTravel::getName());
        $form->select('status', 'Status')->options([0 => '购买', 1 => '已有', 2 => '需复查', 3 => '复查', 4 => '形成结束', 5 => '不带'])->default(1);

        return $form;
    }
}
