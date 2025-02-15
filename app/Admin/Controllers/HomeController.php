<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Linkbox;
use Dcat\Admin\Widgets\MediaList;
use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\ListGroup;
use Dcat\Admin\Widgets\InfoList;
use Dcat\Admin\Widgets\CoverCard;

class HomeController extends Controller
{
    public function index(Content $content)
    {

        $alert = Alert::make('<ul><li><code> Dcat-plus Admin </code> 是基于dcat-admin 的功能增强版，主要是加强两方面，加强灵活的布局; 丰富更多的页面组件。以及修正原有的一些问题。最终做成 汇聚Filament，Laravel-admin , Dcat-admin 优点于一身的基于Laravel + Bootstrap 的极速开发框架。</li><li>灵活的页面布局，丰富的页面组件，精细化的组件控制,多管理面板， 多应用开发场景支持。一键把Model自动生成crud，自带多种js插件,能为您的产品开发节省50%时间。</li><li>Dcatplus 官方 <a href="https://dcat-plus.saishiyun.net/">查看</a></li> <li>快速体验Dcatplus 可安装 [Dcatplus 示例大全] <code> composer require ycookies/dcatplus-demo</code>  <a class="copy" data-clipboard-text="composer require ycookies/dcatplus-demo" href="javascript:void(0);"><i class="feather icon-copy"></i></a></li><ul>','Dcat-plus Admin 特色');
                $content =  $content
                    ->header('Dcat-plus Admin')
                    ->description('只为习得《极速开发》神功，实现人身自由，工作自由，财务自由之路')
                    ->row($alert->info())
                    ->row(function (Row $row) {
                        $row->column(6, function (Column $column) {
                            $column->row(Dashboard::author());
                            $column->row(new Examples\Tickets());
                        });

                        $row->column(6, function (Column $column) {
                            $group = ListGroup::make();

                            // 获取已安装扩展包信息
                            $installedPackages = json_decode(file_get_contents(base_path('vendor/composer/installed.json')), true);

                            // 指定要获取版本号的扩展包名称
                            $packageName = 'dcat-plus/laravel-admin';

                            // 查找指定扩展包的版本号
                            $packageVersion = '--';
                            if(!empty($installedPackages['packages'])){
                                foreach ($installedPackages['packages'] as $package) {
                                    if ($package['name'] === $packageName) {
                                        $packageVersion = $package['version'];
                                        break;
                                    }
                                }
                            }
                            $group->add('Dcat-plus Admin  Version',  $packageVersion,'#');
                            $group->add('PHP Version',  phpversion(),'#');
                            $group->add('Laravel Version', app()->version(),'#');
                            $group->add('Dcat-plus Admin 下载次数', 896,'#');

                            //$group->add('这是第5个标题', '这是第5个');
                            $column->row($group->render());
                            $column->row(function (Row $row) {
                                $cover_card = CoverCard::make()->add('开源公众号','关注公众号 随时了解更新动态')
                                    ->bg('https://dcat-plus.saishiyun.net/img/card-bg1.jpeg')
                                    ->avatar('https://dcat-plus.saishiyun.net/img/wxgzh_qrcode.jpg');
                                $row->column(6, $cover_card->render());

                                $cover_card1 = CoverCard::make()->add('赞助捐助开源','鼓励作者持续更新')
                                    ->bg('https://dcat-plus.saishiyun.net/img/card-bg2.jpeg')
                                    ->avatar('https://dcat-plus.saishiyun.net/img/weixinpay.jpg');
                                $row->column(6, $cover_card1->render());

                                $row->column(6, new Examples\NewUsers());
                                $row->column(6, new Examples\NewDevices());
                            });

                            $column->row(new Examples\Sessions());
                            $column->row(new Examples\ProductOrders());
                        });
                    });

        return $content;
    }
}
