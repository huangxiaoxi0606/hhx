<?php

namespace App\Admin\Controllers;

use App\Models\Have;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class HaveController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = 'Have';

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
        $grid = new Grid(new Have);

        $grid->id('Id');
        $grid->name('名字');
        $grid->intro('简述');
        $grid->pic('图片')->image();
        $grid->year('年');
        $grid->mold('Mold');
        $grid->type('Type');
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
        $show = new Show(Have::findOrFail($id));

        $show->id('Id');
        $show->name('名字');
        $show->intro('简述');
        $show->pic('图片')->image();
        $show->year('年');
        $show->mold('Mold');
        $show->type('Type');
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
        $form = new Form(new Have);

        $form->text('name', '名字');
        $form->text('intro', '简述');
        $form->image('pic', '图片');
        $form->text('year', '年');
        $form->number('mold', 'Mold');
        $form->number('type', 'Type');

        return $form;
    }
}
