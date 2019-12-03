<?php

namespace App\Admin\Controllers;

use App\Models\DirectionLog;
use App\Models\HhxTravil;
use App\Models\TravilBill;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Log;

class TravilBillController extends Controller
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
        $grid = new Grid(new TravilBill);

        $grid->id('Id');
        $grid->direction_id('方向Id')->display(function ($direction_id) {
            return DirectionLog::whereId($direction_id)->value('illustration');
        });
        $grid->column('金额')->display(function () {
            return DirectionLog::whereId($this->direction_id)->value('money');
        });
        $grid->hhx_travil_id('旅行')->display(function ($hhx_travil_id) {
            return HhxTravil::whereId($hhx_travil_id)->value('name');
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
        $show = new Show(TravilBill::findOrFail($id));

        $show->id('Id');
        $show->direction_id('方向Id')->display(function ($direction_id) {
            $data = DirectionLog::whereId($direction_id)->value('illustration');
            return $data;
        });
        $show->hhx_travil_id('旅行id');
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
        $form = new Form(new TravilBill);
        $data1 = DirectionLog::getIllustration();
        $data1[0] = 0;
        $form->select('direction_id', 'Direction id')->options($data1)->default(key($data1));
        $form->select('hhx_travil_id', 'Hhx travil id')->options(HhxTravil::getName());
        $form->saving(function ($form) {
            $form->flag = 0;
            if ($form->model()->id) {
                $form->flag = 1;
            }
        });
        return $form;
    }
}
