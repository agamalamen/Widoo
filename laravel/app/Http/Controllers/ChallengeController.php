<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;
use App\Contribution;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Requests;
use Storage;
use File;
use Twitter;
use Google\Cloud\Vision\VisionClient;

class ChallengeController extends Controller
{
    public function getChallenge($challenge_id)
    {

      //$url = 'https://api.twitter.com/1.1/blocks/create.json';
      //$requestMethod = 'POST';


      $challenge = Challenge::find($challenge_id);
      $users = User::all();

      /*ini_set("allow_url_fopen", 1);

      $json = file_get_contents('http://api.qrserver.com/v1/read-qr-code/?fileurl=https://www.qrstuff.com/images/sample.png');
      $obj = json_decode($json, true);
      $qr_data = $obj[0]["symbol"][0]["data"];
      return $qr_data;*/
      //http://api.qrserver.com/v1/read-qr-code/?fileurl=https://www.qrstuff.com/images/sample.png

      //$path = storage_path() . "/app/business_logos/key.json"; // ie: /var/www/laravel/app/storage/json/filename.json

      //$json = json_decode(file_get_contents($path), true);

      //return $json;

      //$vision = new VisionClient(['key_file' => $json]);
      //$example = fopen("https://i.imgur.com/CL7mdOJ.jpg", 'r');
      //$image = $vision->image($example, ['WEB DETECTION']);
      //$result = $vision->annotate($image);
      //var_dump($result);
      return view('challenges.challenge')->with(['challenge' => $challenge, 'users' => $users]);
    }

    public function postQr(Request $request)
    {
      $this->validate($request, [
        'qr_code' => 'required|mimes:jpeg,jpg,png,gif'
      ]);
      $file = $request->file('qr_code');
      if($file) {
        $file->move('src/qr', 'qr_code1.png');
      }



      ini_set("allow_url_fopen", 1);

      $json = file_get_contents('http://api.qrserver.com/v1/read-qr-code/?fileurl=https://i.imgur.com/VsCPRFg.png');
      $obj = json_decode($json, true);
      $qr_data = $obj[0]["symbol"][0]["data"];
      if($qr_data == "coca-cola") {
        $contribution = new Contribution();
        $contribution->user_id = Auth::User()->id;
        $contribution->challenge_id = $request['challenge_id'];
        $contribution->save();
      }
      return redirect()->back();
    }

}
