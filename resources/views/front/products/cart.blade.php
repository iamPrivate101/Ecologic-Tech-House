@extends('front.layout.layout')
@section('content')
    <!--====== App Content ======-->
    <div class="app-content">

        <!--====== Section 1 ======-->
        <div class="u-s-p-y-10">

            <!--====== Section Content ======-->
            <div class="section__content">
                <div class="container">
                    <div class="breadcrumb">
                        <div class="breadcrumb__wrap">
                            <ul class="breadcrumb__list">
                                <li class="has-separator">

                                    <a href="index.html">Home</a>
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

                                        <!--====== Row ======-->
                                        <tr>
                                            <td>
                                                <div class="table-p__box">
                                                    <div class="table-p__img-wrap">
                                                        <img class="u-img-fluid" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="table-p__info">
                                                        <span class="table-p__name">
                                                            <a href="product-detail.html">Product Name</a></span>
                                                        <span class="table-p__category">
                                                            <a href="shop-side-version-2.html">Brand Name</a></span>
                                                        <ul class="table-p__variant-list">
                                                            <li>
                                                                <span>Size: Large</span>
                                                            </li>
                                                            <li>
                                                                <span>Color: Red</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="table-p__price">₹900.00</span>
                                            </td>
                                            <td>
                                                <div class="table-p__input-counter-wrap">
                                                    <!--====== Input Counter ======-->
                                                    <div class="input-counter">
                                                        <span class="input-counter__minus fas fa-minus"></span>
                                                        <input class="input-counter__text input-counter--text-primary-style"
                                                            type="text" value="1" data-min="1" data-max="1000">
                                                        <span class="input-counter__plus fas fa-plus"></span>
                                                    </div>
                                                    <!--====== End - Input Counter ======-->
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-p__del-wrap">
                                                    <a class="far fa-trash-alt table-p__delete-link" href="#"></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!--====== End - Row ======-->

                                        <!--====== Row ======-->
                                        <tr>
                                            <td>
                                                <div class="table-p__box">
                                                    <div class="table-p__img-wrap">
                                                        <img class="u-img-fluid" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="table-p__info">
                                                        <span class="table-p__name">
                                                            <a href="product-detail.html">Product Name</a></span>
                                                        <span class="table-p__category">
                                                            <a href="shop-side-version-2.html">Brand Name</a></span>
                                                        <ul class="table-p__variant-list">
                                                            <li>
                                                                <span>Size: Large</span>
                                                            </li>
                                                            <li>
                                                                <span>Color: Red</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="table-p__price">₹900.00</span>
                                            </td>
                                            <td>
                                                <div class="table-p__input-counter-wrap">
                                                    <!--====== Input Counter ======-->
                                                    <div class="input-counter">
                                                        <span class="input-counter__minus fas fa-minus"></span>
                                                        <input class="input-counter__text input-counter--text-primary-style"
                                                            type="text" value="1" data-min="1" data-max="1000">
                                                        <span class="input-counter__plus fas fa-plus"></span>
                                                    </div>
                                                    <!--====== End - Input Counter ======-->
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-p__del-wrap">
                                                    <a class="far fa-trash-alt table-p__delete-link" href="#"></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!--====== End - Row ======-->

                                        <!--====== Row ======-->
                                        <tr>
                                            <td>
                                                <div class="table-p__box">
                                                    <div class="table-p__img-wrap">
                                                        <img class="u-img-fluid" src="{{ asset('front/images/product/sitemakers-tshirt.png') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="table-p__info">
                                                        <span class="table-p__name">
                                                            <a href="product-detail.html">Product Name</a></span>
                                                        <span class="table-p__category">
                                                            <a href="shop-side-version-2.html">Brand Name</a></span>
                                                        <ul class="table-p__variant-list">
                                                            <li>
                                                                <span>Size: Large</span>
                                                            </li>
                                                            <li>
                                                                <span>Color: Red</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="table-p__price">₹900.00</span>
                                            </td>
                                            <td>
                                                <div class="table-p__input-counter-wrap">
                                                    <!--====== Input Counter ======-->
                                                    <div class="input-counter">
                                                        <span class="input-counter__minus fas fa-minus"></span>
                                                        <input class="input-counter__text input-counter--text-primary-style"
                                                            type="text" value="1" data-min="1" data-max="1000">
                                                        <span class="input-counter__plus fas fa-plus"></span>
                                                    </div>
                                                    <!--====== End - Input Counter ======-->
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-p__del-wrap">
                                                    <a class="far fa-trash-alt table-p__delete-link" href="#"></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!--====== End - Row ======-->

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

                                    <a class="route-box__link" href="cart.html"><i class="fas fa-trash"></i>
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
                                                            <td>₹2700</td>
                                                        </tr>
                                                        <tr>
                                                            <td>COUPON DISCOUNT</td>
                                                            <td>₹0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>GRAND TOTAL</td>
                                                            <td>₹2700</td>
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
    </div>
    <!--====== End - App Content ======-->
@endsection
