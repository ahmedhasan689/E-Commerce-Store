<x-latest-products>
    <div class="masonry-wrapper" data-col-md="4" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
        <div class="ps-masonry">
            <div class="grid-sizer"></div>

            @foreach ($products as $product)
            <div class="grid-item kids">
                <div class="grid-item__content-wrapper">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail">
                            <a class="ps-shoe__favorite" href="#">
                                <i class="ps-icon-heart"></i>
                            </a>
                            <img src="{{ asset('assets/front/images//shoe/8.jpg') }}" alt="">
                            <a class="ps-shoe__overlay" href="product-detail.html"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal"><img src="{{ asset('assets/front/images//shoe/2.jpg') }}" alt=""><img src="{{ asset('assets/front/images//shoe/3.jpg') }}" alt=""><img src="{{ asset('assets/front/images//shoe/4.jpg') }}" alt=""><img src="{{ asset('assets/front/images//shoe/5.jpg') }}" alt=""></div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail">
                                <a class="ps-shoe__name" href="#">
                                    {{ $product->name }}
                                </a>
                                <p class="ps-shoe__categories">
                                    <a href="#">Men shoes</a>,
                                    <a href="#"> Nike</a>,
                                    <a href="#">Jordan</a>
                                </p>
                                <span class="ps-shoe__price"> £ {{ $product->price }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-latest-products>