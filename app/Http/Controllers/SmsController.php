<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use DB;

use App\Models\User;
use Auth;

/**
 * @group Sms management
 *
 * APIs for managing Sms
 */
class SmsController extends Controller
{

    // Function to generate OTP
    private function generateNumericOTP($length) {
          
        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";
      
        // Iterate for n-times and pick a single character
        // from generator and append it to $result
          
        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result
      
        $result = "";
      
        for ($i = 1; $i <= $length; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
      
        // Return result
        return $result;
    }

    public function sendSms(Request $request)
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $appSid     = config('app.twilio')['TWILIO_APP_SID'];

        $client = new Client($accountSid, $authToken);
        try
        {
            $otp = $this->generateNumericOTP(4);
            $to_phone_number = $request->to_number;
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                $to_phone_number, //'+14846399328',// . $mobile,
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => '+14755292423',
                    // the body of the text message you'd like to send
                    'body' => $otp . ' is SECRET OTP for your mobile number verification.'
                )
            );

            if( Auth::check() ) {
                $user = User::where('id', Auth::user()->id)->first();
                $user->otp = $otp;

                $user->save();
            } else {

                DB::table('temp_user_detail')->insert([
                    'phone_number' => $to_phone_number,
                    'otp' => $otp
                ]);

            }



            return response()->json([
                'success' => true,
                'message' => 'An otp has been sent to your mobile number.'
            ]);

        }
        catch (Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function verifyOTP(Request $request) {
        $otp = $request->otp;

        $mobile = '';
        if( $request->has('to_number') ) {
            $mobile = $request->to_number;
        }

        if( Auth::check() ) {
            $user = User::where('id', Auth::user()->id)->first();
            $userOTP = $user->otp;
        } else {

            $otp_query = DB::table('temp_user_detail')->where('otp', $otp);

            if( ! empty( $mobile ) ) {
                $otp_query = $otp_query->where('phone_number', $mobile);
            }

            $otp_query = $otp_query->first();

            if( $otp_query !== null ) {
                return response()->json([
                    'success' => true,
                    'message' => 'Valid'
                ]);
            }

            $userOTP = '';
        }

        if( $otp == $userOTP ) {
            return response()->json([
                'success' => true,
                'message' => 'Valid'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP.'
        ]);

    }
}