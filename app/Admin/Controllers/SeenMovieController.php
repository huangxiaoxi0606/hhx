<?php

namespace App\Admin\Controllers;

use App\Models\SeenMovie;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SeenMovieController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $comm = '已看电影';

    public function index(Content $content)
    {
        return $content
            ->header($this->comm)
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
            ->header('Detail')
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
            ->header('Edit')
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
            ->header('Create')
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
        $grid = new Grid(new SeenMovie);

        $grid->id('Id');
        $grid->name('Name');
        $grid->mold('Mold');
        $grid->money('Money');
        $grid->show_time('Show time');
        $grid->note('Note');
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
        $show = new Show(SeenMovie::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->mold('Mold');
        $show->money('Money');
        $show->show_time('Show time');
        $show->note('Note');
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
        $form = new Form(new SeenMovie);

        $form->text('name', 'Name');
        $form->number('mold', 'Mold');
        $form->decimal('money', 'Money')->default(0.00);
        $form->datetime('show_time', 'Show time')->default(date('Y-m-d H:i:s'));
        $form->text('note', 'Note');

        return $form;
    }
}
