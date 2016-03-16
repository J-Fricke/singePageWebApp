$ = jQuery = require('jquery');
ich = require('icanhaz');
require('bootstrap');
require('datatables.net')();
require('datatables.net-responsive')();

function getView(view) {
    console.log(view);
    $.ajax({
        url: "/api/" + view,
        dataType: 'json',
        success: function (res) {
            console.log('success', res, ich[view], ich[view](res));
            $("#main").html(ich[view](res));
            $('#' + view + 'Table').DataTable({iDisplayLength: 50, responsive: true});
        },
        error: function (e) {
            if (e.statusCode().status == 403) {
                if (view === 'logout') {
                    window.location = '#';
                    initNav('index');
                }
                $("#main").html(ich.loginFormTemplate);
                bindLoginSubmit();
            } else if (e.statusCode().status == 401) {
                $("#main").html(ich.loginFormTemplate);
                bindLoginSubmit();
            }
            else {
                console.log(e.statusCode().status, e.statusCode().statusText);
                $("#main").html(ich.errorMsg(e.statusCode()));//@todo decide how to handle this portion
            }
        }
    });
}
function setViewName(view) {
    if (!view || view === 'home') {
        view = 'index';
    }
    return view;
}

function initNav(view) {
    $(".nav").find(".active").removeClass("active");
    $('#' + view + 'Nav').addClass("active");
}
function postLogin(form) {
    var view = window.location.hash.substr(1);
    view = setViewName(view);
    $.ajax({
        url: "/api/login",
        dataType: 'json',
        method: 'POST',
        data: form.serialize(),
        success: function (res) {
            if (res.status == 401) {
                $("#main").html(ich.loginFormTemplate(res));
                bindLoginSubmit();
            } else {
                getView(view);
            }
        },
        error: function (e) {
            console.log(e.statusCode().status, e.statusCode().statusText, e.statusCode().responseText);
        }
    });
}
function postPasswordReset(form) {
//            event.preventDefault();
    var view = window.location.hash.substr(1);
    view = setViewName(view);
    $.ajax({
        url: "/api/resetPasswordRequest",
        dataType: 'json',
        method: 'POST',
        data: form.serialize(),
        success: function (res) {
            console.log('success', res, ich[view], ich[view](res));
            //@todo display a message
            $("#main").html(ich.loginFormTemplate({'statusMessage':[{'message': 'You have been emailed a reset password link.'}]}));
            $("#resetPasswordModal").modal("hide");
        },
        error: function (e) {
            console.log(e.statusCode().status, e.statusCode().statusText, e.statusCode().responseText);
        }
    });
}
function bindLoginSubmit() {
    setTimeout(function () {
        $('#loginForm').submit(function (e) {
            e.preventDefault();
            postLogin($('#loginForm'), 'login');
        });
        $('#passwordResetRequest').submit(function(e) {
            e.preventDefault();
            postPasswordReset($('#passwordResetRequest'));
        });
    }, 1);
}
$(function () {
    $('nav a').click(function () {
        var view = this.hash.substr(1);
        view = setViewName(view);
        getView(view);
    });
    var view = window.location.hash.substr(1);
    view = setViewName(view);
    initNav(view);
    getView(view);

    //nav
    $(".nav a").on("click", function () {
        $(".nav").find(".active").removeClass("active");
        $(this).parent().addClass("active");
    });

    $('#resetPasswordModal').on('shown.bs.modal', function () {
        $('#inputEmail2').focus()
    });
});