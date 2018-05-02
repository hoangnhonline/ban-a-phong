<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Cache, Session;
use App\Helpers\simple_html_dom;
use App\Helpers\JavascriptUnpacker;
use App\Models\DataVideo;

class HomeController extends Controller
{
    public function index(Request $request){             
        $ax_url = $request->ax_url ? $request->ax_url : null;
        $code = '';
        if($ax_url){
            $this->validate($request,[
                'ax_url' => 'required|url'            
            ],
            [
                'ax_url.required' => 'Please enter URL.',            
                'ax_url.url' => 'URL is invalid.'
            ]);

            $rs = DataVideo::where('origin_url', $ax_url)->first();
            if(!$rs){
                $code = md5($ax_url);             
                DataVideo::create(['origin_url' => $ax_url, 'code' => $code]);
                Cache::put($code, $ax_url, 1800);
            }else{
                $code = $rs->code;
            }
        }

        return view('index', compact('ax_url', 'code'));
    }
    public function store(Request $request){             
        $ax_url = $request->ax_url ? $request->ax_url : null;
        $code = '';
        if($ax_url){
            if( strpos($ax_url, 'fastplay') == 0
                && strpos($ax_url, 'streamable') == 0                
                && strpos($ax_url, 'nodefiles.com') == 0                

        ){
                Session::put('not-support', 1);
            return redirect()->route('home');
            }else{
                Session::forget('not-support');
            }
           $this->validate($request,[
                'ax_url' => 'required|url'            
            ],
            [
                'ax_url.required' => 'Please enter URL.',            
                'ax_url.url' => 'URL is invalid.'
            ]);

            $rs = DataVideo::where('origin_url', $ax_url)->first();
            if(!$rs){
                $code = md5($ax_url);             
                DataVideo::create(['origin_url' => $ax_url, 'code' => $code]);
                Cache::put($code, $ax_url, 1800);
            }else{
                $code = $rs->code;
            }
        }

        return view('index', compact('ax_url', 'code'));
    }
    public function play(Request $request){
        $code = $request->code;
        $origin_url = '';        
        if (Cache::has($code)){
            $origin_url = Cache::get($code);            
        } else {
            $rs = DataVideo::where('code', $code)->first();
            if(!$rs){
                echo ('Video not exists.');die;
            }
            $origin_url = $rs->origin_url;
            Cache::put($code, $origin_url, 1800);
        }       
        $video_url = $poster_url = '';
        if($origin_url != ''){
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, $origin_url );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            if( strpos($origin_url, 'play.to')){
                curl_setopt($ch, CURLOPT_REFERER, "http://fastplay.to/");
                curl_setopt($ch, CURLOPT_PROXY, '128.199.199.41:3128');
            }
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($ch);            
            curl_close($ch);
            if( strpos($result, 'streamable')){
                $tmp = explode('"url": "', $result);               
                $tmp = explode('",', $tmp[1]);
                $video_url = "https:".$tmp[0];    
                $tmpPoster = explode('"thumbnail_url": "', $result);
                $tmp = explode('",', $tmpPoster[1]);
                $poster_url = "https:".$tmp[0];                                      
            }elseif( strpos($result, 'play.to')){
                $crawler = new simple_html_dom();                
                $crawler->load($result); 
                $js = $crawler->find('script', 7)->innertext;
                $unpack = new JavascriptUnpacker;
                $tmpScript = $unpack->unpack($js);                               
                $tmp = explode('{file:"', $tmpScript);
                if(isset($tmp[1])){
                    $tmp = explode('"', $tmp[1]);   
                    $video_url = $tmp[0];                 
                }else{
                    echo ('Video not exists.');die;
                }
                $tmpPoster = explode('image:"', $tmpScript);              
                if(isset($tmpPoster[1])){
                    $tmp = explode('"', $tmpPoster[1]);   
                    $poster_url = $tmp[0];                 
                }                                                      
            }else{                
                $crawler = new simple_html_dom();                
                $crawler->load($result); 
                $js = $crawler->find('script', 4)->innertext;
                $unpack = new JavascriptUnpacker;
                $tmpScript = $unpack->unpack($js);                               
                $tmp = explode('{file:"', $tmpScript);
                if(isset($tmp[1])){
                    $tmp = explode('"', $tmp[1]);   
                    $video_url = $tmp[0];                 
                }else{
                    echo ('Video not exists.');die;
                }
                $tmpPoster = explode('image:"', $tmpScript);              
                if(isset($tmpPoster[1])){
                    $tmp = explode('"', $tmpPoster[1]);   
                    $poster_url = $tmp[0];                 
                }                
            }            
            return view('play', compact('video_url', 'poster_url'));    
        }else{
            dd('Invalid code');
        }
        
    }    
}
