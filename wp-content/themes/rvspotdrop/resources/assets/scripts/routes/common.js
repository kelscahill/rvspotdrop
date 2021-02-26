/* eslint-disable */
let Rellax = require('rellax');
let rellax = new Rellax('.js-rellax');
import inView from 'in-view';

export default {
  init() {
    // JavaScript to be fired on all pages

    /**
    * Add inview class on scroll if has-animation class.
    */
    $(document).scroll(function() {
      $("*[data-animation]").each(function() {
        var animation = $(this).attr('data-animation');
        if (inView.is(this)) {
          $(this).addClass("is-inview");
          $(this).addClass(animation);
        }
      });
    });

    /**
    * Remove Active Classes when clicking outside menus and modals
    */
    $(document).click(function(event) {
      if (!$(event.target).closest(".c-nav-drawer").length) {
        $("html").find(".menu-is-active").removeClass("menu-is-active");
      }
    });

    // Expires after one day
    var setCookie = function(name, value) {
      var date = new Date(),
          expires = 'expires=';
      date.setDate(date.getDate() + 1);
      expires += date.toGMTString();
      document.cookie = name + '=' + value + '; ' + expires + '; path=/; SameSite=Strict;';
    }

    var getCookie = function(name) {
      var allCookies = document.cookie.split(';'),
        cookieCounter = 0,
        currentCookie = '';
      for (cookieCounter = 0; cookieCounter < allCookies.length; cookieCounter++) {
        currentCookie = allCookies[cookieCounter];
        while (currentCookie.charAt(0) === ' ') {
          currentCookie = currentCookie.substring(1, currentCookie.length);
        }
        if (currentCookie.indexOf(name + '=') === 0) {
          return currentCookie.substring(name.length + 1, currentCookie.length);
        }
      }
      return false;
    }

    $('.js-alert-close').click(function(e) {
      e.preventDefault();
      $('.js-alert').addClass('is-hidden');
      setCookie('alert', 'true');
    });

    var showAlert = function() {
      $('.js-alert').fadeIn();
      $('.js-alert').removeClass('is-hidden');
    }

    var hideAlert = function() {
      $('.js-alert').fadeOut();
      $('.js-alert').addClass('is-hidden');
    }

    if (getCookie('alert')) {
      hideAlert();
    } else {
      showAlert();
    }

    // Smooth scrolling on anchor clicks
    $(function() {
      $('a[href*="#"]:not([href="#"])').click(function() {
        $('.nav__primary, .nav-toggler').removeClass('main-nav-is-active');
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top - 50
            }, 1000);
            return false;
          }
        }
      });
    });

    /**
     * Slick sliders
     */
    $('.js-slick-testimonials').slick({
      arrows: false,
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 3,
      slidesToScroll: 3,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
        },
        {
          breakpoint: 850,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        }
      ]
    });

    var $slickGalleryImages = $('.js-product-gallery');
    var $slickGalleryNav = $('.js-product-gallery-nav');
    if ($slickGalleryImages.length) {
      $slickGalleryImages.slick({
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        dots: true,
        asNavFor: $slickGalleryNav
      });

      $slickGalleryNav.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: $slickGalleryImages,
        vertical: true,
        verticalSwiping: true,
        draggable: true,
        focusOnSelect: true,
      });
    }

    /**
     * General helper function to support toggle functions.
     */
    var toggleClasses = function(element) {
      var $this = element,
          $togglePrefix = $this.data('prefix') || 'this';

      // If the element you need toggled is relative to the toggle, add the
      // .js-this class to the parent element and "this" to the data-toggled attr.
      if ($this.data('toggled') == "this") {
        var $toggled = $this.closest('.js-this');
      }
      else {
        var $toggled = $('.' + $this.data('toggled'));
      }
      if ($this.attr('aria-expanded', 'true')) {
        $this.attr('aria-expanded', 'true')
      }
      else {
        $this.attr('aria-expanded', 'false')
      }
      $this.toggleClass($togglePrefix + '-is-active');
      $toggled.toggleClass($togglePrefix + '-is-active');

      // Remove a class on another element, if needed.
      if ($this.data('remove')) {
        $('.' + $this.data('remove')).removeClass($this.data('remove'));
      }
    };

    /*
     * Toggle Active Classes
     *
     * @description:
     *  toggle specific classes based on data-attr of clicked element
     *
     * @requires:
     *  'js-toggle' class and a data-attr with the element to be
     *  toggled's class name both applied to the clicked element
     *
     * @example usage:
     *  <span class="js-toggle" data-toggled="toggled-class">Toggler</span>
     *  <div class="toggled-class">This element's class will be toggled</div>
     *
     */
    $('.js-toggle').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      toggleClasses($(this));
    });

    // Toggle parent class
    $('.js-toggle-parent').on('click', function(e) {
      e.preventDefault();
      var $this = $(this);
      $this.toggleClass('this-is-active');
      $this.parent().toggleClass('this-is-active');
    });

    // Prevent bubbling to the body. Add this class to the element (or element
    // container) that should allow the click event.
    $('.js-stop-prop').on('click', function(e) {
      e.stopPropagation();
    });

    // Toggle hovered classes
    $('.js-hover').on('mouseenter mouseleave', function(e) {
      e.preventDefault();
      e.stopPropagation();
      toggleClasses($(this));
    });

    $('.js-hover-parent').on('mouseenter mouseleave', function(e) {
      e.preventDefault();
      var $this = $(this);
      $this.toggleClass('this-is-active');
      $this.parent().toggleClass('this-is-active');
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
