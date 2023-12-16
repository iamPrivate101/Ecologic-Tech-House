@extends('front.layout.layout')
@section('content')
<style>
    .pagination nav li{
        list-style-type: none;
        float: left;
        width: 70px;
    }
</style>
    <div class="app-content">
        <!--====== Section 1 ======-->
        <div class="u-s-p-y-10">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <!--====== Filters ======-->
                        @include('front.products.filters')
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <div class="shop-p">
                            <div class="shop-p__toolbar u-s-m-b-30">
                                <div class="shop-p__meta-wrap u-s-m-b-60">

                                    <span class="shop-p__meta-text-1">FOUND {{ count($categoryProducts) }} RESULTS</span>
                                    <div class="shop-p__meta-text-2">

                                        {{-- <a class="gl-tag btn--e-brand-shadow" href="#">T-Shirts</a> --}}
                                        <?php echo $categoryDetails['breadcrumbs'] ?>

                                    </div>
                                </div>
                                <div class="shop-p__tool-style">
                                    <div class="tool-style__group u-s-m-b-8">

                                        <span class="js-shop-grid-target is-active">Grid</span>

                                        <span class="js-shop-list-target">List</span>
                                    </div>
                                    <form>
                                        <div class="tool-style__form-wrap">
                                            <div class="u-s-m-b-8"><select class="select-box select-box--transparent-b-2">
                                                    <option selected>Sort By: Newest Items</option>
                                                    <option>Sort By: Latest Items</option>
                                                    <option>Sort By: Best Selling</option>
                                                    <option>Sort By: Best Rating</option>
                                                    <option>Sort By: Lowest Price</option>
                                                    <option>Sort By: Highest Price</option>
                                                </select></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="shop-p__collection">
                                <div class="row is-grid-active">
                                    {{-- ajax product listing --}}
                                    @include('front.products.ajax_products_listing')

                                </div>
                            </div>
                            <div class="u-s-p-y-60 pagination">

                                <!--====== Pagination ======-->
                                {{ $categoryProducts->links() }}
                                <!--====== End - Pagination ======-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section 1 ======-->
    </div>
@endsection
