@extends('layouts.admin')

@section('page_title')
HIPAA Training
@endsection

@section('content')

<x-alert />


<style>
.video-container {
    overflow: hidden;
    position: relative;
}

.video-container::after {
    padding-top: 56.25%;
    display: block;
    content: '';
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.btn-trainig-quiz{
    color: #ffffff !important;
    font-weight: bold;
    background-image: linear-gradient(to bottom,#ffb660,#ffb660) !important;
    background-color: #ffb660 !important;
}
.btn-trainig-quiz:hover, .btn-trainig-quiz:focus {
    background-color: #ffb660 !important;
}
video{
    object-fit: cover;
}
</style>

<div class="col-sm-2 col-xs-12"></div>

<div class="col-sm-8 col-xs-12">
    <video width="700" height="350" controls poster="{{ asset('public/video/HIPAAmart-Video-Intro.png') }}">
        <source src="{{ asset('public/video/HIPAAmart-Training-Video_v5.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <!-- <iframe id="training_video_iframe" src="https://player.vimeo.com/video/579598847?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="HIPAAmart-Training-Video_v2"></iframe> -->

</div>

<div class="col-sm-2 col-xs-12"></div>

<div class="clearfix"></div>

<p>&nbsp;</p>

<div class="col-sm-4 col-xs-12"></div>

<div class="col-sm-4 col-xs-12">

    <?php
    $training_quiz = \App\Models\Quiz::select('uuid')->where('name', 'Training Quiz')->first();
    ?>

    <a href="{{ route('UI_quizOverview', $training_quiz->uuid) }}" class="btn btn-custom-primary btn-block btn-lg btn-trainig-quiz">Proceed to Training Quiz</a>
</div>

<div class="col-sm-4 col-xs-12"></div>
<div class="clearfix"></div>
<script src="https://player.vimeo.com/api/player.js"></script>
<script type="text/javascript">

    var player = new Vimeo.Player($('#training_video_iframe')[0]);
    
    player.on('play', function() {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route("postTrainingVideoWatched") }}',
            method: 'POST',
            data: {},
            success: function(response) {
                
            }
        });

    });

    player.on('ended', function() {
      console.log('finished the video');
    });

</script>

@endsection