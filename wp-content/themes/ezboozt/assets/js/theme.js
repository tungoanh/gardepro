'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
    var OpalThemeBacktop = function () {
        function OpalThemeBacktop() {
            _classCallCheck(this, OpalThemeBacktop);

            this.initBacktotop();
        }

        _createClass(OpalThemeBacktop, [{
            key: 'initBacktotop',
            value: function initBacktotop() {
                jQuery(window).scroll(function () {
                    if (jQuery(this).scrollTop() > 200) {
                        jQuery('.scrollup').fadeIn();
                    } else {
                        jQuery('.scrollup').fadeOut();
                    }
                });
                jQuery('.scrollup').on('click', function () {
                    jQuery("html, body").animate({ scrollTop: 0 }, 600);
                    return false;
                });
            }
        }]);

        return OpalThemeBacktop;
    }();

    new OpalThemeBacktop();
    $('html').removeClass('no-js').addClass('js yes-js js_active');
    //class OpalThemeGallery {
    //    constructor() {
    //        if($('body.single .entry-content .gallery').length > 0){
    //            $('body.single .entry-content .gallery').magnificPopup({
    //                delegate: '.gallery-item a',
    //                type               : 'image',
    //                closeOnContentClick: true,
    //                closeBtnInside     : false,
    //                fixedContentPos    : true,
    //                mainClass          : 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
    //                image              : {
    //                    verticalFit: true
    //                },
    //                gallery: {
    //                    enabled: true,
    //                    navigateByImgClick: true,
    //                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    //                },
    //                zoom               : {
    //                    enabled : true,
    //                    duration: 300 // don't foget to change the duration also in CSS
    //                },
    //                open: function() {
    //                    //console.log('Popup is opened');
    //                },
    //                beforeOpen: function() {
    //                    //console.log('Start of popup initialization');
    //                },
    //
    //            });
    //        }
    //    }
    //}
    //new OpalThemeGallery();

    var OpalThemeLogin = function () {
        function OpalThemeLogin() {
            _classCallCheck(this, OpalThemeLogin);

            $('body').on('click', '.opal-login-form-ajax button[type="submit"]', function (event) {
                var $this = $(event.currentTarget);
                var $form = $this.closest('form');
                $.ajax({
                    type: 'POST',
                    url: woocs_ajaxurl,
                    data: $form.serialize(),
                    beforeSend: function beforeSend() {
                        $form.addClass('loading');
                        $form.find('.woocommerce-error').remove();
                        $form.find('input,button').prop('disabled', true);
                    },
                    success: function success(response) {
                        if (response.status) {
                            location.reload();
                        } else {
                            $form.before('<div class="woocommerce-error">' + response.msg + '</div>');
                        }
                    },
                    complete: function complete() {
                        $form.find('input,button').prop('disabled', false);
                        $form.removeClass('loading');
                    }
                });

                return false;
            });
        }

        _createClass(OpalThemeLogin, [{
            key: 'beforeSend',
            value: function beforeSend() {}
        }]);

        return OpalThemeLogin;
    }();

    new OpalThemeLogin();

    var OpalTheme_Main_Menu = function () {
        function OpalTheme_Main_Menu() {
            _classCallCheck(this, OpalTheme_Main_Menu);

            this.initSubmenuHover();
            this.initLogoInMenu();
        }

        _createClass(OpalTheme_Main_Menu, [{
            key: 'initLogoInMenu',
            value: function initLogoInMenu() {
                var $menu = $(".navigation-has-logo");
                if ($menu.length > 0) {
                    var $item = $menu.find('.mainmenu-container > ul > li'),
                        length = $item.length,
                        half = Math.ceil(length / 2),
                        left = 0,
                        right = 0;
                    $item.each(function (index, element) {
                        if (index < half) {
                            left += $(element).outerWidth();
                        } else {
                            right += $(element).outerWidth();
                        }
                    });
                    var widthLogo = $menu.find('.site-branding').outerWidth();
                    var redundancy = right - left;
                    var marginRight = widthLogo;
                    $menu.find('.mainmenu-container > ul').css('marginRight', -redundancy);
                    $($item.get(half - 1)).css('marginRight', marginRight);
                    $menu.addClass('menu-calculated');
                }
            }
        }, {
            key: 'initSubmenuHover',
            value: function initSubmenuHover() {
                var _this2 = this;

                var $item = $('li.megamenu-item');
                if ($item.hasClass('aligned-fullwidth')) {
                    var $parent = $item.closest('.custom-header > div , .site-header-desktop > div'),
                        Width = $parent.outerWidth();
                    $item.find('.submenu-fullwidth').css({
                        //width: Width
                    });
                }
                $(document).on('hover', 'li.megamenu-item', function (event) {
                    event.preventDefault();
                    var $item = $(event.currentTarget);
                    var level = $item.data('level');
                    if (!$item.hasClass('aligned-fullwidth')) {
                        if (level <= 0) {
                            _this2.setPositionLv1($item);
                        } else {
                            _this2.setPositionLvN($item);
                        }
                    } else {
                        if ($item.closest('.otf-vertical-menu').length > 0) {
                            _this2.setWidthVertical($item);
                        } else {
                            var _$parent = $item.closest('.container > div , .container-fluid > div'),

                            //Width          = $parent.outerWidth(),
                            position = $item.offset(),

                            //parentPosition = $parent.offset(),
                            left = -position.left;
                            $item.find('.submenu-fullwidth').css({
                                //width: Width,
                                left: left
                            });
                        }
                    }
                });
                $('.sub-menu-inner .menu-item-has-children').hover(function (event) {
                    var $item = $(event.currentTarget);
                    var level = $item.data('level');
                    if (!$item.hasClass('aligned-fullwidth')) {
                        _this2.setPositionLvN($item);
                    }
                }, function (event) {
                    $(event.currentTarget).children('.sub-menu').css({
                        left: '',
                        right: ''
                    });
                });
            }
        }, {
            key: 'setPositionLv1',
            value: function setPositionLv1($item) {
                var sub = $item.children('.sub-menu'),
                    offset = $item.offset(),
                    screen_width = $(window).width(),
                    sub_width = sub.outerWidth();
                var align_delta = offset.left + sub_width - screen_width;
                if (align_delta > 0) {
                    sub.css({ left: align_delta * -1 });
                }
            }
        }, {
            key: 'setPositionLvN',
            value: function setPositionLvN($item) {
                var sub = $item.children('.sub-menu'),
                    offset = $item.offset(),
                    width = $item.outerWidth(),
                    screen_width = $(window).width(),
                    sub_width = sub.outerWidth();
                var align_delta = offset.left + width + sub_width - screen_width;
                if (align_delta > 0) {
                    sub.css({ left: 'auto', right: '100%' });
                }
            }
        }, {
            key: 'setWidthVertical',
            value: function setWidthVertical($item) {
                var sub = $item.children('.sub-menu'),
                    width = $(window).width() - ($item.offset().left + $item.outerWidth());
                sub.css('width', width);
            }
        }]);

        return OpalTheme_Main_Menu;
    }();

    new OpalTheme_Main_Menu();

    var OpalThemeModal = function () {
        function OpalThemeModal() {
            _classCallCheck(this, OpalThemeModal);

            this.init();
        }

        _createClass(OpalThemeModal, [{
            key: 'init',
            value: function init() {
                var Modal = function Modal(element, options) {
                    this.options = options;
                    this.$body = $(document.body);
                    this.$element = $(element);
                    this.$dialog = this.$element.find('.modal-dialog');
                    this.$backdrop = null;
                    this.isShown = null;
                    this.originalBodyPad = null;
                    this.scrollbarWidth = 0;
                    this.ignoreBackdropClick = false;

                    if (this.options.remote) {
                        this.$element.find('.modal-content').load(this.options.remote, $.proxy(function () {
                            this.$element.trigger('loaded.bs.modal');
                        }, this));
                    }
                };

                Modal.VERSION = '3.3.7';

                Modal.TRANSITION_DURATION = 300;
                Modal.BACKDROP_TRANSITION_DURATION = 150;

                Modal.DEFAULTS = {
                    backdrop: true,
                    keyboard: true,
                    show: true
                };

                Modal.prototype.toggle = function (_relatedTarget) {
                    return this.isShown ? this.hide() : this.show(_relatedTarget);
                };

                Modal.prototype.show = function (_relatedTarget) {
                    var that = this;
                    var e = $.Event('show.bs.modal', { relatedTarget: _relatedTarget });

                    this.$element.trigger(e);

                    if (this.isShown || e.isDefaultPrevented()) return;

                    this.isShown = true;

                    this.checkScrollbar();
                    this.setScrollbar();
                    this.$body.addClass('modal-open');

                    this.escape();
                    this.resize();

                    this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this));

                    this.$dialog.on('mousedown.dismiss.bs.modal', function () {
                        that.$element.one('mouseup.dismiss.bs.modal', function (e) {
                            if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true;
                        });
                    });

                    this.backdrop(function () {
                        var transition = $.support.transition && that.$element.hasClass('fade');

                        if (!that.$element.parent().length) {
                            that.$element.appendTo(that.$body); // don't move modals dom position
                        }

                        that.$element.show().scrollTop(0);

                        that.adjustDialog();

                        if (transition) {
                            that.$element[0].offsetWidth; // force reflow
                        }

                        that.$element.addClass('show');

                        that.enforceFocus();

                        var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget });

                        transition ? that.$dialog // wait for modal to slide in
                        .one('bsTransitionEnd', function () {
                            that.$element.trigger('focus').trigger(e);
                        }).emulateTransitionEnd(Modal.TRANSITION_DURATION) : that.$element.trigger('focus').trigger(e);
                    });
                };

                Modal.prototype.hide = function (e) {
                    if (e) e.preventDefault();

                    e = $.Event('hide.bs.modal');

                    this.$element.trigger(e);

                    if (!this.isShown || e.isDefaultPrevented()) return;

                    this.isShown = false;

                    this.escape();
                    this.resize();

                    $(document).off('focusin.bs.modal');

                    this.$element.removeClass('show').off('click.dismiss.bs.modal').off('mouseup.dismiss.bs.modal');

                    this.$dialog.off('mousedown.dismiss.bs.modal');

                    $.support.transition && this.$element.hasClass('fade') ? this.$element.one('bsTransitionEnd', $.proxy(this.hideModal, this)).emulateTransitionEnd(Modal.TRANSITION_DURATION) : this.hideModal();
                };

                Modal.prototype.enforceFocus = function () {
                    $(document).off('focusin.bs.modal') // guard against infinite focus loop
                    .on('focusin.bs.modal', $.proxy(function (e) {
                        if (document !== e.target && this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                            this.$element.trigger('focus');
                        }
                    }, this));
                };

                Modal.prototype.escape = function () {
                    if (this.isShown && this.options.keyboard) {
                        this.$element.on('keydown.dismiss.bs.modal', $.proxy(function (e) {
                            e.which == 27 && this.hide();
                        }, this));
                    } else if (!this.isShown) {
                        this.$element.off('keydown.dismiss.bs.modal');
                    }
                };

                Modal.prototype.resize = function () {
                    if (this.isShown) {
                        $(window).on('resize.bs.modal', $.proxy(this.handleUpdate, this));
                    } else {
                        $(window).off('resize.bs.modal');
                    }
                };

                Modal.prototype.hideModal = function () {
                    var that = this;
                    this.$element.hide();
                    this.backdrop(function () {
                        that.$body.removeClass('modal-open');
                        that.resetAdjustments();
                        that.resetScrollbar();
                        that.$element.trigger('hidden.bs.modal');
                    });
                };

                Modal.prototype.removeBackdrop = function () {
                    this.$backdrop && this.$backdrop.remove();
                    this.$backdrop = null;
                };

                Modal.prototype.backdrop = function (callback) {
                    var that = this;
                    var animate = this.$element.hasClass('fade') ? 'fade' : '';

                    if (this.isShown && this.options.backdrop) {
                        var doAnimate = $.support.transition && animate;

                        this.$backdrop = $(document.createElement('div')).addClass('modal-backdrop ' + animate).appendTo(this.$body);

                        this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
                            if (this.ignoreBackdropClick) {
                                this.ignoreBackdropClick = false;
                                return;
                            }
                            if (e.target !== e.currentTarget) return;
                            this.options.backdrop == 'static' ? this.$element[0].focus() : this.hide();
                        }, this));

                        if (doAnimate) this.$backdrop[0].offsetWidth; // force reflow

                        this.$backdrop.addClass('show');

                        if (!callback) return;
                        doAnimate ? this.$backdrop.one('bsTransitionEnd', callback).emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) : callback();
                    } else if (!this.isShown && this.$backdrop) {
                        this.$backdrop.removeClass('show');

                        var callbackRemove = function callbackRemove() {
                            that.removeBackdrop();
                            callback && callback();
                        };
                        $.support.transition && this.$element.hasClass('fade') ? this.$backdrop.one('bsTransitionEnd', callbackRemove).emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) : callbackRemove();
                    } else if (callback) {
                        callback();
                    }
                };

                // these following methods are used to handle overflowing modals

                Modal.prototype.handleUpdate = function () {
                    this.adjustDialog();
                };

                Modal.prototype.adjustDialog = function () {
                    var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight;

                    this.$element.css({
                        paddingLeft: !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
                        paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
                    });
                };

                Modal.prototype.resetAdjustments = function () {
                    this.$element.css({
                        paddingLeft: '',
                        paddingRight: ''
                    });
                };

                Modal.prototype.checkScrollbar = function () {
                    var fullWindowWidth = window.innerWidth;
                    if (!fullWindowWidth) {
                        // workaround for missing window.innerWidth in IE8
                        var documentElementRect = document.documentElement.getBoundingClientRect();
                        fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left);
                    }
                    this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth;
                    this.scrollbarWidth = this.measureScrollbar();
                };

                Modal.prototype.setScrollbar = function () {
                    var bodyPad = parseInt(this.$body.css('padding-right') || 0, 10);
                    this.originalBodyPad = document.body.style.paddingRight || '';
                    if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth);
                };

                Modal.prototype.resetScrollbar = function () {
                    this.$body.css('padding-right', this.originalBodyPad);
                };

                Modal.prototype.measureScrollbar = function () {
                    // thx walsh
                    var scrollDiv = document.createElement('div');
                    scrollDiv.className = 'modal-scrollbar-measure';
                    this.$body.append(scrollDiv);
                    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
                    this.$body[0].removeChild(scrollDiv);
                    return scrollbarWidth;
                };

                // MODAL PLUGIN DEFINITION
                // =======================

                function Plugin(option, _relatedTarget) {
                    return this.each(function () {
                        var $this = $(this);
                        var data = $this.data('bs.modal');
                        var options = $.extend({}, Modal.DEFAULTS, $this.data(), (typeof option === 'undefined' ? 'undefined' : _typeof(option)) === 'object' && option);

                        if (!data) $this.data('bs.modal', data = new Modal(this, options));
                        if (typeof option === 'string') data[option](_relatedTarget);else if (options.show) data.show(_relatedTarget);
                    });
                }

                var old = $.fn.modal;

                $.fn.modal = Plugin;
                $.fn.modal.Constructor = Modal;

                // MODAL NO CONFLICT
                // =================

                $.fn.modal.noConflict = function () {
                    $.fn.modal = old;
                    return this;
                };

                // MODAL DATA-API
                // ==============

                $(document).on('click.bs.modal.data-api', '[data-toggle="opal-modal"]', function (e) {
                    var $this = $(this);
                    var href = $this.attr('href');
                    var $target = $($this.attr('data-target') || href && href.replace(/.*(?=#[^\s]+$)/, '')); // strip for ie7
                    var option = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data());

                    if ($this.is('a')) e.preventDefault();

                    $target.one('show.bs.modal', function (showEvent) {
                        if (showEvent.isDefaultPrevented()) return; // only register focus restorer if modal will actually get shown
                        $target.one('hidden.bs.modal', function () {
                            $this.is(':visible') && $this.trigger('focus');
                        });
                    });
                    Plugin.call($target, option, this);
                });
            }
        }]);

        return OpalThemeModal;
    }();

    var OpalThemeNavigation = function OpalThemeNavigation() {
        _classCallCheck(this, OpalThemeNavigation);
    };

    new OpalThemeNavigation();

    var OpalThemeOwlCarousel = function () {
        function OpalThemeOwlCarousel() {
            _classCallCheck(this, OpalThemeOwlCarousel);

            this.initGalleryCarousel();
        }

        _createClass(OpalThemeOwlCarousel, [{
            key: 'initGalleryCarousel',
            value: function initGalleryCarousel() {
                $('.entry-gallery .gallery').owlCarousel({
                    items: 1,
                    nav: true,
                    dots: false,
                    autoHeight: true
                });
            }
        }]);

        return OpalThemeOwlCarousel;
    }();

    new OpalThemeOwlCarousel();

    $(document).ready(function () {
        var $height = $('#masthead').height() + $('#colophon').height() + $('#page-title-bar').height();
        var $Content = $('.site-content-contain');
        $height = $(window).height() - $height;
        var $heightContent = $Content.height();
        if ($height > $heightContent) {
            $Content.animate({ height: $height }, 1000);
        }
    });

    var OpalThemePortfolio = function () {
        function OpalThemePortfolio() {
            _classCallCheck(this, OpalThemePortfolio);

            if ($('body [isotope-filter]').length > 0) {
                this.init();
            }
        }

        _createClass(OpalThemePortfolio, [{
            key: 'init',
            value: function init() {

                $('.fil-cat a').on('click', function (event) {
                    event.preventDefault();
                    var $button = $(event.currentTarget);
                    var selectedClass = $button.attr("data-rel");
                    var $container = $button.closest('.portfolio-container');

                    console.log(selectedClass);
                });
            }
        }]);

        return OpalThemePortfolio;
    }();

    new OpalThemePortfolio();
    function opalAddQuantityBoxes() {
        var $quantitySelector = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '.qty';


        var $quantityBoxes = void 0;

        $quantityBoxes = $('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').find($quantitySelector);

        if ($quantityBoxes && 'date' != $quantityBoxes.prop('type')) {

            // Add plus and minus boxes
            $quantityBoxes.parent().addClass('buttons_added').prepend('<input type="button" value="-" class="minus" />');
            $quantityBoxes.addClass('input-text').after('<input type="button" value="+" class="plus" />');

            // Target quantity inputs on product pages
            $('input' + $quantitySelector + ':not(.product-quantity input' + $quantitySelector + ')').each(function () {
                var $min = parseFloat($(this).attr('min'));

                if ($min && $min > 0 && parseFloat($(this).val()) < $min) {
                    $(this).val($min);
                }
            });

            $('.plus, .minus').unbind('click');

            $('.plus, .minus').on('click', function () {

                // Get values
                var $quantityBox = $(this).parent().find($quantitySelector),
                    $currentQuantity = parseFloat($quantityBox.val()),
                    $maxQuantity = parseFloat($quantityBox.attr('max')),
                    $minQuantity = parseFloat($quantityBox.attr('min')),
                    $step = $quantityBox.attr('step');

                // Fallback default values
                if (!$currentQuantity || '' === $currentQuantity || 'NaN' === $currentQuantity) {
                    $currentQuantity = 0;
                }
                if ('' === $maxQuantity || 'NaN' === $maxQuantity) {
                    $maxQuantity = '';
                }

                if ('' === $minQuantity || 'NaN' === $minQuantity) {
                    $minQuantity = 0;
                }
                if ('any' === $step || '' === $step || undefined === $step || 'NaN' === parseFloat($step)) {
                    $step = 1;
                }

                // Change the value
                if ($(this).is('.plus')) {

                    if ($maxQuantity && ($maxQuantity == $currentQuantity || $currentQuantity > $maxQuantity)) {
                        $quantityBox.val($maxQuantity);
                    } else {
                        $quantityBox.val($currentQuantity + parseFloat($step));
                    }
                } else {

                    if ($minQuantity && ($minQuantity == $currentQuantity || $currentQuantity < $minQuantity)) {
                        $quantityBox.val($minQuantity);
                    } else if ($currentQuantity > 0) {
                        $quantityBox.val($currentQuantity - parseFloat($step));
                    }
                }

                // Trigger change event
                $quantityBox.trigger('change');
            });
        }
    }
    $(document).ready(function () {
        opalAddQuantityBoxes();
    });
    $(document).ajaxComplete(function () {
        opalAddQuantityBoxes();
    });

    var OpalThemeSmoothMenu = function () {
        function OpalThemeSmoothMenu() {
            var _this3 = this;

            _classCallCheck(this, OpalThemeSmoothMenu);

            ezbooztJS.smoothCallback = function (selector) {
                $('.opal-smooth-menu a[href^="' + selector + '"]').trigger('click');
            };

            $('body').on('click', '.opal-smooth-menu a[href^="#"]', function (e) {
                e.preventDefault();
                _this3.menuActiveClass(e);
                var target = e.currentTarget.hash;
                var $target = $(target);
                if ($target.length > 0) {
                    $('html, body').animate({
                        'scrollTop': $target.offset().top - _this3.getOffset()
                    }, 600, 'swing');
                }
            });
        }

        _createClass(OpalThemeSmoothMenu, [{
            key: 'menuActiveClass',
            value: function menuActiveClass(e) {
                var $this = $(e.currentTarget);
                $('.opal-smooth-menu').find('li.menu-item').removeClass('current-menu-item current_page_item');
                var selector = $this.closest('li').attr('id');
                $('.opal-smooth-menu [id="' + selector + '"]').addClass('current-menu-item');
            }
        }, {
            key: 'getOffset',
            value: function getOffset() {
                var offset = 0;
                var $adminBar = $('#wpadminbar');
                var $stickyHeader = $('#opal-header-sticky');

                if ($adminBar.length > 0) {
                    offset += $adminBar.outerHeight();
                }

                if ($stickyHeader.length > 0) {
                    offset += $stickyHeader.outerHeight();
                }

                return offset;
            }
        }]);

        return OpalThemeSmoothMenu;
    }();

    new OpalThemeSmoothMenu();

    var OpalThemeToogle = function () {
        function OpalThemeToogle() {
            _classCallCheck(this, OpalThemeToogle);

            this.setupHeader();
            this.toggleCollapse();
            this.ToggleCanvasFilter();
            this.PositionAccount();
        }

        _createClass(OpalThemeToogle, [{
            key: 'setupHeader',
            value: function setupHeader() {
                $('#masthead .search-button[data-search-toggle]').each(function (index, element) {
                    var $button = $(element);
                    if ($button.hasClass('top-to-bottom') || $button.hasClass('popup')) {
                        var $searchform = $($button.data('target'));
                        $searchform.data('height', $searchform.outerHeight()).prependTo('#page').addClass('loaded');
                    } else if ($button.hasClass('bottom-to-top')) {
                        var _$searchform = $($button.data('target'));
                        _$searchform.data('height', _$searchform.outerHeight()).prependTo('#page');
                    }
                });
            }
        }, {
            key: 'toggleCollapse',
            value: function toggleCollapse() {
                var _this4 = this;

                $('body').on('click', '[data-search-toggle="toggle"]', function (e) {
                    e.preventDefault();
                    var $button = $(e.currentTarget);
                    var $searchForm = $($button.data('target'));
                    var $buttonClose = $searchForm.find('[data-search-toggle="close"]');
                    $buttonClose.on('click', function (e) {
                        $button.removeClass('active');
                        $searchForm.removeClass('active');
                        $('body').removeClass('over-hidden');
                        if ($buttonClose.closest('.bottom-to-top')) {
                            $searchForm.css('top', '100%');
                        }
                    });
                    if ($button.is('.top-to-bottom, .bottom-to-top, .popup')) {
                        $searchForm.toggleClass('active');
                        $button.toggleClass('active');
                        setTimeout(function () {
                            $searchForm.find('.dgwt-wcas-search-input').focus().val('');
                        }, 1000);
                    }
                    if ($button.hasClass('top-to-bottom')) {
                        _this4.setupTopToBottom($button, $searchForm);
                    } else if ($button.hasClass('bottom-to-top')) {
                        _this4.setupBottomToTop($button, $searchForm);
                    } else if ($button.hasClass('popup')) {
                        _this4.setupFullScreen($button, $searchForm);
                    } else {
                        $button.toggleClass('active');
                        $button.siblings($searchForm).toggleClass('active');
                        $(document.createElement('div')).addClass('dropdown-backdrop').insertAfter($button.siblings($searchForm)).on('click', function () {
                            $(this).siblings().removeClass("active");
                            $(this).remove();
                        });
                    }
                })
                // Cart
                .on('click', '[data-toggle="toggle"]', function (e) {
                    e.preventDefault();
                    var $button = $(e.currentTarget),
                        $parent = $button.closest('.site-header-cart'),
                        $content = $parent.find('.shopping_cart'),
                        position = $content.offset(),
                        height = $(window).height() - (position.top - $(window).scrollTop());
                    $content.css({
                        'max-height': height,
                        'overflow': 'auto'
                    });
                    $parent.toggleClass("active");
                    $button.toggleClass("active");
                    $(document.createElement('div')).addClass('dropdown-backdrop').insertAfter($parent).on('click', function () {
                        $parent.removeClass("active");
                        $(this).remove();
                    });
                });
            }
        }, {
            key: 'checkScroll',
            value: function checkScroll($object) {
                var element = $object.get(0);
                return element.scrollHeight > $(window).height();
            }
        }, {
            key: 'setupFullScreen',
            value: function setupFullScreen($button, $searchForm) {
                var $body = $('body');
                if (this.checkScroll($body)) {
                    $body.toggleClass('over-hidden');
                }
            }
        }, {
            key: 'setupTopToBottom',
            value: function setupTopToBottom($button, $searchForm) {
                $('body').animate({ scrollTop: 0 }, 600);
            }
        }, {
            key: 'setupBottomToTop',
            value: function setupBottomToTop($button, $searchForm) {
                var $header = $('.site-header'),
                    $sticky = $('.sticky-show'),
                    stickyHeight = $sticky.outerHeight(),
                    adminbarHeight = $('#wpadminbar').height(),
                    position = $header.height() + adminbarHeight;
                if (stickyHeight > 1) {
                    position = stickyHeight + adminbarHeight;
                }
                if ($searchForm.hasClass('active')) {
                    $searchForm.css('top', position);
                } else {
                    $searchForm.css('top', '100%');
                }
                var $body = $('body');
                if (this.checkScroll($body)) {
                    $body.toggleClass('over-hidden');
                }
            }
        }, {
            key: 'ToggleCanvasFilter',
            value: function ToggleCanvasFilter() {
                // Return early if menuToggle is missing.
                if (!$('.filter-toggle').length) {
                    return;
                }
                // Add an initial value for the attribute.

                $('body').on('click', '.opal-overlay-filter , .filter-close', function () {
                    $('body').removeClass('opal-canvas-filter-open');
                    $('.filter-toggle').removeClass('active');
                });

                $('body').on('click', '.filter-toggle', function (event) {
                    var filterToggle = $(event.currentTarget);
                    var $body = $('body');
                    if ($body.hasClass('opal-canvas-filter-open')) {
                        filterToggle.removeClass('active');
                        $body.removeClass('opal-canvas-filter-open');
                        $body.find('.opal-canvas-filter.top').removeClass('canvas-filter-open').css({ 'max-height': '0' });
                    } else {
                        filterToggle.addClass('active');
                        var h = $body.find('.opal-canvas-filter.top .opal-canvas-filter-wrap').height() + 60;
                        $body.addClass('opal-canvas-filter-open');
                        $body.find('.opal-canvas-filter.top').addClass('canvas-filter-open').css({ 'max-height': h });
                    }
                });
            }
        }, {
            key: 'PositionAccount',
            value: function PositionAccount() {
                $('body').on('hover', '.site-header-account', function () {
                    var $drop = $(this).find('.account-dropdown'),
                        position = $drop.offset().top - $(window).scrollTop() + $drop.outerHeight(true),
                        top = position - $(window).height();
                    if (top > 0) {
                        $drop.css({
                            'transform': 'translateY( -' + top + 'px)'
                        });
                    }
                });
            }
        }]);

        return OpalThemeToogle;
    }();

    $(document).ready(function () {
        new OpalThemeToogle();
    });

    var OpalThemeTooltip = function () {
        function OpalThemeTooltip() {
            _classCallCheck(this, OpalThemeTooltip);

            this.initTooltip();
        }

        _createClass(OpalThemeTooltip, [{
            key: 'initTooltip',
            value: function initTooltip() {
                tippy('.otf-tooltip', {
                    arrow: true,
                    animation: 'fade',
                    size: 'small'
                });
            }
        }]);

        return OpalThemeTooltip;
    }();

    new OpalThemeTooltip();

    $(document).ready(function () {
        $('.otf-video-poster-wrapper').on('click', function () {
            var videoWrapper = $(this),
                video = videoWrapper.siblings('iframe'),
                videoScr = video.attr('src'),
                videoNewSrc = videoScr + '&autoplay=1';

            if (videoScr.indexOf('vimeo.com') + 1) {
                videoNewSrc = videoScr + '?autoplay=1';
            }
            video.attr('src', videoNewSrc);
            videoWrapper.addClass('hidden-poster');
        });
    });

    var OpalTheme_Woocommerce_filter = function () {
        function OpalTheme_Woocommerce_filter() {
            var _this5 = this;

            _classCallCheck(this, OpalTheme_Woocommerce_filter);

            this.selectorsClick = [];
            this.selectorsChange = [];

            this.selectorsClick = ['#secondary .widget .product-categories a', '#secondary .widget .product-brands a', '#secondary .widget .woocommerce-widget-layered-nav-list a', '#secondary .widget.widget_layered_nav_filters a', '#secondary .widget.widget_rating_filter a', '#secondary .widget_product_tag_cloud a', '#opal-canvas-filter .widget .product-categories a', '#opal-canvas-filter .widget .product-brands a', '#opal-canvas-filter .widget .woocommerce-widget-layered-nav-list a', '#opal-canvas-filter .widget.widget_layered_nav_filters a', '#opal-canvas-filter .widget.widget_rating_filter a', '#opal-canvas-filter .widget_product_tag_cloud a', '#main ul.products + .woocommerce-pagination a', '#secondary .widget .product-brands a', '.otf-active-filters .widget_layered_nav_filters a', '.otf-active-filters .clear-all'];
            this.initDisplayMode();
            this.init();
            this.initCategoriesDropdown();
            this.initRecentlyReviewed();
            this.priceSlideChange();
            this.initOrdering();

            $(window).on("popstate", function () {
                if (history.state && history.state.woofilter) {
                    _this5.renderHtml(history.state);
                }
            });
        }

        _createClass(OpalTheme_Woocommerce_filter, [{
            key: 'init',
            value: function init() {
                var _this6 = this;

                $('body').on('click', this.selectorsClick.join(','), function (event) {
                    event.preventDefault();
                    var $this = $(event.currentTarget);
                    var url = $this.attr('href');
                    _this6.sendRequest(url);
                }).on('click', '.display-mode button[type="submit"]', function (event) {
                    event.preventDefault();
                    var $this = $(event.currentTarget);
                    if (!$this.hasClass('active')) {
                        var value = $this.val();
                        var objUrl = new URL(window.location.href);
                        var searchParams = new URLSearchParams(window.location.search);
                        searchParams.set('display', value);
                        objUrl.search = searchParams.toString();
                        _this6.sendRequest(objUrl.toString(), false);
                    }
                });
            }
        }, {
            key: 'scrollUp',
            value: function scrollUp() {

                var position = $('#primary').offset().top;
                if ($('body').hasClass('opal-header-sticky')) {
                    position -= $('#opal-header-sticky').outerHeight();
                }

                if ($('#wpadminbar').length > 0) {
                    position -= $('#wpadminbar').outerHeight();
                }
                if ($(window).scrollTop() > position) {
                    $('html, body').animate({ scrollTop: position }, 'slow');
                }
            }
        }, {
            key: 'replaceUrl',
            value: function replaceUrl(url) {
                var layout = this.getCookie('otf_woocommerce_display', 'grid');
                if (layout === 'list') {
                    if (url.indexOf('?') !== -1) {
                        url = url + '&display=list';
                    } else {
                        url = url + '?display=list';
                    }
                }

                return url;
            }
        }, {
            key: 'initDisplayMode',
            value: function initDisplayMode() {
                if ($('body').hasClass('opal-woocommerce-archive')) {
                    var display = this.getCookie('otf_woocommerce_display', 'grid');
                    if (display === 'list') {
                        var url = window.location.href;
                        var objUrl = new URL(url);
                        var dp = objUrl.searchParams.get("display");
                        if (!dp) {
                            this.sendRequest(url);
                        }
                    }
                }
            }
        }, {
            key: 'sendRequest',
            value: function sendRequest(url) {
                var _this7 = this;

                var replace = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

                if (replace) {
                    url = this.replaceUrl(url);
                }
                console.log(url);
                this.initLoading(true);
                $.post(url, function (data) {
                    if (data) {
                        var $html = $(data);
                        var state = {
                            woofilter: true,
                            title: $html.filter('title').text(),
                            sidebar: $html.find('#secondary').html(),
                            content: $html.find('#primary').html(),
                            filter: $html.find('.opal-canvas-filter-wrap').html()
                        };
                        _this7.renderHtml(state);
                        window.history.pushState(state, state.title, url);
                    }
                    _this7.initLoading(false);
                });
            }
        }, {
            key: 'renderHtml',
            value: function renderHtml(state) {
                this.scrollUp();
                $('head title').text(state.title);
                $('#primary').html(state.content);
                $('#secondary').html(state.sidebar);
                $('#opal-canvas-filter .opal-canvas-filter-wrap').html(state.filter);
                this.initPriceSlider();
                this.initCategoriesDropdown();
                this.initOrdering();
                this.initLoading(false);
            }
        }, {
            key: 'initLoading',
            value: function initLoading(check) {
                if (check) {
                    $('body').addClass('opal-filter-loading').append('<div id="opal-woocommerce-loading"></div>');
                } else {
                    $('body').removeClass('opal-filter-loading');
                    $('#opal-woocommerce-loading').remove();
                }
            }
        }, {
            key: 'initRecentlyReviewed',
            value: function initRecentlyReviewed() {
                var recentlyTitle = $('h2.otf-woocommerce-recently-viewed');
                var recentlyContent = $('.otf-product-recently-content');
                recentlyContent.hide();

                recentlyTitle.on('click', function () {
                    if (!recentlyTitle.hasClass('active')) {
                        recentlyContent.show(400);
                        recentlyTitle.addClass('active');
                        var scrollHeight = $(document).height();
                        var contentHeight = $('.widget_recently_viewed_products').height();
                        $("html, body").animate({ scrollTop: scrollHeight }, contentHeight + 10);
                    } else {
                        recentlyContent.hide(400);
                        recentlyTitle.removeClass('active');
                    }
                });
            }
        }, {
            key: 'initCategoriesDropdown',
            value: function initCategoriesDropdown() {
                $('.widget_product_categories ul li.cat-item').each(function () {
                    var _this = $(this);
                    _this.find('ul.children').hide();
                    if (_this.find('.current-cat').length > 0) {
                        _this.find('ul.children').show();
                        $(this).append('<i class="opened icon icon-558"></i>');
                    } else if (_this.find('ul.children').length > 0) {
                        $(this).append('<i class="closed icon icon-559"></i>');
                    }
                });
                $("body").on("click", '.widget_product_categories ul li.cat-item .closed', function () {
                    $(this).parent().find('ul.children').first().show(400);
                    $(this).parent().addClass('open');
                    $(this).removeClass('closed').removeClass('icon-559').addClass('opened').addClass('icon-558');
                });
                $("body").on("click", '.widget_product_categories ul li.cat-item .opened', function () {
                    $(this).parent().find('ul.children').first().hide(400);
                    $(this).parent().addClass('close').removeClass('open');
                    $(this).removeClass('opened').removeClass('icon-558').addClass('closed').addClass('icon-559');
                });
            }
        }, {
            key: 'initOrdering',
            value: function initOrdering() {
                var _this8 = this;

                setTimeout(function () {
                    $('.woocommerce-ordering').off('change');
                    $('.woocommerce-ordering').on('change', function (event) {
                        var $select = $(event.currentTarget).find('.orderby');
                        var url = window.location.href.replace(/&orderby(=[^&]*)?|^orderby(=[^&]*)?&?/g, '').replace(/\?orderby(=[^&]*)?|^orderby(=[^&]*)?&?/g, '?').replace(/\?$/g, '');

                        if (url.indexOf('?') !== -1) {
                            url = url + ('&orderby=' + $select.val());
                        } else {
                            url = url + ('?orderby=' + $select.val());
                        }
                        _this8.sendRequest(url);
                    });
                }, 100);
            }
        }, {
            key: 'initPriceSlider',
            value: function initPriceSlider() {
                setTimeout(function () {
                    if ($('.price_slider:not(.ui-slider)').length <= 0) {
                        return true;
                    }
                    $('input#min_price, input#max_price').hide();
                    $('.price_slider, .price_label').show();

                    var min_price = $('.price_slider_amount #min_price').data('min'),
                        max_price = $('.price_slider_amount #max_price').data('max'),
                        current_min_price = $('.price_slider_amount #min_price').val(),
                        current_max_price = $('.price_slider_amount #max_price').val();

                    $('.price_slider:not(.ui-slider)').slider({
                        range: true,
                        animate: true,
                        min: min_price,
                        max: max_price,
                        values: [current_min_price, current_max_price],
                        create: function create() {

                            $('.price_slider_amount #min_price').val(current_min_price);
                            $('.price_slider_amount #max_price').val(current_max_price);

                            $(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
                        },
                        slide: function slide(event, ui) {

                            $('input#min_price').val(ui.values[0]);
                            $('input#max_price').val(ui.values[1]);

                            $(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
                        },
                        change: function change(event, ui) {

                            $(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
                        }
                    });
                }, 200);
            }
        }, {
            key: 'priceSlideChange',
            value: function priceSlideChange() {
                var _this9 = this;

                $(document.body).bind('price_slider_change', function (event, min, max) {
                    var url = window.location.href.replace(/(min_price=\d+\&*|max_price=\d+\&*)/g, '').replace(/\?$/g, '');
                    if (url.indexOf('?') !== -1) {
                        url = url + ('&min_price=' + min + '&max_price=' + max);
                    } else {
                        url = url + ('?min_price=' + min + '&max_price=' + max);
                    }
                    _this9.sendRequest(url);
                });
            }
        }, {
            key: 'getCookie',
            value: function getCookie(cname, _default) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) === 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
        }, {
            key: 'setCookie',
            value: function setCookie(cname, cvalue) {
                var exdays = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 10;

                var d = new Date();
                d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
        }]);

        return OpalTheme_Woocommerce_filter;
    }();

    new OpalTheme_Woocommerce_filter();
})(jQuery);
//# sourceMappingURL=theme.js.map
