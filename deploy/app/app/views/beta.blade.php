@extends('layouts.vitumob')

{{-- Web site Title --}}
@section('title')
@parent
:: kila kitu kila siku
@stop


@section('css')
    <meta pageSize=55%, resize=no, scrollbars=no />
    <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/ndfakojkecjkdibnkcoljkdbkbkoloik">
@stop


@section('main')



<div id="main" class="">

<div style="text-align: center; margin-top: 0pt">
<img id="thumbnail" src="{{ asset('images/tag_with.png') }}" width="576" height="324" style="border: thin black dotted">
<video style="display:none" width="576" height="324" controls preload>
    <source src="http://www.ecosandals.com/vm/video/vitumob640x360.mp4" type="video/mp4">
    <source src="http://www.ecosandals.com/vm/video/vitumob640x360.webm" type="video/webm"/>
</video>
</div>

<script>
var thumbnail = document.getElementById("thumbnail");
var video = document.getElementsByTagName("video")[0];
if (window.navigator.userAgent.indexOf("Firefox") != -1) {
    video.setAttribute("poster", "{{ asset('images/tag_without.png') }}");
    thumbnail.style.display = "none";
    video.style.display = "inline-block";
} else {
    video.style.border = "thin black dotted";
    thumbnail.addEventListener("click", function(e) {
        thumbnail.style.display = "none";
        video.style.display = "inline-block";
        video.play();
    }, false);
}
</script>



<script>

    function addDownloadButton(f) {
        var downloadDiv = document.createElement("div");
        downloadDiv.setAttribute("id", "download");
        var downloadButton = document.createElement("button");
        downloadButton.className = "large blue";
        downloadButton.setAttribute("style", "margin-top: 10px;");
        downloadButton.appendChild(document.createTextNode("Download VituMob"));
        downloadButton.addEventListener("click", f, false);
        downloadDiv.appendChild(downloadButton);
        document.getElementById("main").appendChild(downloadDiv);
    }
    if (window.navigator.userAgent.indexOf("Firefox") !== -1) {
        
        addDownloadButton(function() { window.location = "{{ asset('firefox_ext/vitumob.xpi') }}" })

    } else if (window.navigator.userAgent.indexOf("Chrome") !== -1) {
        
        addDownloadButton(function() { chrome.webstore.install(undefined, function() { document.getElementById("main").removeChild(downloadDiv) }) })

    } else if (window.navigator.userAgent.indexOf("Safari") !== -1) {

        addDownloadButton(function() { window.location = "{{ asset('safari_ext/vitumob.safariextz') }}" })
    }

</script>


</div>

@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('assets/scripts/js/vendor/bootstrap.min.js') }}"></script> -->
@stop

