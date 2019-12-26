<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\SyncWeibo;
use App\Admin\Extensions\WeiboExporter;
use App\Handlers\WeiboHandler;
use App\Models\Weibo;
use App\Http\Controllers\Controller;
use App\Models\WeiboPics;
use App\Models\WeiboUser;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class WbBaseController extends Controller
{
    use HasResourceActions;
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $fileName;
    protected $wei_id;

    public function index(Content $content)
    {
        return $content
            ->header($this->fileName)
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
            ->header($this->fileName)
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
            ->header($this->fileName)
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
            ->header($this->fileName)
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
        $grid = new Grid(new Weibo);
        $grid->header(function ($query) {
            $field = ['screen_name', 'description', 'avatar_hd'];
            $user = WeiboUser::where('weibo_id', $this->wei_id)->select($field)->first()->toArray();
            return '
                    <div class="hhx1" style="width: 50%;float: left">
                        <p class="text-warning daily-text">' . $user["screen_name"] . '</p>
                        <p class="text-success daily-text">' . $user["description"] . '</p>
                    </div>
                    <div class ="hhx" style="float: left">
                        <img src="' . config('hhx.qny.url') . $user["avatar_hd"] . '" class="img-rounded" style="width:20%;">
                    </div>';
        });
        $grid->id('Id');
        $grid->screen_name('微博用户名');
        $grid->column('text')->display(function () {
            return $this->text;
        });
        $grid->thumbnail_pic('缩略图')->image();

        $grid->pic_num('pic_num')->modal('多图', function ($model) {
            $base_url = config('hhx.qny.url');
            if ($model->pic_num > 1) {
                unset($data_u);
                $num = 0;
                $pics = WeiboPics::where('weibo_info_id', $model->weibo_info_id)->select('url')->get();
                foreach ($pics as $pic) {
                    $num++;
                    $data_u[$num] = '<img src=" ' .$base_url.'/' . $pic->url . '">';
                }
            } elseif ($model->pic_num == 1) {
                $data_u['1'] = '<img src=" ' .$base_url .$model->thumbnail_pic . '">';
            } else {
                $data_u['pic'] = '一张图片都没有';
            }
            return new Table(['key', 'value'], $data_u);
        });
        $grid->source('来源');
        $grid->weibo_created_at('Weibo发布时间');
        $grid->comments_count('评论个数');
        $grid->attitudes_count('点赞个数');
        $grid->reposts_count('转发个数');
        $grid->column('repost_id')->expand(function ($model) {
            if ($model->repost_id) {
                $weibo = Weibo::where('id', $model->repost_id)->first();
                if ($weibo) {
                    $weibo = $weibo->toArray();
                    $wb = [
                        'id' => $weibo['id'],
                        'weibo用户名' => $weibo['screen_name'],
                        'text' => $weibo['text'],
                        'weibo_created_at' => $weibo['weibo_created_at'],
                        'comments_count' => $weibo['comments_count'],
                        'attitudes_count' => $weibo['attitudes_count'],
                        'reposts_count' => $weibo['reposts_count'],
                    ];
                } else {
                    $wb['data'] = '数据被误删除';
                }

                return new Table(['key', 'value'], $wb);
            }
        });
        if ($this->wei_id) {
            $grid->model()->where('weibo_id', $this->wei_id);
        }
        $grid->model()->where('is_flag', 0)->orderBy('weibo_created_at', 'desc');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->exporter(new WeiboExporter());


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
        $show = new Show(Weibo::findOrFail($id));

        $show->id('Id');
        $show->screen_name('微博用户名');
        $show->text('text')->unescape();
        $show->thumbnail_pic('缩略图')->image();
        $show->original_pic('pic')->image();
        $show->source('来源');
        $show->weibo_created_at('Weibo发布时间');
        $show->comments_count('评论个数');
        $show->attitudes_count('点赞个数');
        $show->reposts_count('转发个数');
        $show->scheme('微博链接');
        $show->is_flag('是否转发')->using([0 => '原创', 1 => '转发']);
        $show->repost_id('转发的 id');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }


}
