<?php

    function route_class()
    {
        return str_replace('.', '-', \Illuminate\Support\Facades\Route::currentRouteName());
    }

    //根据分类id active样式
    function category_nav_active($category_id){

        return active_class((if_route('categories.show') &&
            if_route_param('category', $category_id)));
    }
