var fe = {
    init: function() {
        this.pages.all();
        this.browser();
    },
    pages: {
        all: function() {
            $('.bx-header-cart').on('click', function() {
                $('.cart-list', this).slideToggle();
            });

            if ($('#product-details').length > 0) {
                fe.pages.details();
            }
			$(".addWishList").on("click", function(){
				var that = this;
				var sku = $(that).parents("[data-sku]").data("sku");
				$.ajax({
					url: urlSite,
					method: "POST",
					data: { wishlist: sku }
				}).done(function(data){
					if ($(that).hasClass("far")) {
						$(that).addClass("fas").removeClass("far");
					} else {
						$(that).addClass("far").removeClass("fas");
					}
				})
				return false;
			});
            
            $('button.cart').on('click', function(){
                $(this).toggleClass('active');
            });
                $('.hamburger').on('click', function(){
                $(this).toggleClass('is-active');
                $('#category-list').toggleClass('active');
            });
            $('#category-list li a i').on('click', function(e){
                e.preventDefault();

                var subitems = $(this).parents('a').siblings('ul');
                var subitemsLink = $(this).parents('a');
                var hasSubitems = $(this).parents('a').siblings('ul').length;
                var subitemsOpened = $(this).parents('a').siblings('ul').hasClass('active');

                if(hasSubitems){
                    if (subitemsOpened) {
                        $(subitems).slideUp().removeClass('active');
                        $(subitemsLink).removeClass('active');
                    }
                    else {
                        $(subitems).slideDown().addClass('active');
                        $(subitemsLink).addClass('active');
                    }
                }
            });
        },
        details: function() {
            $('.bx-thumbnails img').on('click', function() {
                var img = $(this).attr('src');
                $('.img-main').attr('src', img);
            });
        }
    },
    browser: function() {
        var ua = { browser: undefined, mobile: undefined, os: undefined };
        ua.browser = (function() {
            if (window.ActiveXObject === undefined) {
                if (!!window.chrome) return 'chrome';
                if (!!window.sidebar) return 'firefox';
                if (!!window.opera || /opera|opr/i.test(navigator.userAgent)) return 'opera';
                if (/constructor/i.test(window.HTMLElement)) return 'safari';
            } else {
                if (document.all && !document.compatMode) return 'ie ie-older ie5';
                if (document.all && !window.XMLHttpRequest) return 'ie ie-older ie6';
                if (!document.querySelector) return 'ie ie-older ie7';
                if (!document.addEventListener) return 'ie ie-older ie8';
                if (!window.atob) return 'ie ie-newer ie9';
                if (!document.__proto__) return 'ie ie-newer ie10';
                if ('-ms-scroll-limit' in document.documentElement.style && '-ms-ime-align' in document.documentElement.style) return 'ie ie-newer ie11';
            }
        })();
        ua.mobile = (function() {
            if (navigator.userAgent.match(/Android/i) != null) return 'android';
            if (navigator.userAgent.match(/iPhone/i) != null) return 'iphone';
            if (navigator.userAgent.match(/iPad/i) != null) return 'ipad';
            if (navigator.userAgent.match(/iPod/i) != null) return 'ipod';
            if (navigator.userAgent.match(/IEMobile/i) != null) return 'iemobile';
            if (navigator.userAgent.match(/Opera Mini/i) != null) return 'opera-mini';
            if (navigator.userAgent.match(/BlackBerry/i) != null) return 'blackberry';
            else { return 'desktop' }
        })();
        ua.os = (function() {
            if (navigator.userAgent.match(/Macintosh/i) != null) return 'macintosh';
            if (navigator.userAgent.match(/Windows/i) != null) return 'windows';
            if (navigator.userAgent.match(/Linux/i) != null) return 'linux';
        })();
        $('main').addClass(ua.os).addClass(ua.browser).addClass(ua.mobile);
    }
}
$(document).ready(function() {
    fe.init();
});
//bx - header - cart