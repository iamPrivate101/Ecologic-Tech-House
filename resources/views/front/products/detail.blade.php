@extends('front.layout.layout')
@section('content')

 <!--====== App Content ======-->
 <div class="app-content">

    <!--====== Section 1 ======-->
    <div class="u-s-p-t-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">

                    <!--====== Product Breadcrumb ======-->
                    <div class="pd-breadcrumb u-s-m-b-30">
                        <ul class="pd-breadcrumb__list">
                            <?php echo $categoryDetails['breadcrumbs']; ?>
                        </ul>
                    </div>
                    <!--====== End - Product Breadcrumb ======-->


                    <!--====== Product Detail Zoom ======-->
                    <div class="pd u-s-m-b-30">
                        <div class="slider-fouc pd-wrap">
                            <div id="pd-o-initiate">
                                @foreach ($productDetails['images'] as $image )
                                <div class="pd-o-img-wrap" data-src="{{ asset('front/images/products/large/'.$image['image']) }}">
                                    <img class="u-img-fluid" src="{{ asset('front/images/products/large/'.$image['image']) }}" data-zoom-image="{{ asset('front/images/products/large/'.$image['image']) }}" alt="{{ $productDetails['product_name'] }}">
                                </div>
                                @endforeach
                            </div>

                            <span class="pd-text">Click for larger zoom</span>
                        </div>
                        <div class="u-s-m-t-15">
                            <div class="slider-fouc">
                                <div id="pd-o-thumbnail">
                                @foreach ($productDetails['images'] as $image )
                                    <div>
                                        <img class="u-img-fluid" src="{{ asset('front/images/products/small/'.$image['image']) }}" alt="{{ $productDetails['product_name'] }}">
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--====== End - Product Detail Zoom ======-->
                </div>
                <div class="col-lg-7">

                    <!--====== Product Right Side Details ======-->
                    <div class="pd-detail">
                        <div>

                            <span class="pd-detail__name">{{ $productDetails['product_name'] }}</span></div>
                        <div>
                            <div class="pd-detail__inline getAttributePrice">

                                <span class="pd-detail__price" >₹{{ $productDetails['final_price'] }}</span>

                                @if($productDetails['discount_type']!="")
                                <span class="pd-detail__discount">({{ $productDetails['product_discount'] }}% OFF)</span><del class="pd-detail__del">{{ $productDetails['product_price'] }}</del>
                            </div>
                                @endif
                        </div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>

                                <span class="pd-detail__review u-s-m-l-4">

                                    <a data-click-scroll="#view-review">25 Reviews</a></span></div>
                        </div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__inline">

                                <span class="pd-detail__stock">200 in stock</span>

                                <span class="pd-detail__left">Only 2 left</span></div>
                        </div>
                        <div class="u-s-m-b-15">

                            <span class="pd-detail__preview-desc">{{ $productDetails['description'] }}</span></div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__inline">
                                <span class="pd-detail__click-wrap"><i class="far fa-heart u-s-m-r-6"></i>
                                    <a href="signin.html">Add to Wishlist</a>
                                </span>
                            </div>
                        </div>

                        <div class="u-s-m-b-15">
                            <ul class="pd-social-list">
                                <li>

                                    <a class="s-fb--color-hover" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li>

                                    <a class="s-tw--color-hover" href="#"><i class="fab fa-twitter"></i></a></li>
                                <li>

                                    <a class="s-insta--color-hover" href="#"><i class="fab fa-instagram"></i></a></li>
                                <li>

                                    <a class="s-wa--color-hover" href="#"><i class="fab fa-whatsapp"></i></a></li>
                                <li>

                                    <a class="s-gplus--color-hover" href="#"><i class="fab fa-google-plus-g"></i></a></li>
                            </ul>
                        </div>
                        <div class="u-s-m-b-15">
                            <form class="pd-detail__form">
                                @if (count($groupProducts)>0)
                                <div class="u-s-m-b-15">

                                    <span class="pd-detail__label u-s-m-b-8">Color:</span>
                                    <div class="pd-detail__color">
                                        @foreach ($groupProducts as $product)
                                        <a href="{{ url('product/'.$product['id']) }}">
                                            <div class="color__radio">
                                                <label class="color__radio-label" for="folly" style="background-color: {{ $product['product_color'] }}"></label>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="u-s-m-b-15">

                                    <span class="pd-detail__label u-s-m-b-8">Size:</span>
                                    <div class="pd-detail__size">
                                        @foreach ($productDetails['attributes'] as $attribute )
                                        <div class="size__radio">

                                            <input type="radio" id="{{ $attribute['size'] }}" name="size" checked value="{{ $attribute['size'] }}" product-id="{{ $productDetails['id'] }}" class="getPrice">

                                            <label class="size__radio-label" for="{{ $attribute['size'] }}">{{ $attribute['size'] }}</label>
                                        </div>
                                        @endforeach


                                    </div>
                                </div>
                                <div class="pd-detail-inline-2">
                                    <div class="u-s-m-b-15">

                                        <!--====== Input Counter ======-->
                                        <div class="input-counter">

                                            <span class="input-counter__minus fas fa-minus"></span>

                                            <input class="input-counter__text input-counter--text-primary-style" type="text" value="1" data-min="1" data-max="1000">

                                            <span class="input-counter__plus fas fa-plus"></span></div>
                                        <!--====== End - Input Counter ======-->
                                    </div>
                                    <div class="u-s-m-b-15">

                                        <button class="btn btn--e-brand-b-2" type="submit">Add to Cart</button></div>
                                </div>
                            </form>
                        </div>
                        <div class="u-s-m-b-15">

                            <span class="pd-detail__label u-s-m-b-8">Product Policy:</span>
                            <ul class="pd-detail__policy-list">
                                <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                    <span>Buyer Protection.</span></li>
                                <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                    <span>Full Refund if you don't receive your order.</span></li>
                                <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                    <span>Returns accepted if product not as described.</span></li>
                            </ul>
                        </div>
                    </div>
                    <!--====== End - Product Right Side Details ======-->
                </div>
            </div>
        </div>
    </div>

    <!--====== Product Detail Tab ======-->
    <div class="u-s-p-y-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pd-tab">
                        <div class="u-s-m-b-30">
                            <ul class="nav pd-tab__list">
                                <li class="nav-item">

                                    <a class="nav-link" data-toggle="tab" href="#pd-desc">DESCRIPTION</a></li>
                                <li class="nav-item">

                                    <a class="nav-link" data-toggle="tab" href="#pd-tag">VIDEO</a></li>
                                <li class="nav-item">

                                    <a class="nav-link active" id="view-review" data-toggle="tab" href="#pd-rev">REVIEWS
                                        <span>(25)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">

                            <!--====== Tab 1 ======-->
                            <div class="tab-pane" id="pd-desc">
                                <div class="pd-tab__desc">
                                    <div class="u-s-m-b-15">
                                        <p>{{ $productDetails['description'] }}</p>
                                    </div>
                                    <div class="u-s-m-b-30"><iframe src="https://www.youtube.com/embed/qKqSBm07KZk" allowfullscreen></iframe></div>
                                    <!-- <div class="u-s-m-b-30">
                                        <ul>
                                            <li><i class="fas fa-check u-s-m-r-8"></i>

                                                <span>Buyer Protection.</span></li>
                                            <li><i class="fas fa-check u-s-m-r-8"></i>

                                                <span>Full Refund if you don't receive your order.</span></li>
                                            <li><i class="fas fa-check u-s-m-r-8"></i>

                                                <span>Returns accepted if product not as described.</span></li>
                                        </ul>
                                    </div> -->
                                    <div class="u-s-m-b-15">
                                        <h4>PRODUCT INFORMATION</h4>
                                    </div>
                                    <div class="u-s-m-b-15">
                                        <div class="pd-table gl-scroll">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Brand</td>
                                                        <td>{{ $productDetails['brand']['brand_name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product Code</td>
                                                        <td>{{ $productDetails['product_color'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product Color</td>
                                                        <td>{{ $productDetails['product_color'] }}</td>
                                                    </tr>
                                                    @if(!empty($productDetails['laptop']))
                                                    <tr>
                                                        <td>Laptop</td>
                                                        <td>{{ $productDetails['laptop'] }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($productDetails['computer']))
                                                    <tr>
                                                        <td>Computer</td>
                                                        <td>{{ $productDetails['computer'] }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($productDetails['mobile']))
                                                    <tr>
                                                        <td>Mobile</td>
                                                        <td>{{ $productDetails['mobile'] }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($productDetails['network']))
                                                    <tr>
                                                        <td>Network</td>
                                                        <td>{{ $productDetails['network'] }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($productDetails['product_weight']))
                                                    <tr>
                                                        <td>Weight</td>
                                                        <td>{{ $productDetails['product_weight'] }}</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--====== End - Tab 1 ======-->


                            <!--====== Tab 2 ======-->
                            <div class="tab-pane" id="pd-tag">
                                <div class="pd-tab__tag">
                                    <h2 class="u-s-m-b-15">PRODUCT VIDEO</h2>
                                    <div class="u-s-m-b-15">
                                        @if ($productDetails['product_video'])
                                        <video width="400" controls>
                                          <source src="{{ url('front/videos/products/'.$productDetails['product_video']) }}" type="video/mp4">

                                          Your browser does not support HTML video.
                                        </video>
                                        @else
                                            Product Doesn't Exist!!
                                        @endif

                                    </div>

                                    <span class="gl-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
                                </div>
                            </div>
                            <!--====== End - Tab 2 ======-->


                            <!--====== Tab 3 ======-->
                            <div class="tab-pane fade show active" id="pd-rev">
                                <div class="pd-tab__rev">
                                    <div class="u-s-m-b-30">
                                        <div class="pd-tab__rev-score">
                                            <div class="u-s-m-b-8">
                                                <h2>25 Reviews - 4.6 (Overall)</h2>
                                            </div>
                                            <div class="gl-rating-style-2 u-s-m-b-8"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                                            <div class="u-s-m-b-8">
                                                <h4>We want to hear from you!</h4>
                                            </div>

                                            <span class="gl-text">Tell us what you think about this item</span>
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-30">
                                        <form class="pd-tab__rev-f1">
                                            <div class="rev-f1__group">
                                                <div class="u-s-m-b-15">
                                                    <h2>25 Review(s) for Double Shade Black Grey Casual T-Shirt</h2>
                                                </div>
                                                <div class="u-s-m-b-15">

                                                    <label for="sort-review"></label><select class="select-box select-box--primary-style" id="sort-review">
                                                        <option selected>Sort by: Best Rating</option>
                                                        <option>Sort by: Worst Rating</option>
                                                    </select></div>
                                            </div>
                                            <div class="rev-f1__review">
                                                <div class="review-o u-s-m-b-15">
                                                    <div class="review-o__info u-s-m-b-8">

                                                        <span class="review-o__name">Good Product</span>

                                                        <span class="review-o__date">22 July 2023 10:57:43</span></div>
                                                    <div class="review-o__rating gl-rating-style u-s-m-b-8"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>

                                                        <span>(4)</span></div>
                                                    <p class="review-o__text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                </div>
                                                <div class="review-o u-s-m-b-15">
                                                    <div class="review-o__info u-s-m-b-8">

                                                        <span class="review-o__name">Good Product</span>

                                                        <span class="review-o__date">22 July 2023 10:57:43</span></div>
                                                    <div class="review-o__rating gl-rating-style u-s-m-b-8"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>

                                                        <span>(4)</span></div>
                                                    <p class="review-o__text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                </div>
                                                <div class="review-o u-s-m-b-15">
                                                    <div class="review-o__info u-s-m-b-8">

                                                        <span class="review-o__name">Good Product</span>

                                                        <span class="review-o__date">22 July 2023 10:57:43</span></div>
                                                    <div class="review-o__rating gl-rating-style u-s-m-b-8"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>

                                                        <span>(4)</span></div>
                                                    <p class="review-o__text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="u-s-m-b-30">
                                        <form class="pd-tab__rev-f2">
                                            <h2 class="u-s-m-b-15">Add a Review</h2>

                                            <span class="gl-text u-s-m-b-15">Your email address will not be published. Required fields are marked *</span>
                                            <div class="u-s-m-b-30">
                                                <div class="rev-f2__table-wrap gl-scroll">
                                                    <table class="rev-f2__table">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i>

                                                                        <span>(1)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>

                                                                        <span>(1.5)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                                                        <span>(2)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>

                                                                        <span>(2.5)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                                                        <span>(3)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>

                                                                        <span>(3.5)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                                                        <span>(4)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>

                                                                        <span>(4.5)</span></div>
                                                                </th>
                                                                <th>
                                                                    <div class="gl-rating-style-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                                                        <span>(5)</span></div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-1" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-1"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-1.5" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-1.5"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-2" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-2"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-2.5" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-2.5"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-3" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-3"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-3.5" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-3.5"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-4" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-4"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-4.5" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-4.5"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                                <td>

                                                                    <!--====== Radio Box ======-->
                                                                    <div class="radio-box">

                                                                        <input type="radio" id="star-5" name="rating">
                                                                        <div class="radio-box__state radio-box__state--primary">

                                                                            <label class="radio-box__label" for="star-5"></label></div>
                                                                    </div>
                                                                    <!--====== End - Radio Box ======-->
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="rev-f2__group">
                                                <div class="u-s-m-b-15">

                                                    <label class="gl-label" for="reviewer-text">YOUR REVIEW *</label><textarea class="text-area text-area--primary-style" id="reviewer-text"></textarea></div>
                                                <div>
                                                    <p class="u-s-m-b-30">

                                                        <label class="gl-label" for="reviewer-name">YOUR NAME *</label>

                                                        <input class="input-text input-text--primary-style" type="text" id="reviewer-name"></p>
                                                    <p class="u-s-m-b-30">

                                                        <label class="gl-label" for="reviewer-email">YOUR EMAIL *</label>

                                                        <input class="input-text input-text--primary-style" type="text" id="reviewer-email"></p>
                                                    <p class="u-s-m-b-30">

                                                        <label class="gl-label" for="review-title">REVIEW TITLE *</label>

                                                        <input class="input-text input-text--primary-style" type="text" id="review-title"></p>
                                                </div>
                                            </div>
                                            <div>

                                                <button class="btn btn--e-brand-shadow" type="submit">SUBMIT</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--====== End - Tab 3 ======-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Product Detail Tab ======-->
    <div class="u-s-p-b-90">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">
                            <h1 class="section__heading u-c-secondary u-s-m-b-12">CUSTOMER ALSO VIEWED</h1>

                            <span class="section__span u-c-grey">PRODUCTS THAT CUSTOMER VIEWED</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="slider-fouc">
                    <div class="owl-carousel product-slider" data-item="4">
                        <div class="u-s-m-b-30">
                            <div class="product-o product-o--hover-on">
                                <div class="product-o__wrap">
                                    <a class="aspect aspect--bg-grey aspect--square u-d-block" href="product-detail.html">
                                        <img class="aspect__img" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}" alt="">
                                    </a>
                                </div>
                                <span class="product-o__category">
                                    <a href="shop-side-version-2.html">Brand Name</a></span>
                                <span class="product-o__name">

                                    <a href="product-detail.html">Product Name</a></span>
                                <div class="product-o__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                    <span class="product-o__review">(20)</span></div>

                                <span class="product-o__price">₹900.00

                                    <span class="product-o__discount">₹1000.00</span></span>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="product-o product-o--hover-on">
                                <div class="product-o__wrap">
                                    <a class="aspect aspect--bg-grey aspect--square u-d-block" href="product-detail.html">
                                        <img class="aspect__img" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}" alt="">
                                    </a>
                                </div>
                                <span class="product-o__category">
                                    <a href="shop-side-version-2.html">Brand Name</a></span>
                                <span class="product-o__name">

                                    <a href="product-detail.html">Product Name</a></span>
                                <div class="product-o__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                    <span class="product-o__review">(20)</span></div>

                                <span class="product-o__price">₹900.00

                                    <span class="product-o__discount">₹1000.00</span></span>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="product-o product-o--hover-on">
                                <div class="product-o__wrap">
                                    <a class="aspect aspect--bg-grey aspect--square u-d-block" href="product-detail.html">
                                        <img class="aspect__img" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}" alt="">
                                    </a>
                                </div>
                                <span class="product-o__category">
                                    <a href="shop-side-version-2.html">Brand Name</a></span>
                                <span class="product-o__name">

                                    <a href="product-detail.html">Product Name</a></span>
                                <div class="product-o__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                    <span class="product-o__review">(20)</span></div>

                                <span class="product-o__price">₹900.00

                                    <span class="product-o__discount">₹1000.00</span></span>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="product-o product-o--hover-on">
                                <div class="product-o__wrap">
                                    <a class="aspect aspect--bg-grey aspect--square u-d-block" href="product-detail.html">
                                        <img class="aspect__img" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}" alt="">
                                    </a>
                                </div>
                                <span class="product-o__category">
                                    <a href="shop-side-version-2.html">Brand Name</a></span>
                                <span class="product-o__name">

                                    <a href="product-detail.html">Product Name</a></span>
                                <div class="product-o__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                    <span class="product-o__review">(20)</span></div>

                                <span class="product-o__price">₹900.00

                                    <span class="product-o__discount">₹1000.00</span></span>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="product-o product-o--hover-on">
                                <div class="product-o__wrap">
                                    <a class="aspect aspect--bg-grey aspect--square u-d-block" href="product-detail.html">
                                        <img class="aspect__img" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}" alt="">
                                    </a>
                                </div>
                                <span class="product-o__category">
                                    <a href="shop-side-version-2.html">Brand Name</a></span>
                                <span class="product-o__name">

                                    <a href="product-detail.html">Product Name</a></span>
                                <div class="product-o__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                    <span class="product-o__review">(20)</span></div>

                                <span class="product-o__price">₹900.00

                                    <span class="product-o__discount">₹1000.00</span></span>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="product-o product-o--hover-on">
                                <div class="product-o__wrap">
                                    <a class="aspect aspect--bg-grey aspect--square u-d-block" href="product-detail.html">
                                        <img class="aspect__img" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}" alt="">
                                    </a>
                                </div>
                                <span class="product-o__category">
                                    <a href="shop-side-version-2.html">Brand Name</a></span>
                                <span class="product-o__name">

                                    <a href="product-detail.html">Product Name</a></span>
                                <div class="product-o__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                    <span class="product-o__review">(20)</span></div>

                                <span class="product-o__price">₹900.00

                                    <span class="product-o__discount">₹1000.00</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 1 ======-->
</div>
<!--====== End - App Content ======-->

@endsection
