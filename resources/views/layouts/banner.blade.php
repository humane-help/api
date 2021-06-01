<!-- Banner -->
@php
    $slider = \App\Models\Newspaper::whereIn('type', ['SLIDER', 'VIDEO'])->inRandomOrder()->get()->first();
@endphp
<section class="banner" style="background: url({{ $slider->img }}) no-repeat center;">
    @if ($slider->type == 'VIDEO')
    <video width="100%" src="{{ $slider->img }}" autoplay loop muted></video>
    @endif
    <div class="con">
        <div class="banner__box wow  fadeInUp animated" data-wow-delay="0.2s">
            <h1>{!!  $slider->mini_desc  !!}</h1>
            <p>{!! $slider->content !!}</p>
        </div>
    </div>
</section>