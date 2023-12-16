
$(document).ready(function() {

  	// Filters for Laravel 10 E-commerce Website from Youtube.com/StackDevelopers

  	var queryStringObject = {};
    if ($('.filtertrue').length > 0) {
        RefreshFilters("no");
        popTriggerList(); 
    }

    $(".filterAjax").click(function () {

        var name = $(this).attr('name');
        var val = $(this).val();
        var $tt = $('#AppenderLinks');
        // single check functionality
        if (name === "price" && $(document).find('.inlineFilterLink[id*="RemoveFilter-"][data-name="price"]').length > 0) {
            var targetToRemove = $('.inlineFilterLink[id*="RemoveFilter-"][data-name="price"]');
            targetToRemove.trigger('click');
        }
        $('.filterAjax').each(function () {
            var v = $(this).val();
            if (v === val && $(this).is(':checked')) {
                $tt.prepend('<a data-target="' + val + '" id="RemoveFilter-' + val + '" href="javascript:void(0);" class="inlineFilterLink" data-name="' + name + '">' + val + '<span class="ion-close"></span></a>');
            } else if (v === val && !$(this).is(':checked')) {
                $('.inlineFilterLink[data-target="' + val + '"][id*="RemoveFilter-"]').remove();
                RefreshFilters("yes");
            }
        });
        /*if (name === "category" && $(this).is(':checked')) {
            var v = $(this).val();
            $('.inlineFilterLink[data-name="category"]').each(function (key) {
                var $this = $(this);
                var id = "Category-" + v;
                $('#RemoveFilter-' + v).html($('#' + id).siblings('span.ccLabel').text() + '<span class="ion-close"></span></a>');
            });
        }*/
        /*if (name === "brand" && $(this).is(':checked')) {
            var v = $(this).val();
            $('.inlineFilterLink[data-name="brand"]').each(function (key) {
                var $this = $(this);
                var id = "brand-" + v;
                $('#RemoveFilter-' + v).html($('#' + id).siblings('span.ccLabel').text() + '<span class="ion-close"></span></a>');
            });
        }*/
        if ($('#AppenderLinks .inlineFilterLink').length > 0 && $('#AppenderLinks .absClear').length <= 0) {
            $tt.append('<a href="javascript:void(0);" class="absClear">Clear All</a>');
        }
        if ($('#AppenderLinks .inlineFilterLink').length <= 0) {
            $('#AppenderLinks').html(' ');
        }
        queryStringObject[name] = [];
        $.each($("input[name='" + $(this).attr('name') + "']:checked"), function () {
            queryStringObject[name].push($(this).val());
        });
        if (queryStringObject[name].length == 0) {
            delete queryStringObject[name];
        }
        RefreshFilters("yes");
    });

    /*$(document).on('click', 'a[id*="RemoveFilter-"]', function (e) {
        e.preventDefault();
        var tar = $(this).attr('data-target');
        if ($('input[value="' + tar + '"]:checked')) {
            $('input[value="' + tar + '"]').removeAttr('checked');
            $(this).remove();
            if ($('#AppenderLinks .inlineFilterLink').length <= 0) {
                $('#AppenderLinks').html(' ');
            }
            RefreshFilters("yes");
        }
    });*/

    /*$(document).on('click', '.absClear', function (e) {
        e.preventDefault();
        $('.filterAjax').each(function () {
            $(this).removeAttr('checked');
        });
        document.getElementById('sortby-select').selectedIndex = 0;
        $('#AppenderLinks').html('');
        RefreshFilters("clear-all");
    });*/

    $(document).on('change', '.getsort', function () {
        
        var value = $(this).val();
        var name = $(this).attr('name');
        queryStringObject[name] = [value];
        if (value == "") {
            delete queryStringObject[name];
        }
        RefreshFilters("yes");
    });

    $(document).on('click','#pricesort',function(){  
        var minprice = parseInt($('#from_range').val());
        var maxprice= parseInt($('#to_range').val());
        /*if (isNaN( $("#minprice").val() )) {
            alert("Please enter valid Min Price");
            return false;
        }*/
        queryStringObject["price"] = [minprice+"-"+maxprice];
        if(minprice==""&& maxprice==""){
            delete queryStringObject["price"];
        }
        $("#priceRange").val(minprice + "-" + maxprice);

        debounce(function() {
                $("input[name='price']").val($("#priceRange").val()).click();
            }, 100)();
            
        RefreshFilters("yes");
        // filterproducts(queryStringObject);
    });

    /*----------  Range Slider  ----------*/
    /*$(function () {

        $(".pm-range-slider").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [100, 2000],
            slide: function (event, ui) {
                $("#amount").val("₹ " + ui.values[0] + " - ₹ " + ui.values[1]);
                $('#minprice').val(ui.values[0]);
                $('#maxprice').val(ui.values[1]);
                RefreshFilters("yes");
            }
        });
        $("#amount").val("₹ " + $(".pm-range-slider").slider("values", 0) +
            " - ₹ " + $(".pm-range-slider").slider("values", 1));
    });*/

});

function RefreshFilters(type) {
    var queryStringObject = {};
    if (type != "clear-all") {
        $(".filterAjax").each(function () {
            var name = $(this).attr('name');
            queryStringObject[name] = [];
            $.each($("input[name='" + $(this).attr('name') + "']:checked"), function () {
                queryStringObject[name].push($(this).val());
            });
            if (queryStringObject[name].length == 0) {
                delete queryStringObject[name];
            }
        });
        var value = $('.getsort option:selected').val();
        var name = $('.getsort').attr('name');
        queryStringObject[name] = [value];
        if (value == "") {
            delete queryStringObject[name];
        }
        /*var minprice = $('#minprice').val();
        var maxprice= $('#maxprice').val();
        if(minprice!=""&& maxprice!=""){
          queryStringObject["minmax"] = [minprice+"-"+maxprice];
          if(minprice==""&& maxprice==""){
              delete queryStringObject["minmax"];
          }
        }*/
        if (type === "yes") {
            filterproducts(queryStringObject);
        }
    } else {
        filterproducts(queryStringObject);
    }
}

function filterproducts(queryStringObject) {
    /*$('.ListingLoader').show();*/
    $('body').css({ 'overflow': 'hidden' });
    let searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has('q')) {
        let parameterQuery = searchParams.get('q');
        var queryString = "?q=" + parameterQuery;
    } else {
        var queryString = "";
    }
    for (var key in queryStringObject) {
        if (queryString == '') {
            queryString += "?" + key + "=";
        } else {
            queryString += "&" + key + "=";
        }
        var queryValue = "";
        for (var i in queryStringObject[key]) {
            if (queryValue == '') {
                queryValue += queryStringObject[key][i];
            } else {
                queryValue += "~" + queryStringObject[key][i];
            }
        }
        queryString += queryValue;
    }
    if (history.pushState) {
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + queryString;
        newurl = newurl.replace("&undefined=undefined", "");
        window.history.pushState({ path: newurl }, '', newurl);
    }
    if (newurl.indexOf("?") >= 0) {
        newurl = newurl + "&json=";
    } else {
        newurl = newurl + "?json=";
    }
    $.ajax({
        url: newurl,
        type: 'get',
        dataType: 'json',
        success: function (resp) {
            $("#appendProducts").html(resp.view);
            /*$(this).resize();*/
            document.body.style.overflow = 'scroll';
        },
        error: function () { }
    });
}