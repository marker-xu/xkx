var softKey_oldVal_p0="";
var softKey_oldVal_p1="";
var softKey_oldVal_p2="";
var softKey_oldVal_p3="";
if (jQuery) (function ($) {
    /*************************************** 无 ************************************************************/
    //定义键盘代码
    var _numkeybordhtml = "<div id=\"numkeybord\">"
		+ "<table id=\"main\">"
		+ "<tr><td class=\"key\">1</td><td class=\"key\">2</td><td class=\"key\">3</td></tr>"
		+ "<tr><td class=\"key\">4</td><td class=\"key\">5</td><td class=\"key\">6</td></tr>"
		+ "<tr><td class=\"key\">7</td><td class=\"key\">8</td><td class=\"key\">9</td></tr>"
		+ "<tr><td id=\"back\">退格</td><td class=\"key\">0</td><td id=\"enter\">确定</td></tr>";
		+"</table>"
		+ "</div>";

    //定义插件
    jQuery.fn.numkeybord = function (_option) {
        //键盘追加到网页中
        $(document.body).append(_numkeybordhtml);
        var _obj = this;
        jQuery.each(_obj, function (i, _o) {
            $(_o).bind('click.show', function () { _show(this); });
        });
        $("#numkeybord td#esc,#numkeybord td#enter").bind('click.hide', function () {
            _hide();
        });
        $("#numkeybord td.key").bind('click.returnkey', function () {
            var tmp = $("#numkeybord").attr("target");
            var obj_tmp = $("#" + tmp);
            //_returnkey(obj_tmp,$(this).text());
            if ($(obj_tmp).val().length >= $(obj_tmp).attr("maxlength")) return;
            var tmpval = $(obj_tmp).val() + $(this).text();
            $(obj_tmp).val(tmpval);
            _focus(obj_tmp);

            $(this).blur();
        });
        $("#numkeybord td#back").bind('click.back', function () {
            var tmp = $("#numkeybord").attr("target");
            var obj_tmp = $("#" + tmp);
            _back(obj_tmp);
        });
        var _isover = false;
        var _isover2 = false;
        $("#numkeybord").hover(function () {
            _isover = true;
        },
   function () {
       _isover = false;
   });

        $(_obj).hover(function () {
            _isover2 = true;
        },
   function () {
       _isover2 = false;
   });


        if (_option == null)
            return;
        else {
            if (_option.enter == false)
                $("td#enter").unbind('click.hide').css({ color: "#999999" });
            if (_option.esc == false)
                $("td#esc").unbind('click.hide').css({ color: "#999999" });
            if (_option.back == false)
                $("td#back").unbind('click.back').css({ color: "#999999" });
        }
    }
    //键盘与元素绑定及显示
    function _show(_input) {
        softKey_oldVal_p0 = $(_input).val();
        $(_input).attr("value", "")
        var _offset = $(_input).offset();
        var _left = _offset.left;
        var _top = _offset.top + $(_input).height() + ($.browser.msie ? 5 : 6);
        $("#numkeybord").attr("target", _input.id).css({ left: _left + "px", top: _top + "px", display: 'block' });
        _focus(_input);
    }
    //输入操作
    /*
    function _returnkey(_input,_val){
    if($(_input).val().length >= $(_input).attr("maxlength")) return;
    var tmpval = $(_input).val() + _val;
    $(_input).val(tmpval);
    //$(_input).focus();  
    _focus(_input);
    } 
    */
    //光标返回
    function _focus(_input) {
        //$(_input).focus();
        if ($.browser.msie) {
            var rng = $(_input)[0].createTextRange();
            rng.collapse(false);
            rng.select();
        } else {
            $(_input).focus();
        }
    }
    //退格操作
    function _back(_input) {
        var _len = $(_input).val().length;
        var _tmp = $(_input).val();
        $(_input).val(_tmp.substr(0, _len - 1));
        _focus(_input);
    }
    //键盘关闭
    function _hide(_input) {
        var tmp = $("#numkeybord").attr("target");
        var obj_tmp = $("#" + tmp);
        $("#numkeybord").css({ display: 'none' });
        //$(obj_tmp).focus();
        _focus(obj_tmp);

        //alert(">>>"+obj_tmp)
        if (obj_tmp.val() == null || obj_tmp.val() == "") {
            obj_tmp.attr("value", softKey_oldVal_p0);
        }

        var num = parseInt(obj_tmp.val(), 10);
        if (num < 1 || num > 99) {
            obj_tmp.attr("value", softKey_oldVal_p0);
            num = softKey_oldVal_p0;
        }
        obj_tmp.attr("value", num);
        NumkeyReBack(obj_tmp);
    }
	function NumkeyReBack(obj) {
		
	}
    /*************************************** 无 ************************************************************/

    /*************************************** 一 ************************************************************/
    //定义键盘代码
    var _numkeybordhtml_p1 = "<div id=\"numkeybord_p1\">"
       + "<table id=\"main_p1\">"
       + "<tr><td class=\"key\">1</td><td class=\"key\">2</td><td class=\"key\">3</td></tr>"
       + "<tr><td class=\"key\">4</td><td class=\"key\">5</td><td class=\"key\">6</td></tr>"
       + "<tr><td class=\"key\">7</td><td class=\"key\">8</td><td class=\"key\">9</td></tr>"
       + "<tr><td id=\"back_p1\">退格</td><td class=\"key\">0</td><td id=\"enter_p1\">确定</td></tr>";
+"</table>"
       + "</div>";
    //定义插件
    jQuery.fn.numkeybord_p1 = function (_option) {
        //键盘追加到网页中
        $(document.body).append(_numkeybordhtml_p1);
        var _obj = this;
        jQuery.each(_obj, function (i, _o) {
            $(_o).bind('click.show', function () { _show_p1(this); });
        });
        $("#numkeybord_p1 td#esc_p1,#numkeybord_p1 td#enter_p1").bind('click.hide', function () {
            _hide_p1();
            alert("ok");
        });
        $("#numkeybord_p1 td.key").bind('click.returnkey', function () {
            var tmp = $("#numkeybord_p1").attr("target");
            var obj_tmp = $("#" + tmp);

            //_returnkey_p1(obj_tmp,$(this).text());   

            if ($(obj_tmp).val().length >= $(obj_tmp).attr("maxlength")) return;
            var tmpval = $(obj_tmp).val() + $(this).text();
            $(obj_tmp).val(tmpval);
            _returnkey_p1(obj_tmp);

            $(this).blur();
        });
        $("#numkeybord_p1 td#back_p1").bind('click.back', function () {
            var tmp = $("#numkeybord_p1").attr("target");
            var obj_tmp = $("#" + tmp);
            _back_p1(obj_tmp);
        });
        var _isover = false;
        var _isover2 = false;
        $("#numkeybord_p1").hover(function () {
            _isover = true;
        },
   function () {
       _isover = false;
   });

        $(_obj).hover(function () {
            _isover2 = true;
        },
   function () {
       _isover2 = false;
   });


        if (_option == null)
            return;
        else {
            if (_option.enter_p1 == false)
                $("td#enter_p1").unbind('click.hide').css({ color: "#999999" });
            if (_option.esc_p1 == false)
                $("td#esc_p1").unbind('click.hide').css({ color: "#999999" });
            if (_option.back_p1 == false)
                $("td#back_p1").unbind('click.back').css({ color: "#999999" });
        }

    }

    //键盘与元素绑定及显示
    function _show_p1(_input) {
        softKey_oldVal_p1 = $(_input).val();
        $(_input).attr("value", "")
        var _offset = $(_input).offset();
        var _left = _offset.left;
        var _top = _offset.top + $(_input).height() + ($.browser.msie ? 5 : 6);
        $("#numkeybord_p1").attr("target", _input.id).css({ left: _left + "px", top: _top + "px", display: 'block' });
        _returnkey_p1(_input);
    }
    //输入操作
    /*
    function _returnkey_p1(_input,_val){
    if($(_input).val().length >= $(_input).attr("maxlength")) return;
    var tmpval = $(_input).val() + _val;
    $(_input).val(tmpval);
    //$(_input).focus();  
    _returnkey_p1(_input);
    } 
    */
    //光标返回
    function _returnkey_p1(_input) {
        //$(_input).focus();
        if ($.browser.msie) {
            var rng = $(_input)[0].createTextRange();
            rng.collapse(false);
            rng.select();
        } else {
            $(_input).focus();
        }
    }
    //退格操作
    function _back_p1(_input) {
        var _len = $(_input).val().length;
        var _tmp = $(_input).val();
        $(_input).val(_tmp.substr(0, _len - 1));
        _returnkey_p1(_input);
    }
    //键盘关闭
    function _hide_p1(_input) {
        var tmp = $("#numkeybord_p1").attr("target");
        var obj_tmp = $("#" + tmp);
        $("#numkeybord_p1").css({ display: 'none' });
        //$(obj_tmp).focus();
        _returnkey_p1(obj_tmp);
        //alert(obj_tmp.val())
        if (obj_tmp.val() == null || obj_tmp.val() == "") {
            obj_tmp.attr("value", softKey_oldVal_p1);
        }
        var num = parseInt(obj_tmp.val(), 10);
        if (num < 1 || num > 99) {
            obj_tmp.attr("value", softKey_oldVal_p1);
            num = softKey_oldVal_p1;
        }
        obj_tmp.attr("value", num);
        NumkeyReBack_p1(obj_tmp);
    }

    /*************************************** 一 ************************************************************/

    /*************************************** 二 ************************************************************/
    //定义键盘代码
    var _numkeybordhtml_p2 = "<div id=\"numkeybord_p2\">"
       + "<table id=\"main_p2\">"
       + "<tr><td class=\"key\">1</td><td class=\"key\">2</td><td class=\"key\">3</td></tr>"
       + "<tr><td class=\"key\">4</td><td class=\"key\">5</td><td class=\"key\">6</td></tr>"
       + "<tr><td class=\"key\">7</td><td class=\"key\">8</td><td class=\"key\">9</td></tr>"
       + "<tr><td id=\"back_p2\">退格</td><td class=\"key\">0</td><td id=\"enter_p2\">确定</td></tr>";
+"</table>"
       + "</div>";
    //定义插件
    jQuery.fn.numkeybord_p2 = function (_option) {
        //键盘追加到网页中
        $(document.body).append(_numkeybordhtml_p2);
        var _obj = this;
        jQuery.each(_obj, function (i, _o) {
            $(_o).bind('click.show', function () { _show_p2(this); });
        });
        $("#numkeybord_p2 td#esc_p2,#numkeybord_p2 td#enter_p2").bind('click.hide', function () {
            _hide_p2();
        });
        $("#numkeybord_p2 td.key").bind('click.returnkey', function () {
            var tmp = $("#numkeybord_p2").attr("target");
            var obj_tmp = $("#" + tmp);

            //_returnkey_p2(obj_tmp,$(this).text());   

            if ($(obj_tmp).val().length >= $(obj_tmp).attr("maxlength")) return;
            var tmpval = $(obj_tmp).val() + $(this).text();
            $(obj_tmp).val(tmpval);
            _returnkey_p2(obj_tmp);

            $(this).blur();
        });
        $("#numkeybord_p2 td#back_p2").bind('click.back', function () {
            var tmp = $("#numkeybord_p2").attr("target");
            var obj_tmp = $("#" + tmp);
            _back_p2(obj_tmp);
        });
        var _isover = false;
        var _isover2 = false;
        $("#numkeybord_p2").hover(function () {
            _isover = true;
        },
   function () {
       _isover = false;
   });

        $(_obj).hover(function () {
            _isover2 = true;
        },
   function () {
       _isover2 = false;
   });


        if (_option == null)
            return;
        else {
            if (_option.enter_p2 == false)
                $("td#enter_p2").unbind('click.hide').css({ color: "#999999" });
            if (_option.esc_p2 == false)
                $("td#esc_p2").unbind('click.hide').css({ color: "#999999" });
            if (_option.back_p2 == false)
                $("td#back_p2").unbind('click.back').css({ color: "#999999" });
        }

    }

    //键盘与元素绑定及显示
    function _show_p2(_input) {
        softKey_oldVal_p2 = $(_input).val();
        $(_input).attr("value", "");
        var _offset = $(_input).offset();
        var _left = _offset.left;
        var _top = _offset.top + $(_input).height() + ($.browser.msie ? 5 : 6);
        $("#numkeybord_p2").attr("target", _input.id).css({ left: _left + "px", top: _top + "px", display: 'block' });
        _returnkey_p2(_input);
    }
    //输入操作
    /*
    function _returnkey_p2(_input,_val){
    if($(_input).val().length >= $(_input).attr("maxlength")) return;
    var tmpval = $(_input).val() + _val;
    $(_input).val(tmpval);
    //$(_input).focus();  
    _returnkey_p2(_input);
    } 
    */
    //光标返回
    function _returnkey_p2(_input) {
        //$(_input).focus();
        if ($.browser.msie) {
            var rng = $(_input)[0].createTextRange();
            rng.collapse(false);
            rng.select();
        } else {
            $(_input).focus();
        }
    }
    //退格操作
    function _back_p2(_input) {
        var _len = $(_input).val().length;
        var _tmp = $(_input).val();
        $(_input).val(_tmp.substr(0, _len - 1));
        _returnkey_p2(_input);
    }
    //键盘关闭
    function _hide_p2(_input) {
        var tmp = $("#numkeybord_p2").attr("target");
        var obj_tmp = $("#" + tmp);
        $("#numkeybord_p2").css({ display: 'none' });
        //$(obj_tmp).focus();
        _returnkey_p2(obj_tmp);
        //alert(obj_tmp.val())
        if (obj_tmp.val() == null || obj_tmp.val() == "") {
            obj_tmp.attr("value", softKey_oldVal_p2);
        }
        var num = parseInt(obj_tmp.val(), 10);
        if (num < 1 || num > 99) {
            obj_tmp.attr("value", softKey_oldVal_p2);
            num = softKey_oldVal_p2;
        }
        obj_tmp.attr("value", num);
        NumkeyReBack_p2(obj_tmp);
    }

    /*************************************** 二 ************************************************************/
    /*************************************** 三 ************************************************************/
    //定义键盘代码
    var _numkeybordhtml_p3 = "<div id=\"numkeybord_p3\">"
       + "<table id=\"main_p3\">"
       + "<tr><td class=\"key\">1</td><td class=\"key\">2</td><td class=\"key\">3</td></tr>"
       + "<tr><td class=\"key\">4</td><td class=\"key\">5</td><td class=\"key\">6</td></tr>"
       + "<tr><td class=\"key\">7</td><td class=\"key\">8</td><td class=\"key\">9</td></tr>"
       + "<tr><td id=\"back_p3\">退格</td><td class=\"key\">0</td><td id=\"enter_p3\">确定</td></tr>";
+"</table>"
       + "</div>";
    //定义插件
    jQuery.fn.numkeybord_p3 = function (_option) {
        //键盘追加到网页中
        $(document.body).append(_numkeybordhtml_p3);
        var _obj = this;
        jQuery.each(_obj, function (i, _o) {
            $(_o).bind('click.show', function () { _show_p3(this); });
        });
        $("#numkeybord_p3 td#esc_p3,#numkeybord_p3 td#enter_p3").bind('click.hide', function () {
            _hide_p3();
        });
        $("#numkeybord_p3 td.key").bind('click.returnkey', function () {
            var tmp = $("#numkeybord_p3").attr("target");
            var obj_tmp = $("#" + tmp);

            //_returnkey_p3(obj_tmp,$(this).text());   

            if ($(obj_tmp).val().length >= $(obj_tmp).attr("maxlength")) return;
            var tmpval = $(obj_tmp).val() + $(this).text();
            $(obj_tmp).val(tmpval);
            _returnkey_p3(obj_tmp);

            $(this).blur();
        });
        $("#numkeybord_p3 td#back_p3").bind('click.back', function () {
            var tmp = $("#numkeybord_p3").attr("target");
            var obj_tmp = $("#" + tmp);
            _back_p3(obj_tmp);
        });
        var _isover = false;
        var _isover2 = false;
        $("#numkeybord_p3").hover(function () {
            _isover = true;
        },
   function () {
       _isover = false;
   });

        $(_obj).hover(function () {
            _isover2 = true;
        },
   function () {
       _isover2 = false;
   });


        if (_option == null)
            return;
        else {
            if (_option.enter_p3 == false)
                $("td#enter_p3").unbind('click.hide').css({ color: "#999999" });
            if (_option.esc_p3 == false)
                $("td#esc_p3").unbind('click.hide').css({ color: "#999999" });
            if (_option.back_p3 == false)
                $("td#back_p3").unbind('click.back').css({ color: "#999999" });
        }

    }

    //键盘与元素绑定及显示
    function _show_p3(_input) {
        softKey_oldVal_p3 = $(_input).val();
        $(_input).attr("value", "");
        var _offset = $(_input).offset();
        var _left = _offset.left;
        var _top = _offset.top + $(_input).height() + ($.browser.msie ? 5 : 6);
        $("#numkeybord_p3").attr("target", _input.id).css({ left: _left + "px", top: _top + "px", display: 'block' });
        _returnkey_p3(_input);
    }
    //输入操作
    /*
    function _returnkey_p3(_input,_val){
    if($(_input).val().length >= $(_input).attr("maxlength")) return;
    var tmpval = $(_input).val() + _val;
    $(_input).val(tmpval);
    //$(_input).focus();  
    _returnkey_p3(_input);
    } 
    */
    //光标返回
    function _returnkey_p3(_input) {
        //$(_input).focus();
        if ($.browser.msie) {
            var rng = $(_input)[0].createTextRange();
            rng.collapse(false);
            rng.select();
        } else {
            $(_input).focus();
        }
    }
    //退格操作
    function _back_p3(_input) {
        var _len = $(_input).val().length;
        var _tmp = $(_input).val();
        $(_input).val(_tmp.substr(0, _len - 1));
        _returnkey_p3(_input);
    }
    //键盘关闭
    function _hide_p3(_input) {
        var tmp = $("#numkeybord_p3").attr("target");
        var obj_tmp = $("#" + tmp);
        $("#numkeybord_p3").css({ display: 'none' });
        //$(obj_tmp).focus();
        _returnkey_p3(obj_tmp);
        //alert(obj_tmp.val())
        if (obj_tmp.val() == null || obj_tmp.val() == "") {
            obj_tmp.attr("value", softKey_oldVal_p3);
        }
        var num = parseInt(obj_tmp.val(), 10);
        if (num < 1 || num > 99) {
            obj_tmp.attr("value", softKey_oldVal_p3);
            num = softKey_oldVal_p3;
        }
        obj_tmp.attr("value", num);
        NumkeyReBack_p3(obj_tmp);
    }

    /*************************************** 三 ************************************************************/

})(jQuery); 