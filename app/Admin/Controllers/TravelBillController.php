<?php

namespace App\Admin\Controllers;

use App\Models\DirectionLog;

use App\Models\HhxTravel;
use App\Models\TravelBill;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Log;

class TravelBillController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = '旅行账单';

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
        $grid = new Grid(new TravelBill);

        $grid->id('Id');
        $grid->direction_id('方向Id')->display(function ($direction_id) {
            return DirectionLog::whereId($direction_id)->value('illustration');
        });
        $grid->column('金额')->display(function () {
            return DirectionLog::whereId($this->direction_id)->value('money');
        });
        $grid->hhx_travel_id('旅行')->display(function ($hhx_travel_id) {
            return HhxTravel::whereId($hhx_travel_id)->value('name');
        });
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
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
        $show = new Show(TravelBill::findOrFail($id));

        $show->id('Id');
        $show->direction_id('方向Id')->display(function ($direction_id) {
            $data = DirectionLog::whereId($direction_id)->value('illustration');
            return $data;
        });
        $show->hhx_travel_id('旅行id');
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
        $form = new Form(new TravelBill);
        $data1 = DirectionLog::getIllustration();
        $data1[0] = 0;
        $form->select('direction_id', 'Direction id')->options($data1)->default(key($data1));
        $form->select('hhx_travel_id', 'Hhx travel id')->options(HhxTravel::getName());
        $form->saving(function ($form) {
            $form->flag = 0;
            if ($form->model()->id) {
                $form->flag = 1;
            }
        });
        return $form;
    }
}
