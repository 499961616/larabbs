<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function scopeWithOrder($query,$order)
    {
        //根据不同排序 使用不同语句查询
        switch ($order){
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
        }
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at','desc');

    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('created_at','desc');
    }

    //话题的链接生成
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
