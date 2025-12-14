@props(['slides'])
<style>
    .hero-swiper .swiper-slide {
        width: 1000px;
        height: 500px;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
        transform: scale(0.9);
        opacity: 0.6;
        z-index: 1;
    }

    .hero-swiper .swiper-slide-active {
        transform: scale(1);
        opacity: 1;
        z-index: 10;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background: #1B211A;
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .swiper-pagination-bullet-active {
        background: #B48E43;
        width: 24px;
        border-radius: 4px;
        opacity: 1;
    }
</style>
<div class="px-4 lg:px-8">
    <div class="swiper hero-swiper max-w-[1600px] mx-auto mt-4 px-4 lg:px-8">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
                <div class="swiper-slide">
                    <a href="{{ $slide['link'] ?? '#' }}" class="block w-full h-full">
                        <picture>
                            <source srcset="{{ $slide['mobile_image'] }}" media="(max-width: 768px)">
                            <img src="{{ $slide['desktop_image'] }}" alt="{{ $slide['alt'] ?? 'Banner' }}"
                                class="w-full h-full object-cover rounded-xl">
                        </picture>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination bottom-2!"></div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        new Swiper(".hero-swiper", {
            loop: true,
            centeredSlides: true,
            slidesPerView: "auto",
            spaceBetween: 30,
            speed: 1000,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                1024: { spaceBetween: 40 }
            }
        });
    });
</script>
