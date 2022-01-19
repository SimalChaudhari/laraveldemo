<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'logo_path',
        'layout_colors',
        'timezone',
        'predefined',
    ];

    const DEFAULT_GOOGLE_FONT = 'Open Sans';

    public static function defaultLayoutColors() {
        return [
            'top_menu_background_color' => '#fff',
            'top_menu_txt_color' => '#777',
            'left_sidebar_bg_color' => '#fff',
            'parent_menu_bg_color' => '#efeff0',
            'parent_menu_text_color' => '#444',
            'submenu_bg_color' => '#fafafa',
            'submenu_text_color' => '#222',
            'menu_hover_color' => '#d2d2dd',
            'page_content_bg_color' => '#fff',
            'footer_bg_color' => '#fff',
        ];
    }

    public static function mapLayoutColors($colors = []) {
        $default_colors = self::defaultLayoutColors();

        foreach( $default_colors as $key => $color ) {

            if( isset( $colors[$key] ) && !empty( $colors[$key] ) ) {
                // do nothing
            } else {
                $colors[$key] = $color;
            }

        }

        return $colors;
    }

    public static function mapGoogleFont( $font = '' ) {
        return !empty( $font ) ? $font : self::DEFAULT_GOOGLE_FONT;
    }

    public function getLayoutColorsAttribute($value) {
        return ( !is_null( $value ) OR !empty( $value ) ) ? json_decode( $value, true ) : [];
    }
}