App = {
    init: function () {
        
        $(document).ready(function () {
            $('#body').css({'padding-top':$('.navbar-top').height()+'px', 'padding-bottom':$('.footer').height()+'px'});
            if (typeof loadEditButton == 'function') {
                loadEditButton();
            }
            App.waitForElement('[data-toggle="tooltip"]', function () {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                });
            })
            $('.order_position').on('focus', function() {
                before = $(this).html();
            }).on('focusout', function() {
                if (before != $(this).html()) { $(this).trigger('change'); }
            });

            $('.order_position').on('change', function() {
                var $this = $(this);
                if($.isNumeric($this.html())) {
                    var params = {
                        order: $this.html(),
                        content_id: $this.attr('data-id'),
                        table: $this.attr('table')
                    };
                    App.ajaxSend($(this).attr('data-url'), params);
                }else{
                    alert('Is not numeric')
                }

            });

            $(document).undelegate('#pop-upModal, .modal #pop-upModal').delegate('#pop-upModal, .modal #pop-upModal', 'click', function () {
                var params = {
                    'popupModal': true
                };

                if ($(this).attr('params') != undefined) {
                    var param = $('#pop-upModal').attr('params');
                    if($(this).attr('params') != undefined) {
                         param = $(this).attr('params');
                    }
                    var oo = {};
                    if (param.indexOf(',')) {
                    param.split(',').forEach(function (x) {
                        var split = x.split(':');
                        oo[split[0]] = split[1];
                    });
                    } else {
                        var split = param.split(':');
                        oo[split[0]] = split[1];
                    }
                    $.extend(params, oo);
                }
                App.ajaxSend($(this).attr('data-url'), params);
            });
            //FANCYBOX
            //https://github.com/fancyapps/fancyBox
            App.waitForElement('.fancybox', function () {
                $(".fancybox").fancybox({
                    openEffect  : 'none',
                    loop        : true,
                    preload:    3,
                    closeEffect : 'none',
                    helpers : {
                        title: {
                            type: 'inside'
                        }
                    }
                    //                openEffect: "none",
                    //                closeEffect: "none"
                });
            });
//            App.actionClick();
            App.animate();
            App.waitForElement('.edit-document', function () {
                $(document).undelegate('.edit-document').delegate('.edit-document', 'click', function () {
                    App.ajaxSend($(this).attr('data-url'), {
                        'popupModal': true,
                        'dataController': $(this).attr('data-controller'),
                        'dataAction': $(this).attr('data-action'),
                        'dataId': $(this).attr('data-id'),
                        'dataLanguage': $('html').attr('lang')
                    });
                });
            });
            $('#body').css({'min-height': $('#body').outerHeight()-$('#contact-us-sec').outerHeight()+'px'})
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
        if (!email_regex.test($("#" + id).val()) && !App.serErrorfield(id)) return false;
        App.serSuccessfield(id);
        return true;
    },
    validateField: function (id) {
        if($("#" + id).val() == '' && !App.serErrorfield(id)) return false;
        App.serSuccessfield(id);
        return true;
    },
    serErrorfield: function (id) {
        var div = $("#" + id).closest("div");
        div.removeClass("has-success");
        $("#glypcn" + id).remove();
        div.addClass("has-error has-feedback");
        div.append('<span id="glypcn' + id + '" class="fa fa-ban form-control-feedback"></span>');
        return false;
    },
    serSuccessfield: function (id) {
        var div = $("#" + id).closest("div");
        div.removeClass("has-error");
        $("#glypcn" + id).remove();
        div.addClass("has-success has-feedback");
        div.append('<span id="glypcn' + id + '" class="fa fa-check-square-o form-control-feedback"></span>');
        return true;
    },
    showModal: function (data, modalClass, back_redirect) {
        $('.modal').each(function (i, e) {
            if ($('.modal, .modal-backdrop').is(':hidden')) {
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
                    if (typeof loadEditButton == 'function') {
                        loadEditButton();
                    }
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
                        App.waitForElement('.modal', function () {
                            if ($('.modal').length > 0) {
                                App.waitForElement('.modal', function () {
                                    $('#loader-backGround, #loader').fadeOut().remove();

                                })
                            } else {
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
                if ($('.modal').length > 0) {
                    App.waitForElement('.modal', function () {
                        $('#loader-backGround, #loader').fadeOut().remove();
                    })
                } else {
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

        var introSection  = $('#carousel-example-generic'),
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
    },

    thumbVideo: function (id, src, src_thum, type) {
        if (type == 1) {
            $('.images-box-' + id).append('<a class="fancybox" rel="ligthbox" href="' + src + '">' +
                '<img style="background: url(' + src_thum + ') no-repeat 50% 50%; background-size:cover;"/>' +
                '</a>');
        } else if (type == 2) {
            $('.video-box-' + id).append(
                '<div><span class="fancybox">' +
                    '<img id="thumbnail-' + id + '"  style="overflow: hidden; background: url() no-repeat 50% 50%; background-size:cover;" />' +
                    '</span><span class="text-content">' +
                    '<a class="fancybox" href="#video-' + id + '"><i class="fa fa-play"></i></a>' +
                    '</span></div>' +
                    '<div id="div_video" class="fancybox-video">' +
                    '<video id="video-' + id + '" width="800" controls="controls" preload="metadata" src="' + src + '" type="video/mp4">' +
                    '</video>' +
                    '</div>');

            var time = 15;
            var scale = 0.5;
            var video_obj = null;

            document.getElementById('video-' + id).addEventListener('loadedmetadata', function () {
                this.currentTime = time;
                video_obj = this;
            }, false);
            document.getElementById('video-' + id).addEventListener('loadeddata', function () {
                var video = document.getElementById('video-' + id);
                var canvas = document.createElement("canvas");
                canvas.width = video.videoWidth * scale;
                canvas.height = video.videoHeight * scale;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var img = document.createElement("img");
                img.src = canvas.toDataURL();
                $('#thumbnail-' + id).css("background-image", "url('" + img.src + "')");
                video_obj.currentTime = 0;
            }, false);
            $(".fancybox").fancybox({
                afterShow: function () {
                    this.content.find('video-' + id).trigger('play')
                    this.content.find('video-' + id).on('ended', function () {
                        $.fancybox.next();
                    });
                }
            });
        }
    }
}


//]]>
//App.actionClick();