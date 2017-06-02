App = {
    init: function () {
        console.log('init app.');
        $(document).ready(function () {
            if (typeof loadEditButton == 'function') {
                loadEditButton();
            }
            App.waitForElement('[data-toggle="tooltip"]', function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            })

            $('#pop-upModal, .modal #pop-upModal').on('click', function () {
                var params = {
                    'popupModal': true
                };

                if ($(this).attr('params') != undefined) {
                    var param = $('#pop-upModal').attr('params');
                    var oo = {};
                    param.split(',').forEach(function (x) {
                        var split = x.split(':');
                        oo[split[0]] = split[1];
                    });
                    $.extend(params, oo);
                }

                App.ajaxSend($(this).attr('data-url'), params);
            });
            //FANCYBOX
            //https://github.com/fancyapps/fancyBox
                App.waitForElement('.fancybox', function () {
                    $(".fancybox").fancybox({
        //                openEffect: "none",
        //                closeEffect: "none"
                    });
                });
            App.actionClick();
            App.animate();
            App.waitForElement('.edit-document', function () {
                $('.edit-document').on('click', function () {
                    App.ajaxSend($(this).attr('data-url'), {
                        'popupModal': true,
                        'dataController': $(this).attr('data-controller'),
                        'dataAction': $(this).attr('data-action'),
                        'dataId' : $(this).attr('data-id'),
                        'dataLanguage' : $('html').attr('lang')
                    });
                });
            });
        });

    },
    actionClick: function () {
        $('input, button, a').on('click', function () {
            App.formAjax($(this).parents('form'), {
                url: $(this).parents('form').attr('action')
            });
        });
    },
    waitForElement: function (elementPath, callBack) {
        window.setTimeout(function () {
            if ($(elementPath).length) {
                callBack(elementPath, $(elementPath));
            } else {
                App.waitForElement(elementPath, callBack);
            }
        }, 500)
    },
    validateEmail: function (id) {
        var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
        if (!email_regex.test($("#" + id).val())) {
            var div = $("#" + id).closest("div");
            div.removeClass("has-success");
            $("#glypcn" + id).remove();
            div.addClass("has-error has-feedback");
            div.append('<span id="glypcn' + id + '" class="glyphicon glyphicon-remove form-control-feedback"></span>');

            $("#" + id).attr("data-toggle", "tooltip").attr("data-placement", "left").attr("title", "Tooltip on left")
            return false;
        }
        else {
            var div = $("#" + id).closest("div");
            div.removeClass("has-error");
            $("#glypcn" + id).remove();
            div.addClass("has-success has-feedback");
            div.append('<span id="glypcn' + id + '" class="glyphicon glyphicon-ok form-control-feedback"></span>');
            return true;
        }
    },
    showModal: function (data, modalClass, back_redirect) {
        console.log(data);

        $('.modal').each(function (i, e) {
            if ($('.modal').is(':hidden')) {
                $(e).remove();
            }
        })

        $(data).modal().on('shown.bs.modal', function (e) {
            App.actionClick();
            App.waitForElement('#editor', function () {
                $('#editor').last().summernote(
                    {
                        height: 350,
                        lang: $('html').attr('lang') + '-' + $('html').attr('lang').toUpperCase(),
                        popover: {
                            image: [],
                            link: [],
                            air: []
                        }
                    }
                );
            });
            App.init();
        });
    },
    formAjax: function (elem, params) {

        if (params['cancel'] != undefined && params['cancel'] == true) {
            $(elem).find('#clear').click(function () {
                App.ajaxSend(params['url'], {'clear': 1});
            })
        }
        $(elem).unbind('submit').submit(function () {
            var data = $(elem).serializeArray();
            App.ajaxSend(params['url'], data);
            return false;
        });
        $('.onchange-submit').change(function (e) {
            $(e.target).closest('form').submit();
        });
    },
    ajaxSend: function (url, params, content, onSuccess, onError) {

       $('body').append("<div id=\"loader-backGround\" class=\"modal-backdrop fade in\"></div><div id=\"loader\"></div>");

        App.ajaxUrl = url;

        if (url.indexOf('javascript') >= 0) {
            return false;
        }
        var originalContent = content;
        content = content || '#body';
        onSuccess = onSuccess || false;
        onError = onError || false;
        var ajaxType = ($(params).length > 0) ? 'post' : 'get';
        $.ajax({
            url: url,
            type: ajaxType,
            data: params,
            error: function (data, status) {
                if (onError == false) {
                    alert('Server communication problem. ' + status);
                } else {
                    onError(data);
                }

                App.ajaxUrl = null;
            },
            success: function (data, status, jqXHR) {
                try {
                    eval('var datao = ' + data);

                    switch (datao.cmd) {
                        case 'redirect' :
                            document.location.href = datao.url;
                            return true;
                            break;
                        case 'break' :
                            if (originalContent) {
                                $(originalContent).modal('hide');
                            }
                            if (datao.extraCommand != undefined) {
                                eval(datao.extraCommand);
                                $('#loader-backGround, #loader').fadeOut().remove();
                            }
                            return true;
                            break;
                    }
                } catch (e) {
                }

                if (onSuccess == false) {
                    if (params.popupModal == true) {
                        App.showModal(data);
                        App.waitForElement('.modal',  function () {
                            if($('.modal').length > 0) {
                                App.waitForElement('.modal',  function () {
                                    $('#loader-backGround, #loader').fadeOut().remove();

                                })
                            } else{
                                $('#loader-backGround, #loader').fadeOut().remove();
                            }
                        });
                        return true;
                    } else {
                        $(content).html(data);
                    }
                } else {
                    onSuccess(data, status, jqXHR);
                }
                App.ajaxUrl = null;
                if($('.modal').length > 0) {
                    App.waitForElement('.modal',  function () {
                        $('#loader-backGround, #loader').fadeOut().remove();
                    })
                } else{
                    $('#loader-backGround, #loader').fadeOut().remove();
                }
            }
        });
    },
    clickAction: function (url, params) {
        if (url == undefined) {
            return true;
        }

        var urlA = url.split('__');
        if (urlA.length > 1) {
            $.each(urlA, function (k, v) {
                if (k % 2 == 1) {
                    if (params[v]) {
                        urlA[k] = params[v];
                    } else {
                        return false;
                    }
                }
            });
        }
        url = urlA.join('');

        App.ajaxSend(url, null, null, function (data, status, jqXHR) {

//                if (jqXHR.getResponseHeader('Content-type') == 'html/popup') {
            var patt = /(redirect\/false){1}/;
            App.showModal(data, undefined, patt.test(url) ? 'true' : undefined);
            // App.showModal(data);
//                } else {
//                    if (historyBack == true) {
//                        historyBack = false
//                    } else {
//                        if (App.browserIE != 9) {
//                            history.pushState({module: "leave"}, "", url);
//                        }
//                    }
//                    $('body').html(data);
//                }
        });
    },
    animate: function () {

        var introSection = $('#carousel-example-generic'),
            introSectionHeight = introSection.height(),
        //change scaleSpeed if you want to change the speed of the scale effect
            scaleSpeed = 0.3,
        //change opacitySpeed if you want to change the speed of opacity reduction effect
            opacitySpeed = 1;

        //update this value if you change this breakpoint in the style.css file (or _layout.scss if you use SASS)
        var MQ = 1170;

        triggerAnimation();
        $(window).on('resize', function () {
            triggerAnimation();
        });

        //bind the scale event to window scroll if window width > $MQ (unbind it otherwise)
        function triggerAnimation() {
            if ($(window).width() >= MQ) {
                $(window).on('scroll', function () {
                    //The window.requestAnimationFrame() method tells the browser that you wish to perform an animation- the browser can optimize it so animations will be smoother
                    window.requestAnimationFrame(animateIntro);
                });
            } else {
                $(window).off('scroll');
            }
        }

        //assign a scale transformation to the introSection element and reduce its opacity
        function animateIntro() {
            var scrollPercentage = ($(window).scrollTop() / introSectionHeight).toFixed(5),
                scaleValue = 1 - scrollPercentage * scaleSpeed;
            //check if the introSection is still visible
            if ($(window).scrollTop() < introSectionHeight) {
                introSection.css({
                    '-moz-transform': 'scale(' + scaleValue + ') translateZ(0)',
                    '-webkit-transform': 'scale(' + scaleValue + ') translateZ(0)',
                    '-ms-transform': 'scale(' + scaleValue + ') translateZ(0)',
                    '-o-transform': 'scale(' + scaleValue + ') translateZ(0)',
                    'transform': 'scale(' + scaleValue + ') translateZ(0)',
                    'opacity': 1 - scrollPercentage * opacitySpeed
                });
            }
        }

        /********************************
         open/close submenu on mobile
         ********************************/
        $('.cd-main-nav').on('click', function (event) {
            if ($(event.target).is('.cd-main-nav')) $(this).children('ul').toggleClass('is-visible');
        });
    }
}


//]]>
App.actionClick();