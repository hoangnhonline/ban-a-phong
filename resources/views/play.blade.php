<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8" />
<meta name="robots" content="noindex" />
<meta name="googlebot" content="noindex" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<style type="text/css">
              body{ margin: 0; padding: 0; font-family: "Helvetica", Arial sans-serif;}
              video,iframe,embed,#video-player,.flowplayer{width: 100% !important; }
              .preroll{position: relative}
              .ad-preroll{color: #fff; background: #000; background: rgba(0,0,0,0.5);width: 100% !important; height: 100% !important;border-radius: 2px; text-align:center;position: absolute; z-index: 9999999; display: none;}
              .play-screen{position: absolute; top: 0; left: 0; width: 100% !important; height: 100% !important; z-index: 9999999;cursor:pointer;}
              .video-js{position:absolute!important;top:0px;left:0px;width:100%!important;height:100%!important;z-index:0;}
</style>

</head>
<link href="https://linkshare.tv/part/video-js.css" rel="stylesheet">
<script src="https://linkshare.tv/part/video.js"></script>
<script src="https://linkshare.tv/part/videojs.js"></script>
<body>
  <video id="my_video" class="video-js vjs-default-skin vjs-big-play-centered"
        controls preload="auto" width="100%" height="100%"    
        data-setup='{"controls":true"}'>
        <source src="{!! $video_url !!}" type="application/x-mpegURL">
        </video>
       
</body>
</html>