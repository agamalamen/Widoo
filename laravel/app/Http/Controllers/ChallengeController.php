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
use Google_Client;
use Google_Service_Drive;
use Google_Service_Books;
use Google_Service_Fitness;
use Twitter;
use Google\Cloud\Vision\VisionClient;
use URL;
use Response;

class ChallengeController extends Controller
{

    public function fit()
    {
      $client = new Google_Client();
      $client->authenticate($_GET['code']);
      $access_token = $client->getAccessToken();
    }

    /*

    */

    public function google()
    {
      session_start();

      $client = new Google_Client();
      $client->setAuthConfig('src/client_secret.json');
      $client->addScope(Google_Service_Fitness::FITNESS_ACTIVITY_READ);

      if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
      $drive = new Google_Service_Fitness($client);
      } else {
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/crowdsource/fit';
      return header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
      }
    }

    public function getChallenge($challenge_id)
    {


      $challenge = Challenge::find($challenge_id);
      $users = User::all();

      ini_set("allow_url_fopen", 1);
      $final_count = '';
      if($challenge->type == "community") {
        $json2 = file_get_contents('https://de6280e1-e3b8-488c-b611-83040366e4df-bluemix.cloudant.com/run4qr/_all_docs');
        $obj2 = json_decode($json2, true);
        $qrs = $obj2["rows"];


        $polished2 = array();

        $i2 = 0;
        while($i2 < count($qrs)) {
          $qr = json_decode(file_get_contents('https://de6280e1-e3b8-488c-b611-83040366e4df-bluemix.cloudant.com/run4qr/' . $qrs[$i2]["id"]), true);
          $username2 = $qr["user"];
          $avatar2 = $qr["profile_pic"];
          $checkpoints = [$qr["Waconda"], $qr["BikiniBottom"], $qr["WhiteWalkers"]];
          array_push($polished2, [$username2, $avatar2, $checkpoints]);
          $i2++;
        }

        $final_count = array();
        $z = 0;
        while($z < count($polished2)) {
          $username = $polished2[$z][0];
          if(count($final_count) == 0) {
            array_push($final_count, [$username, $polished2[$z][1], [$polished2[$z][2][0],$polished2[$z][2][1],$polished2[$z][2][2]]]);
          } else {
            $y = 0;
            while($y < count($final_count)) {
              if($username == $final_count[$y][0]) {
                $final_count[$y][2][0] += $polished2[$z][2][0];
                $final_count[$y][2][1] += $polished2[$z][2][1];
                $final_count[$y][2][2] += $polished2[$z][2][2];
                break;
              }
              $y++;
            }
            if($y == count($final_count)) {
              array_push($final_count, [$username, $polished2[$z][1], [$polished2[$z][2][0],$polished2[$z][2][1],$polished2[$z][2][2]]]);
            }
          }
          $z++;
        }
      }

      if($challenge->type == "positivity")
      {
        $json = file_get_contents('https://de6280e1-e3b8-488c-b611-83040366e4df-bluemix.cloudant.com/positivetweets/_all_docs');
        $obj = json_decode($json, true);
        $tweets = $obj["rows"];

        $polished = array();

        $i = 0;
        while($i < count($tweets)-1) {
            $tweet = json_decode(file_get_contents('https://de6280e1-e3b8-488c-b611-83040366e4df-bluemix.cloudant.com/positivetweets/' . $tweets[$i]["id"]), true);
            $twitter_username = $tweet["topic"];
            $positivity = $tweet["positivity"];
            $avatar = $tweet["tweet"]["user"]["profile_image_url"];
            array_push($polished, [$twitter_username, $positivity, $avatar]);
            $i++;
        }

        $final_count = array();

        $z = 0;
        while($z < count($polished)) {
          $username = $polished[$z][0];
          if(count($final_count) == 0) {
            array_push($final_count, [$username, 1, $polished[$z][1], $polished[$z][2]]);
          } else {
            $y = 0;
            while($y < count($final_count)) {
              if($username == $final_count[$y][0]) {
                $final_count[$y][1]++;
                $final_count[$y][2] += $polished[$z][1];
                //$final_count[$y][3] += $polished[$z][2];
                break;
              }
              $y++;
            }
            if($y == count($final_count)) {
              array_push($final_count, [$username, 1, $polished[$z][1], $polished[$z][2]]);
            }
          }
          $z++;
        }
      }


      return view('challenges.challenge')->with(['challenge' => $challenge, 'users' => $users, 'tweeters' => $final_count]);
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

    public function postTwitter(Request $request)
    {
      $this->validate($request, [
        'handler' => 'required'
      ]);
      $user = Auth::User();
      $user->twitter = $request['handler'];
      $user->update();
      return redirect()->back();
    }

    public function getCreate()
    {
      return view('challenges.create');
    }

}
