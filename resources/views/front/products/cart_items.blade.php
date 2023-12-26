<?php use App\Models\Product; ?>
<!--====== Section 1 ======-->
<div class="u-s-p-y-10">

    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="breadcrumb">
                <div class="breadcrumb__wrap">
                    <ul class="breadcrumb__list">
                        <li class="has-separator">

                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="is-marked">

                            <a href="cart.html">Cart</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--====== End - Section 1 ======-->


<!--====== Section 2 ======-->
<div class="u-s-p-b-10">

    <!--====== Section Intro ======-->
    <div class="section__intro u-s-m-b-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__text-wrap">
                        <h1 class="section__heading u-c-secondary">SHOPPING CART</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Intro ======-->


    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                    <div class="table-responsive">
                        <table class="table-p">
                            <tbody>
                                <?php $total_price = 0; ?>
                                @foreach ($getCartItems as $item)
                                    <?php
                                    $getAttributePrice = Product::getAttributePrice($item['product_id'], $item['product_size']);
                                    // dd($getAttributePrice);
                                    ?>
                                    <!--====== Row ======-->
                                    <tr>
                                        <td>
                                            <div class="table-p__box">
                                                <div class="table-p__img-wrap">
                                                    <a href="{{ url('product/' . $item['product']['id']) }}">
                                                        @if (isset($item['product']['images'][0]['image']) && !empty($item['product']['images'][0]['image']))
                                                            <img class="u-img-fluid"
                                                                src="{{ asset('front/images/products/medium/' . $item['product']['images'][0]['image']) }}"
                                                                alt="{{ $item['product']['product_name'] }}">
                                                        @else
                                                            <img class="u-img-fluid"
                                                                src="{{ asset('front/images/product/sitemakers-tshirt.png') }}"
                                                                alt="{{ $item['product']['product_name'] }}">
                                                        @endif
                                                    </a>

                                                </div>
                                                <div class="table-p__info">
                                                    <span class="table-p__name">
                                                        <a
                                                            href="{{ url('product/' . $item['product']['id']) }}">{{ $item['product']['product_name'] }}</a></span>
                                                    <span class="table-p__category">
                                                        <a
                                                            href="{{ url('product/' . $item['product']['id']) }}">{{ $item['product']['brand']['brand_name'] }}</a></span>
                                                    <ul class="table-p__variant-list">
                                                        <li>
                                                            <span>Size: {{ $item['product_size'] }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Color:
                                                                {{ $item['product']['product_color'] }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="pd-detail__inline getAttributePrice">

                                                <span class="pd-detail__price"
                                                    style="font-size: 16px">Rs{{ $getAttributePrice['final_price'] * $item['product_qty'] }}</span>

                                                @if ($getAttributePrice['discount'] > 0)
                                                    <span
                                                        class="pd-detail__discount">({{ $getAttributePrice['discount_percent'] }}%
                                                        OFF)</span><del
                                                        class="pd-detail__del">{{ $getAttributePrice['product_price'] * $item['product_qty'] }}</del>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-p__input-counter-wrap">
                                                <!--====== Input Counter ======-->
                                                <div class="input-counter">
                                                    <span class="input-counter__minus fas fa-minus updateCartItem qtyMinus" data-cartid={{ $item['id'] }} data-qty={{ $item['product_qty'] }}></span>
                                                    <input
                                                        class="input-counter__text input-counter--text-primary-style"
                                                        type="text" value="{{ $item['product_qty'] }}"
                                                        data-min="1" data-max="1000">
                                                    <span class="input-counter__plus fas fa-plus updateCartItem qtyPlus" data-cartid={{ $item['id'] }} data-qty={{ $item['product_qty'] }}></span>
                                                </div>
                                                <!--====== End - Input Counter ======-->
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-p__del-wrap">
                                                <a class="far fa-trash-alt table-p__delete-link deleteCartItem" data-cartid="{{ $item['id'] }}"
                                                    href="#"></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!--====== End - Row ======-->
                                    <?php $total_price = $total_price + $getAttributePrice['final_price'] * $item['product_qty']; ?>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="route-box">
                        <div class="route-box__g1">

                            <a class="route-box__link" href="shop-side-version-2.html"><i
                                    class="fas fa-long-arrow-alt-left"></i>

                                <span>CONTINUE SHOPPING</span></a>
                        </div>
                        <div class="route-box__g2">

                            <a class="route-box__link emptyCart" href="javascript:;"><i class="fas fa-trash"></i>
                                <span>CLEAR CART</span>
                            </a>

                            <!-- <a class="route-box__link" href="cart.html"><i class="fas fa-sync"></i>
                                    <span>UPDATE CART</span>
                                </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Content ======-->
</div>
<!--====== End - Section 2 ======-->


<!--====== Section 3 ======-->
<div class="u-s-p-b-60">

    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                    <form class="f-cart">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 u-s-m-b-30">
                                <div class="f-cart__pad-box">

                                    <h1 class="gl-h1">APPLY COUPON CODE</h1>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="shipping-zip">Enter Coupon Code to avail
                                            Discount</label>

                                        <input class="input-text input-text--primary-style" type="text"
                                            id="shipping-zip" placeholder="Enter Coupon Code">
                                    </div>
                                    <div class="u-s-m-b-30">

                                        <a class="f-cart__ship-link btn--e-transparent-brand-b-2"
                                            href="cart.html">APPLY</a>
                                    </div>

                                    <!-- <span class="gl-text">Note: Any note can come here</span> -->
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 u-s-m-b-30">
                            </div>


                            <div class="col-lg-4 col-md-6 u-s-m-b-30">
                                <div class="f-cart__pad-box">
                                    <div class="u-s-m-b-30">
                                        <table class="f-cart__table">
                                            <tbody>
                                                <tr>
                                                    <td>SUBTOTAL</td>
                                                    <td>Rs{{ $total_price }}</td>
                                                </tr>
                                                <tr>
                                                    <td>COUPON DISCOUNT</td>
                                                    <td>₹0</td>
                                                </tr>
                                                <tr>
                                                    <td>GRAND TOTAL</td>
                                                    <td>Rs{{ $total_price }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>

                                        <button class="btn btn--e-brand-b-2" type="submit"> PROCEED TO
                                            CHECKOUT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Content ======-->
</div>
<!--====== End - Section 3 ======-->
