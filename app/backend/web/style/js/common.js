function ShowNotice(title, text, type, delay, is_mouse_reset)
{
    PNotify.prototype.options.styling = "bootstrap3";
    new PNotify({
        title: title,
        text: text,
        type: type,
        delay: delay,
        hide: true, //是否自动关闭
        mouse_reset: is_mouse_reset,   //鼠标悬浮的时候，时间重置

        addclass: "stack-modal", // This is one of the included default classes.
    });
}

function submitHref(id, postUrl,href) {
    $.ajax({
        type: "post",
        url: postUrl,
        data: $(id).serialize(),
    }).success(function(message) {
        console.log(message.code != 0)
        if (message.code != 0) {
            ShowNotice('提示', message.message, 'error', 1000, false);
        }else{
            ShowNotice('提示', "成功", 'success', 1000, false);
            if( href != ""){
                window.location.href = href;
            }
        }
    }).fail(function(err){
        ShowNotice('提示', "Oh! No", 'error', 1000, false);

    })

}

function submitRefresh(formId, postUrl, timeNum) {
    $.ajax({
        type: "post",
        url: postUrl,
        data: $(formId).serialize(),
    }).success(function(message) {
        console.log(message.code != 0)
        if (message.code != 0) {
            ShowNotice('提示', message.message, 'error', 1000, false);
        }else{
            ShowNotice('提示', "成功", 'success', 1000, false);
            setTimeout(function () {
                window.location.reload();
            },timeNum); //指定1秒刷新一次
        }
    }).fail(function(err){
        ShowNotice('提示', "Oh! No", 'error', 1000, false);

    })

}


function getHref(Url,timeNum) {
    $.ajax({
        type: "get",
        url: Url,
    }).success(function(message) {
        if (message.code != 0) {
            ShowNotice('提示', message.message, 'error', 1000, false);
        }else{
            ShowNotice('提示', "成功", 'success', 1000, false);
            setTimeout(function () {
                window.location.reload();
            },timeNum); //指定1秒刷新一次
        }
    }).fail(function(err){
        ShowNotice('提示', "Oh! No", 'error', 1000, false);

    })
}

function switchClass(thisId, checkClass, otherId) {
    thisId = "#" + thisId
    var thisClass = $( thisId).attr('class'); // 获取选择器的class类名
    var otherClass = $(otherId).attr('class'); // 获取选择器的class类名
    console.log(thisClass);
    console.log(otherClass);
    console.log(checkClass);

    if (thisClass != checkClass) {
        $(thisId).removeClass(thisClass).toggleClass(otherClass);
        $(otherId).removeClass(otherClass).toggleClass(thisClass);
    }
}

function showPage(pageNo, pageSize, totalPage, url){
    $("#pageLimit").bootstrapPaginator({
        currentPage: pageNo,
        totalPages: totalPage,
        numberofPages:pageSize,
        bootstrapMajorVersion: 3,
        size: "small",
        onPageClicked: function(e,originalEvent,type,page){
            window.location.href = url + "page_no=" + page + "&page_size=" + pageSize
        },
        itemTexts: function (type, page, current) {        
            switch (type) {            
            case "first": return "首页";            
            case "prev": return "上一页";            
            case "next": return "下一页";            
            case "last": return "末页";            
            case "page": return page;
            }
        }
    });
}