$(document).ready(function() {
    let url = window.location.href, token = null;
    if (url.search("api") !== -1){
        token = getApiToken();
    }else {
        token = getToken();
    }
    $.ajaxSetup({
        async : false,
        beforeSend : function(request) {
            request.setRequestHeader("access-token", token);
        },
    });
});

function time() {
    let tmp = Date.parse(new Date()).toString();
    tmp = tmp.substr(0, 10);
    return tmp;
}

function empty(str) {
    return typeof (str) === "undefined" || str === null || str === "" || str === "NaN";
}

function arrayDuplicate(a, b) {
    let c = [];
    a.forEach(v => {
        if(b.indexOf(v) === -1){
            c.push(v)
        }
    });
    return c;
}

function getParams() {
    var url = location.search;
    url = decodeURI(url);
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}

function timeToTimeStamp($time){
    if (empty($time)){
        return null;
    }
    let date = new Date($time);
    return Date.parse(date) / 1000;
}

function timestampToTime(timestamp) {
    if (empty(timestamp)){
        return "缺失时间";
    }
    let date = new Date(timestamp * 1000);
    let Y = date.getFullYear() + '-';
    let M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    let D = date.getDate() + ' ';
    let h = date.getHours() + ':';
    let m = (date.getMinutes() < 10 ? '0' + (date.getMinutes()) : date.getMinutes()) + ':';
    let s = (date.getSeconds() < 10 ? '0' + (date.getSeconds()) : date.getSeconds());
    return Y + M + D + h + m + s;
}

function config(status) {
    $.ajaxSetup({async : false});
    let res = null;
    $.getJSON('/XAdmin/js/status.json', function(data) {
        res = data[status];
    });
    return res;
}

function getApiToken() {
    return $.cookie('api_login_token');
}

function getToken() {
    return $.cookie('admin_login_token');
}

function isLogin(secret) {
    $.ajax({
        type : "POST",
        contentType : "application/x-www-form-urlencoded",
        url : '/' + secret + '/Admin/isLogin',
        beforeSend : function(request) {
            request.setRequestHeader("access-token", getToken());
        },
        success : function(res) {
            if(res.status === config('goto')){
                layer.msg('登录失效!', function () {
                    $.removeCookie('admin_login_token', {path: '/'});
                    $(window).attr('location', '/' + secret + '/loginView');
                });
            }
        }
    });
}

function isApiLogin() {
    $.ajax({
        type : "POST",
        contentType : "application/x-www-form-urlencoded",
        url : '/api/User/isLogin',
        beforeSend : function(request) {
            request.setRequestHeader("access-token", getApiToken());
        },
        success : function(res) {
            if(res.status === config('goto')){
                layer.msg('登录失效!', function () {
                    $.removeCookie('api_login_token', {path: '/'});
                    $(window).attr('location', '/api/View/login');
                });
            }
        }
    });
}