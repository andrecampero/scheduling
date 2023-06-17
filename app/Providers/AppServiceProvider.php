<?php

namespace App\Providers;

use App\Models\ScMenu;
use App\Models\ScPerfil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(255);
        try {
            view()->composer('*', function () {
                if (Auth::check()) {
                    $user = Auth::user();
                    $profile = ScPerfil::find($user->id_perfil);
                    $ids = $this->returnMenus($profile);
                    $menus = ScMenu::with(array('submenus' => function ($query) use ($ids) {
                        $query->wherein('id', $ids['sub_menus']);
                    }))
                        ->wherein('id', $ids['menus'])
                        ->orderBy('item_order')->get();
                    
                    View::share('menus', $menus);
                }
            });
        } catch (\Exception $e) {
            dd('ok');
            View::share('menus', array());
            View::share('submenus', array());
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function returnMenus($profile)
    {
        $menus = ScMenu::all();
        $dados = json_decode($profile->permissao, true);
        $menus = array_keys($dados);
        $sub_menus = array();
        
        for ($i = 1; $i <= count($menus); $i++) {
            if (array_key_exists($i, $dados)) {
                foreach ($dados[$i] as $key => $item) {
                    $sub_menus[] = $item;
                }
            }
        }
        $ret['menus'] = $menus;
        $ret['sub_menus'] = $sub_menus;
        return $ret;
    }
}
