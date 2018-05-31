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
            if( strpos($ax_url, 'yadi.sk') == 0){
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
        $video_url = $poster_url = $result = '';
        if($origin_url != ''){
            $abc = file_get_contents($origin_url);             
            $crawler = new simple_html_dom();  
            $crawler->load($abc);

            $js = $crawler->find('script', 5)->innertext;
            if($js){
                $tmp = json_decode($js);                    
                $rootResourceId = $tmp->rootResourceId;                    
                $videoArr = $tmp->resources->$rootResourceId->videoStreams->videos;
                $rs = $videoArr[count($videoArr)-1];
                $mediaId = $rootResourceId;
                $video_url = $rs->url;
                if($tmp->resources->$rootResourceId->meta->xxxlPreview){
                    $poster_url = $tmp->resources->$rootResourceId->meta->xxxlPreview;
                }else{
                    $poster_url = $tmp->resources->$rootResourceId->meta->defaultPreview;
                }                    
            }                
                      
            return view('play', compact('video_url', 'poster_url'));    
        }else{
            dd('Invalid code');
        }
        
    }    
}
