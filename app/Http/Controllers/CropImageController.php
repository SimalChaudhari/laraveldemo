<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting;

class CropImageController extends Controller
{
    public function uploadCropImage(Request $request)
    {
        // @see https://fengyuanchen.github.io/cropperjs/examples/minimum-and-maximum-cropped-dimensions.html
        $folderPath = public_path('images/');
 
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
 
        $imageName = uniqid() . '.png';
 
        $imageFullPath = $folderPath.$imageName;
 
        file_put_contents($imageFullPath, $image_base64);

        $setting = Setting::where( 'user_id', \Auth::user()->id )->first();
        if( $setting === null ) {
            $setting = new Setting();
        }

        $setting->user_id  = \Auth::user()->id;
        $setting->logo_path = $imageName;
        $setting->save();
    
        return response()->json([
            'success' => 'Crop Image Uploaded Successfully',
            'logo_path' => \URL::to('public/images/' . $imageName)
        ]);
    }
}
