<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/10/16
 * Time : 12:06
 */

namespace App\Http\Controllers;

use App\Models\Daily;
use App\Models\Direction;
use App\Models\DirectionLog;
use App\Models\InterestLog;
use Illuminate\Support\Facades\Log;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
//        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

//        $app = app('wechat.official_account');
//        $app->server->push(function ($message) use ($app) {
//            switch ($message['MsgType']) {
//                case 'event':
//                    if ($message['Event'] == 'subscribe') {
//                        return '感谢您关注一个足够无聊的公众号';
//                    }
//                    return '收到事件消息';
//                    break;
//                case 'text':
//                    if ($message['FromUserName'] == 'oUCgBwP5gOn79QGN60Fb9GS19kwk') {
//                        if (strpos($message['Content'], '记账') !== false) {
//                            return DirectionLog::parseContent($message['Content']);
//                        }
//                        if (strpos($message['Content'], '兴趣') !== false) {
//                            return InterestLog::parseContent($message['Content']);
//                        }
//                        if ($message['Content'] == '账例') {
//                            return "记账,direction_id,daily_id,status,'说明','笔记',金额,周几";
//                            break;
//                        }
//                        if ($message['Content'] == '兴例') {
//                            return "兴趣,interest_id,daily_id,'说明'周几";
//                            break;
//                        }
//                        if ($message['Content'] == 'daily_id') {
//                            return Daily::query()->max('id');
//                            break;
//                        }
//                        if ($message['Content'] == 'interest_id') {
//                            return "1.hebe,2.旅行,3.摄影,4.咖啡,5.音乐,6.看书,7.电影,8.书法,9.酒,10.滑板,11.跑步,12.英语,13.健身,15.paint";
//                            break;
//                        }
//                        if ($message['Content'] == 'direction_id') {
//                            return "1.love,2.shop,3.product,4.food,5.study,6.travil,7.family,8.coffee,9.extra";
//                            break;
//                        }
//                        if ($message['Content'] == 'daily') {
//                            //发送图文消息
//                            $items = [
//                                new NewsItem([
//                                    'title' => 'daily【' . date('Y-m-d') . '】',
//                                    'description' => 'hhx06',
//                                    'url' => 'http://35.220.222.161/daily',
//                                ]),
//                            ];
//                            return new News($items);
//                            break;
//                        }
//                    }
//                    return '已经收到您的消息,可惜我并不会回复您的。';
//                    break;
//                case 'image':
//                    return '您的图片,我已经收到,但是 我是不会看的';
//                    break;
//                case 'voice':
//                    return '您说了什么,风太大我听不清楚';
//                    break;
//                case 'video':
//                    return '视频,您都敢发 我很佩服';
//                    break;
//                case 'location':
//                    return '位置信息已经收到,然后呢';
//                    break;
//                case 'link':
//                    return '该链接已经失效';
//                    break;
//                case 'file':
//                    return '文件太大,读取失败';
//                // ... 其它消息
//                default:
//                    return '今天天气晴';
//                    break;
//            }
//        });
//
//        return $app->server->serve();

        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            return "欢迎关注 overtrue！";
        });

        return $app->server->serve();
    }



//    public function getOpenId(){
//        $user = $app->user->get($openId);
//    }
}
