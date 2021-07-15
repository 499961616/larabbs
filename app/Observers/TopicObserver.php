<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{


    public function saving(Topic $topic)
    {
        //防止xxs攻击  进行过滤
        $topic->body = clean($topic->body,'user_topic_body');

        //话题摘录
        $topic->excerpt = make_excerpt($topic->body);

    }

    public function saved(Topic $topic)
    {
        //slug字段没内容，则使用翻译器 对提提了进行翻译
        if (!$topic->slug){

            //推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }




}
