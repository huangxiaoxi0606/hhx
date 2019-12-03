<?php

namespace App\Admin\Controllers;

use App\Models\HhxConcert;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class HhxConcertController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = 'HhxConcert';

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
        $grid = new Grid(new HhxConcert);

        $grid->id('Id');
        $grid->name('演唱会名字');
        $grid->pic('票根')->image();
        $grid->singer('歌手');
        $grid->money('金额');
        $grid->show_time('演出时间');
        $grid->city('城市');
        $grid->addr('演出地址');
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
        $show = new Show(HhxConcert::findOrFail($id));

        $show->id('Id');
        $show->name('演唱会名字');
        $show->pic('票根');
        $show->singer('歌手');
        $show->money('金额');
        $show->show_time('演出时间');
        $show->city('城市');
        $show->addr('演出地址');
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
        $form = new Form(new HhxConcert);

        $form->text('name', '演唱会名字');
        $form->image('pic', '票根');
        $form->text('singer', '歌手');
        $form->decimal('money', '金额');
        $form->datetime('show_time', '演出时间')->default(date('Y-m-d H:i:s'));
        $form->text('city', '城市');
        $form->text('addr', '演出地址');

        return $form;
    }
}
