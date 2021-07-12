<?php


namespace App\Handlers;


use Illuminate\Support\Str;
use Image;

class ImageUploadHandler
{

    //允许上传的图片格式
    protected  $allowed_ext = ['png','jpg','jpeg','gif'];

    public function save($file,$folder,$file_prefix,$max_width = false)
    {
        $folder_name = "uploads/images/$folder".date('Ym/d',time());

        $upload_path = public_path().'/'.$folder_name;

        $extension = strtolower($file->getClientOriginalExtension()) ? :'png';

        $filename = $file_prefix .'_'.time() .'_'.Str::random(10).'.'.$extension;


        if (!in_array($extension,$this->allowed_ext)){
            return false;
        }

        //将图片移动到目标目录
        $file->move($upload_path,$filename);

        if ($max_width && $extension !='gif'){

            $this->reduceSize($upload_path.'/'.$filename,$max_width);
        }

        return [
            'path'=>config('app.url')."/$folder_name/$filename"
        ];
    }

    public function reduceSize($file_path,$max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        $image->resize($max_width,null,function ($constraint){

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
            // 对图片修改后进行保存
            $image->save();
    }
}
