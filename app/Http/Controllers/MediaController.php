<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function DeleteMedia(Request $request)
    {
        $media = Media::find($request['media']['id']);

        $is_owner = $this->isOwner($request['media']['id']);

        if($is_owner){
            if(File::exists(storage_path('app/public/'.$media->path))){
                File::delete(storage_path('app/public/'.$media->path));
            }

            $media->delete();

            return [
                'status' => true
            ];
        }else{
            return [
                'status' => false
            ];
        }
    }

    public function isOwner($media_id)
    {
        $ref = MediaOwner::where('user_id',Auth::user()->id)->where('media_id',$media_id)->first();

        if($ref != null){
            return true;
        }else{
            return false;
        }
    }
}
