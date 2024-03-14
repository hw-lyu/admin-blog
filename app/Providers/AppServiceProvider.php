<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Models\BlogMenu;
use App\Models\BlogInformation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 메타 데이터
        $defaultData = $this->defaultData();

        View::share($defaultData);
    }

    /**
     * default.blade 메타 데이터
     *
     * @return array
     */
    public function defaultData(): array
    {
        /**
         * 블로그 인포메이션
         */
        $blogInfo = BlogInformation::latest()->first() ?? [
            'nick_name' => '',
            'name' => '',
            'introduce' => '',
            'name_eng' => ''
        ];

        /*
         * 블로그 메뉴
         * */
        $blogMenu = BlogMenu::selectRaw('id, name, name_eng, is_blind, sort')
            ->where('is_blind', 1)
            ->orderBy('sort', 'asc')
            ->get()
            ->toArray() ?? [
            'id' => '',
            'name' => '',
            'is_blind' => '',
            'sort' => ''
        ];

        /*
         * 메타태그 기본값
         * */
        $title = trim(mb_substr($blogInfo['name'], 0, 25, 'utf-8')) . '...';
        $introduce = trim(mb_substr($blogInfo['introduce'], 0, 25, 'utf-8')) . '...';
        $url = Request()->url();

        return [
            'blogInfo' => $blogInfo,
            'blogMenu' => $blogMenu,
            'meta' => [
                'title' => $title,
                'introduce' => $introduce,
                'url' => $url
            ]
        ];
    }
}
