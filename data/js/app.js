App = {
    init: function () {

    },
    showModal: function (data, modalClass, back_redirect) {

        var modalTitle = '';
        var modalFooter = '';
        data = $(data);

        if ($('.page-header h3', data).html() != undefined) {
            modalTitle = '<h4 class="modal-title">' + $('.page-header h3', data).html() + '</h4>';
            $('.page-header', data).remove();
        } else if ($('.page-header', data).html() != undefined) {
            modalTitle = '<h4 class="modal-title">' + $('.page-header', data).html() + '</h4>';
            $('.page-header', data).remove();
        }

        var fieldsetTitle = '';
        if($('.id-fieldsettitle', data).html() != undefined) {
            fieldsetTitle = $($('.id-fieldsettitle', data).html());
            $('.id-fieldsettitle', data).remove(); console.log(fieldsetTitle.html());
            $('.fieldset-title', data).before(fieldsetTitle.html());
        }

        if ($('.action-group dl:last', data).html() != undefined) {
            modalFooter = $($('.action-group:last', data).html());
            $('.action-group', data).remove();
            if ($('form:last', data).html() != undefined) {

                if ($('form:last', data).attr('id') == undefined) {
                    $('form:last', data).attr('id', 'modal-form');
                }
                $('button[name="back"]', modalFooter).removeAttr('data-url');
                $('input[type="submit"]', modalFooter).attr('form', $('form:last', data).attr('id'));
                $('input[type="submit"]', modalFooter).attr('data-loading-text:last', 'Processing...');
                $('input[type="submit"]', modalFooter).addClass('btn-state');
            }
            modalFooter = $(modalFooter).html();
        }
        var modalStyle = ' style="';
        var modalMainStyle = ' style="';
        var backgroundData = 'static';


        modalStyle += '"';
        modalMainStyle += '"';


        if (data.hasClass('form-modal-outer') && $('.page-content', data).html() != undefined) {
            data = $('.page-content', data);
        }

        var modalLayout = '<div class="modal fade' + (back_redirect == undefined ? '' : ' back_redirect') + ' ' + modalClass + '" ' + modalMainStyle + ' ' + backgroundData + '>' +
            '<div class="modal-dialog ' + modalClass + '"' + modalStyle + '>' +
            '<div class="modal-content">' +
            '<div class="modal-header">' + modalTitle +


            '</div>' +
            '<div class="modal-body" style="background: #fff;">' + data.html() + '</div>' +
            '<div class="modal-footer" style="background: #fff;">' + modalFooter + '</div></div></div></div>';

        //{backdrop: backgroundData}
        console.log(modalLayout);
        $(modalLayout).modal().on('hidden.bs.modal', function (e) {
            $(e.currentTarget).remove();
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
        if (App.ajaxUrl == url) {
            return false;
        }

        App.ajaxUrl = url;

        //CKedit hack
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
                    App.alert('Server communication problem.', 'error');
                } else {
                    onError(data);
                }
                App.loadButtonReset();
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
                            console.log(originalContent);
                            if (originalContent) {

                                $(originalContent).modal('hide');
                            }
                            if (datao.extraCommand != undefined) {
                                eval(datao.extraCommand);
                            }

                            return true;
                            break;
                    }
                } catch (e) {
                }

                if (onSuccess == false) {
                    $(content).html(data);
                } else {
                    onSuccess(data, status, jqXHR);
                }
                App.ajaxUrl = null;
            }
        })
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
                console.log(status, jqXHR);
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
    }
};



//<![CDATA[


jQuery(document).ready(function($){

    $("form").on('submit', function (event) {
        if ($(this).find("input.required").val() == "") {
            $(this).find("input.required").addClass('error-input');
            event.preventDefault();
        }
    });
    $("form").on('keydown', function (event) {
        $(this).find("input.required").removeClass('error-input');
    });

    var introSection = $('#carousel-example-generic'),
        introSectionHeight = introSection.height(),
    //change scaleSpeed if you want to change the speed of the scale effect
        scaleSpeed = 0.3,
    //change opacitySpeed if you want to change the speed of opacity reduction effect
        opacitySpeed = 1;

    //update this value if you change this breakpoint in the style.css file (or _layout.scss if you use SASS)
    var MQ = 1170;

    triggerAnimation();
    $(window).on('resize', function(){
        triggerAnimation();
    });

    //bind the scale event to window scroll if window width > $MQ (unbind it otherwise)
    function triggerAnimation(){
        if($(window).width()>= MQ) {
            $(window).on('scroll', function(){
                //The window.requestAnimationFrame() method tells the browser that you wish to perform an animation- the browser can optimize it so animations will be smoother
                window.requestAnimationFrame(animateIntro);
            });
        } else {
            $(window).off('scroll');
        }
    }
    //assign a scale transformation to the introSection element and reduce its opacity
    function animateIntro () {
        var scrollPercentage = ($(window).scrollTop()/introSectionHeight).toFixed(5),
            scaleValue = 1 - scrollPercentage*scaleSpeed;
        //check if the introSection is still visible
        if( $(window).scrollTop() < introSectionHeight) {
            introSection.css({
                '-moz-transform': 'scale(' + scaleValue + ') translateZ(0)',
                '-webkit-transform': 'scale(' + scaleValue + ') translateZ(0)',
                '-ms-transform': 'scale(' + scaleValue + ') translateZ(0)',
                '-o-transform': 'scale(' + scaleValue + ') translateZ(0)',
                'transform': 'scale(' + scaleValue + ') translateZ(0)',
                'opacity': 1 - scrollPercentage*opacitySpeed
            });
        }
    }

    /********************************
     open/close submenu on mobile
     ********************************/
    $('.cd-main-nav').on('click', function(event){
        if($(event.target).is('.cd-main-nav')) $(this).children('ul').toggleClass('is-visible');
    });
});


//]]>
