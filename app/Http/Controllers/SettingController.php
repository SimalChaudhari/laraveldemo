<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use File;
use DB;

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

use App\Models\Setting;

class SettingController extends Controller
{

    public function migrate_logos() {
        $logos = DB::table('logos')->get();
        foreach( $logos as $logo ) {
            $logo = collect($logo)->toArray();
            $logo['logo_path'] = $logo['img_path'];
            $logo['layout_colors'] = '';
            unset( $logo['img_path']);
            Setting::create( $logo );
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showSettings()
    {
        $company_admin      = Auth::user()->company_admin;
        $logged_in_username = Auth::user()->username;
        $logged_in_user_id = Auth::user()->id;

        $isSuperAdmin = false;
        $setting = null;
        if( getCurrentUserRole() === \Config::get('constants.admin')) {
            $isSuperAdmin = true;
            $setting = Setting::where( 'user_id', Auth::user()->id )->first();
        } else if( getCurrentUserRole() !== \Config::get('constants.admin')) {
            $setting = Setting::where( 'user_id', Auth::user()->id )->first();
        }

        if( $setting === null ) {
            $setting = [
                'logo_path' => '',
                'layout_colors' => '',
                'fonts' => '',
                'predefined' => '',
                'timezone' => '',
            ];

            $setting = collect( $setting )->first();
        }

        

        $google_fonts = DB::table('google_fonts')/*->where('created_at', date('Y-m-d'))*/->get();

        if( $google_fonts->count() == 0 ) {

            $google_api_key = "AIzaSyBFS39N6iyEeL-kC9WeivgCHeq0V7lgst0";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/webfonts/v1/webfonts?key=" . $google_api_key . "&sort=alpha");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
            $fonts = json_decode(curl_exec($ch), true);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if($http_code != 200) {
                exit('Error : Failed to get Google Fonts list');
            }

            $google_fonts = [];
            foreach( $fonts['items'] as $font ) {
                $google_fonts[] = [
                    'font' => $font['family'],
                    'created_at' => date('Y-m-d')
                ];

            }

            DB::table('google_fonts')->insert( $google_fonts );
        }

        // dd($fonts);

        return view('settings.site', compact('setting', 'google_fonts'));
    }

    public function saveSetting(Request $request) {

        try {
            // https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBFS39N6iyEeL-kC9WeivgCHeq0V7lgst0

            // please enable Web Fonts Developer API in google developer console.

            // https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBFS39N6iyEeL-kC9WeivgCHeq0V7lgst0

            $setting = Setting::where( 'user_id', Auth::user()->id )->first();
            if( $setting === null ) {
                $setting = new Setting();
            }

            /*$file_name = '';

            if( $request->logo != null ) {

                // delete existing one
                if( $setting !== null ) {
                    $old_file = public_path( 'images/' . $setting->logo_path );
                    if( File::exists( $old_file ) ) {
                        File::delete( $old_file );
                    }
                }

                $image = $request->logo;

                $file_name = time().'.'.$request->logo->extension(); //$request->logo->getClientOriginalName();

                $path = public_path('images/' . $file_name);

                Image::make($image->getRealPath())->resize(200, 60)->save($path);
            }*/

            $setting->user_id  = Auth::user()->id;

            if( !empty( $file_name ) ) {
                $setting->logo_path = $file_name;
            }

            if( !empty( $request->colors ) ) {
                $setting->layout_colors = json_encode( Setting::mapLayoutColors( $request->colors ) );
            }

            if( $request->has('fonts') ) {
                $setting->fonts = Setting::mapGoogleFont( $request->fonts );
            }

            if( $request->has('timezone') ) {
                $setting->timezone = Setting::mapGoogleFont( $request->timezone );
            }

            $setting->save();

            return back()->with('success', 'Settings have been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while saving the settings.' . $e->getMessage());
        }
    }
}
