<?php
$access_token = '<TOKEN>'; 

function scrobbler() {

        $request_url = 'http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=sabinich&api_key=<API_KEY>';

        $xml = simplexml_load_file ($request_url);
        $title = $xml->recenttracks->track->name;
        $artist = $xml->recenttracks->track->artist;
        $album = $xml->recenttracks->track->album;
        $nowplaying = $xml->recenttracks->track->attributes()->nowplaying;

	if (!is_null($nowplaying) && $nowplaying == 'true') {
            return 'now playing: ' . $artist . ' / ' . $album . ' / ' . $title;
        }
	return false;
}

$lastfm = scrobbler();

$trans = array("3" => "3⃣", "4" => "4⃣", "5" => "5⃣", "6" => "6⃣", "7" => "7⃣", "8" => "8⃣", "9" => "9⃣", "0" => "0⃣", "1" => "1⃣", "2" => "2⃣", );
$status = strtr($lastfm, $trans);
$url = curl('https://api.vk.com/method/status.set?text='.urlencode($status).'&access_token='.$access_token);
function curl( $url ){
$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
$response = curl_exec( $ch );
curl_close( $ch );
return $response;
}
?>
