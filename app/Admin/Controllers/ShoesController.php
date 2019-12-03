<?php

namespace App\Admin\Controllers;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ShoesController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
//    protected $arr = Asset::clothes;

    protected $commName = 'Shoes';
    protected $str = 'shoes';

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
        $grid = new Grid(new Asset);
        $grid->model()->whereType($this->str)->orderBy('id', 'desc');
        $grid->id('Id');
        $grid->name('名字');
        $grid->pic('图片');
        $grid->mold('所属')->using(Asset::$molds);
        $grid->type('类型');
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
        $show = new Show(Asset::findOrFail($id));

        $show->id('Id');
        $show->name('名字');
        $show->pic('图片');
        $show->mold('所属');
        $show->type('类型');
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
        $form = new Form(new Asset);

        $form->text('name', '名字');
        $form->image('pic', '图片');
        $form->select('mold', '所属')->options(Asset::$type[$this->str]);
        $form->hidden('type', '类型')->value($this->str);

        return $form;
    }
}
