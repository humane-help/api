<!-- Carousel -->
<section class="carousel carousel-solutions">
    <div class="con">
        <div class="carousel__box">
            @foreach(\App\Models\Newspaper::where('type', 'TECH')->get() as $item)
                <div class="carousel-track">
                    <img src="{{ $item->img }}" alt="">
                </div>
            @endforeach
        </div>
    </div>
</section>