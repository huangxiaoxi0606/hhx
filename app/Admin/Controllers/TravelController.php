<?php

namespace App\Admin\Controllers;

use App\Models\Travel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TravelController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $headName = '携程游记热门推荐';

    public function index(Content $content)
    {
        return $content
            ->header($this->headName)
            ->description('description')
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
            ->header($this->headName)
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
            ->header($this->headName)
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
            ->header($this->headName)
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
        $grid = new Grid(new Travel);

        $grid->id('Id');
        $grid->Author('Author');
        $grid->CommentNumber('CommentNumber');
        $grid->Content('Content');
//        $grid->Img('Img')->image();
        $grid->Name('Name');
        $grid->PublishDate('PublishDate');
        $grid->PictureNumber('PictureNumber');
        $grid->TravelId('TravelId');
        $grid->ViewNumber('ViewNumber');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();

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
        $show = new Show(Travel::findOrFail($id));

        $show->id('Id');
        $show->Author('Author');
        $show->CommentNumber('CommentNumber');
        $show->Content('Content');
        $show->Img('Img');
        $show->Name('Name');
        $show->PublishDate('PublishDate');
        $show->PictureNumber('PictureNumber');
        $show->TravelId('TravelId');
        $show->ViewNumber('ViewNumber');
        $show->Url('Url');
        $show->text('Text');
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
        $form = new Form(new Travel);

        $form->text('Author', 'Author');
        $form->number('CommentNumber', 'CommentNumber');
        $form->text('Content', 'Content');
        $form->image('Img', 'Img');
        $form->text('Name', 'Name');
        $form->text('PublishDate', 'PublishDate');
        $form->number('PictureNumber', 'PictureNumber');
        $form->number('TravelId', 'TravelId');
        $form->number('ViewNumber', 'ViewNumber');
        $form->url('Url', 'Url');
        $form->textarea('text', 'Text');
        return $form;
    }
}
