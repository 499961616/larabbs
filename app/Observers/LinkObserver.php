<?php

namespace App\Observers;


// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

use App\Models\Link;
use Illuminate\Support\Facades\Cache;

class LinkObserver
{
    // 在保存时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }

    public function deleted(Link $link)
    {
        $this->saved($link);
    }

}
