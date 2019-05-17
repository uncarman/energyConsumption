define(function (require, exports, module) {

    var session = {
        user: "gh001"
    };

    var settings = {
        default_datas :{
            ajax_loading: false,  // 是否正在执行ajax
        },
        default_page : "home",

        is_fake_ajax : is_fake_ajax,
        is_debug : is_debug,
        fake_sms : fake_sms,
        can_localStorage: true, // 能否使用 localStorage
        sms_cd: 60, //短信验证码cd (单位:秒)
        msg_duration: 12, //弹出提示框持续时间, 单位:秒
        root: "",

        domain: "./api.php?act=",  // 接口地址
        cross_domain: false,
        ajax_timeout: 30*1000, //ajax超时时间 (单位:毫秒)

        // 分页参数
        page_default: 1,
        items_per_page: 10,     // 数据每页显示10条
        items_num_edge: 3,      // 两侧首尾，主体分页条目数
        prev_text: "上一页",    // 上一页文字
        next_text: "下一页",    // 下一页文字

        ajax_func: {
            getBuidings: "getBuidings",
            getLoginCode: "getLoginCode",
            user: "user",
            getList: "getList",
            profile: "profile",

        },

        // 分页参数
        items_per_page: 10,     // 数据每页显示10条
        items_num_edge: 3,      // 两侧首尾，主体分页条目数
        prev_text: "上一页",    // 上一页文字
        next_text: "下一页",    // 下一页文字

        ajax_succ_code : 10000,       // ajax 成功code
        ajax_auth_failed_code : 20000,       // ajax 失败code
        ajax_error_msg: {    // ajax请求，错误码对应错误信息
            "10000": "请求成功",
            "10001": "服务器内部错误",
            "10002": "服务器维护中",
            "10003": "接口版本过低",
            "10004": "用户验证失败",
            "10005": "操作被拒绝",
        },

        floorBgs: {
            "2F" : "../imgs/floor/2F.jpg",
            "3F" : "../imgs/floor/3F.jpg",
            "4F" : "../imgs/floor/4F.jpg",
            "5F" : "../imgs/floor/5F.jpg",
            "6F" : "../imgs/floor/6F.jpg",
            "7F" : "../imgs/floor/7F.jpg",
            "8F" : "../imgs/floor/8F.jpg",
            "9F" : "../imgs/floor/9F.jpg",
            "10F" : "../imgs/floor/10F.jpg",
            "楼顶" : "../imgs/floor/top.jpg",
        }
    };

    var global = {
        loading_num: 0,    // for ajax loading number record

        default_ajax_error_func: function(data, param, success_func) {
            var msg = '服务器无响应。';
            if (data != '' && data != null) {
                if(angular.isObject(data))
                {
                    MyAlert(settings.ajax_error_msg[data.code], 'warning');
                    return msg;
                }
                else if(angular.isString(data))
                {
                    MyAlert(data, 'warning');
                    return data;
                }
            }
            else {
                MyAlert(msg, 'warning');
                return msg;
            }
        },

        // 拿到用户token
        getUserToken : function() {
            var tmp = global.read_storage("session");
            return tmp["token"] || "";
        },

        // 根据规则生成 sign 字符串
        generateSign: function(param) {
            let token = global.getUserToken();
            if(token != "" && angular.isObject(param)) {
                var tmp = [["usertoken", token]];  // 塞入默认token
                for(let o in param) {
                    tmp.push([o, param[o]]);
                }
                tmp.sort(function(a, b){
                    return a[0] > b[0];
                });
                
                let res = "";
                tmp.map(function(s){
                    res += "&" + s[0] + "=" + s[1];
                });
                res = res.slice(1, res.length);  // 去除第一个 &
                // return hashlib.sha1(res.encode()).hexdigest();
                return res;
            }
            throw new Error("token不存在或参数错误. token:" + token + " param:" + JSON.stringify(param));
        },

        // 根据规则生成 Authorization 字符串
        generateAuthorization: function(param) {
            return 111;
        },

        /**/
        ajax:function($scope, param, success_func, error_func) {
            var np = angular.copy(param);
            var method = (np._method != 'post' && np._method != 'get') ? 'get' : np._method;
            var url = settings.domain + np._url;
            var timeout = (angular.isNumber(np._timeout)) ? np._timeout : settings.ajax_timeout;
            var cache = !!np._cache;

            var _param = param._param || {};

            // 替换 url 中的参数
            for(o in _param) {
                url = url.replace("{"+o+"}", _param[o]);
            }

            // var header = {
            //     "authorization" : global.generateAuthorization() || "",
            // };

            var req = {
                method : method,
                url: url,
                cache : cache,
                timeout: timeout,
                data : _param,
                //headers : header,
                crossDomain : Object.hasOwnProperty(param.crossDomain) ? param.crossDomain : settings.cross_domain,
                success : function(data) {
                    try{
                        data = JSON.parse(data);
                        data = JSON.parse(data);
                    } catch(e) {}

                    success_func(data);
                    global.loading_num -= 1;
                    global.loading_hide();
                },
                error: function(data){
                    if(angular.isFunction(error_func)){
                        error_func(data);
                    }
                    else {
                        global.default_ajax_error_func(data, _param, success_func);
                    }
                    global.loading_num -= 1;
                    global.loading_hide();
                }
            };
            console.log("service req: ", req);
            jQuery.ajax(req);

            global.loading_num += 1;
            global.loading_show();
        },

        // 和服务器交互接口，做code=0检查，忽略包含success_code错误码的结果
        // success_code 为避免报错的自定义code, 可以为 string, list
        ajax_data: function($scope, params, success_func, success_code, error_func) {
            if(settings.is_fake_ajax) {
                try{
                    setTimeout(function(){
                        console.log(params);
                        if(fake_data[params._url]) {
                            console.log(fake_data[params._url]);
                            return success_func(fake_data[params._url]);
                        } else {
                            return success_func({"code":0, "data": {}});
                        }
                    }, 100);
                } catch(e) {
                    // pass
                }
                return false;
            };

            global.ajax($scope, params, function(data){
                //console.log("controllers ajax_data result: " + JSON.stringify(data));

                if ($scope) {
                    $scope.$apply(function(){
                        // 尝试去掉按钮loading状态
                        $scope.ajax_loading = false;
                    });
                }

                if (!success_code) {
                    success_code = "";
                }
                try{
                    success_code = "," + success_code.join(',') + ",";
                }
                catch(e){}

                try{
                    if (data.code == settings.ajax_succ_code || success_code.indexOf(","+data.code+",") >= 0 ) // 指定code码,不报错
                    {
                        success_func(data);
                    }
                    // 用户验证失败
                    else if (data.code == settings.ajax_auth_failed_code) 
                    {
                        global.do_logout();
                    }
                    else  //接口调用失败
                    {
                        if(angular.isFunction(error_func)){
                            error_func(data);
                        }
                    }
                }
                catch(e)
                {
                    MyAlert("系统错误："+e.message, "error");
                }
            }, error_func);
        },

        // 请求该方法的接口不做code=0检查，直接执行回调函数
        cal_data: function($scope, params, success_func, success_code) {
            global.ajax($scope, params, function(data){
                console.log("controllers cal_data result: " + JSON.stringify(data));
                //接口调用成功
                success_func(data);
            }, global.default_ajax_error_func);
        },

        // 该方法发送ajax为了做心跳请求，即使ajax超时或异常也忽略错误。
        heathit_data: function($scope, Ajax, params, success_func, success_code) {
            global.ajax($scope, params, function(data){
                console.log("controllers heathit_data result: " + JSON.stringify(data));
                //接口调用成功
                success_func(data);
            }, function(data){
                // ajax 失败, 忽略错误
                console.log("controllers heathit_data result: " + JSON.stringify(data));
                //接口调用失败, 继续回调
                success_func({});
            });
        },

        return_promise : function ($scope, param) {
            return new Promise(function(resolve, reject) {
                global.ajax_data($scope, param,
                    function (data) {
                        //接口调用成功
                        if(data) {
                            resolve(data);
                        } else {
                            reject(data);
                        }
                    });
            });
        },

        // 格式化数字，直接舍去小数点后面的位数
        fmt_money: function(money, num)
        {
            if (!(angular.isString(num) || angular.isNumber(num)) || isNaN(num)) num=2;
            if (!(angular.isString(money) || angular.isNumber(money)) || isNaN(money)) return '';

            var s_m = money.toString();
            var _pos_decimal = pos_decimal = s_m.indexOf('.');
            if (pos_decimal < 0) {
                pos_decimal = s_m.length;
                if(num > 0) {
                    s_m += '.';
                }
            }
            else {
                if(num > 0) {
                    s_m = s_m.substr(0, pos_decimal + num + 1);
                }
                else {
                    s_m = s_m.substr(0, pos_decimal);
                }
            }
            if(num > 0) {
                while (s_m.length <= pos_decimal + num) {
                    s_m += '0';
                }
            }
            return s_m;
        },

        // 解析url字符串
        request: function(str_parame) {
            var args = new Object( );
            var query = location.search.substring(1); //location.pathname
            var arr = new Array();
            arr = query.split("&");
            for(var i = 0; i < arr.length; i++) {
                var pos = arr[i].indexOf('=');
                if (pos == -1) continue;
                var argname = arr[i].substring(0,pos);
                var value = arr[i].substring(pos+1);
                value = decodeURIComponent(value);
                args[argname] = value;
            }
            return str_parame ? args[str_parame] : args;
        },

        /**
         * 格式化数字
         * @param s number 原数字
         * @param n 格式化后保留几位小数
         * @returns {string}
         */
        fmoney: function(s, n) {
            var negativeNumber = false;
            if(s < 0){
                s = -s;
                negativeNumber = true;
            }
            if(n != 0)
            {
                n = n > 0 && n <= 20 ? n : 2;
                s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
                var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1];
                t = "";
                for (i = 0; i < l.length; i++) {
                    t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
                }
                if(negativeNumber){
                    return "-"+t.split("").reverse().join("") + "." + r;
                }else{
                    return t.split("").reverse().join("") + "." + r;
                }
            }
            else
            {
                s = parseFloat((s + "").replace(/[^\d\.-]/g, "")) + "";
                var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1];
                t = "";
                for (i = 0; i < l.length; i++) {
                    t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
                }
                if(negativeNumber){
                    return "-"+t.split("").reverse().join("");
                }else{
                    return t.split("").reverse().join("");
                }
            }
        },

        parse_num: function (num){
            var number = num;
            var isNegativeNum = false;

            if(num < 0){
                number = -num;
                isNegativeNum = true;
            }

            if(number<1000){
                if(isNegativeNum){
                    return -global.fmoney(number,2)+"元";
                }
                else if(number == 0)
                {
                    return "不限额";
                }
                else
                {
                    return (number != undefined ? global.fmoney(number,2) : 0) + "元";
                }
            }
            if(number >= 1000 && number < 10000){
                if(isNegativeNum){
                    return -global.fmoney((number/1000),0)+"千元";
                }
                return global.fmoney((number/1000),0)+"千元";
            }
            if(number >= 10000 && number < 100000000){
                if(isNegativeNum){
                    return -global.fmoney((number/10000),0)+"万元";
                }
                return global.fmoney((number/10000),0)+"万元";
            }
            if(number >= 100000000){
                //var ths = parseInt(((number/100000000)+"").split(".")[1]);
                console.log(parseInt(((num/100000000)+'').split('.')[1].substring(0, 4)));
                var ths = parseInt(((num/100000000)+'').split('.')[1].substring(0, 4));
                if(isNegativeNum){
                    return -parseInt(number/100000000)+"亿"+(ths==0?"":ths+"万元");
                }
                return parseInt(number/100000000)+"亿"+(ths==0?"":ths+"万元");
            }
            if(isNegativeNum){
                return -global.fmoney(number,2);
            }
            return global.fmoney(number,2);
        },

        // 舍弃小数点后面小数
        fmt_withdraw_money: function(num, n) {
            var bb = num+"";
            var dian = bb.indexOf('.');
            var result = "";
            if(dian == -1){
                result =  num.toFixed(n);
            }else{
                var cc = bb.substring(dian+1,bb.length);
                if(cc.length >=3){
                    result =  (Number(num.toFixed(n)))*100000000000/100000000000;//js小数计算小数点后显示多位小数
                }else{
                    result =  num.toFixed(n);
                }
            }
            return result;
        },


        /*@数字滚动效果
         *@param obj object，用来更新数据，以便刷新前端页面
         *@param keys array, 标记obj里面那些key用来滚动
         *@param $scope $scope, 页面变量
         *@return void
         */
        moving_num: function(obj, keys, $scope){
            var steps = 0.01;
            var old_obj = angular.copy(obj);
            console.log(old_obj);
            for(var o in obj)
            {
                if(keys.indexOf(o) >= 0 && angular.isNumber(obj[o]))
                {
                    obj[o] = 0;
                }
            }
            var is_finished = false;

            var a = setInterval(function(){
                if(is_finished)
                {
                    clearInterval(a);
                }
                else
                {
                    is_finished = true;
                    for(var o in obj)
                    {
                        if(keys.indexOf(o) >= 0 && angular.isNumber(obj[o]))
                        {
                            if(old_obj[o] > obj[o])
                            {
                                steps = Math.max(steps, obj[o]/10);
                                obj[o] += Math.min(steps, Math.round((old_obj[o]-obj[o])*100)/100);
                                obj[o] = old_obj[o]-obj[o] < 0.01 ? old_obj[o] : Math.min(obj[o], old_obj[o]);
                            }
                            is_finished = is_finished && obj[o] >= old_obj[o];
                        }
                    }
                    $scope.$apply(function(){
                        obj = obj;
                    });
                }
            }, 10);
        },

        /*@数字滚动效果(数字按位数分开显示，仅处理整数)
          *@param obj object，用来更新数据，以便刷新前端页面
          *@param keys array, 标记obj里面那些key用来滚动，key对应的属性值为以下样式： "[{"sp_int":"0"},{"sp_int":"5"},{"sp_int":"3"},{"sp_int":"9"}]"
          *@param $scope $scope, 页面变量
          *@param frequency int, 变化频率
          *@param amplitude int, 变换幅度
          *@return void
          */
        moving_splitted_num: function(obj, keys, $scope, frequency, amplitude){
            var splittedNumToValue = function (splittedNum) {
                var value = 0;
                for (var i = 0; i < splittedNum.length; ++i) {
                    value = value * 10 + (splittedNum[i]["sp_int"] * 1);
                }
                return value;
            };

            var valueToSplittedNum = function (value, decimalCount) {
                var splitedNum = [];
                var theValue = value;
                for (var i = 0; i < decimalCount; ++i) {
                    splitedNum.push({ "sp_int": theValue % 10 + "" });
                    theValue = Math.floor(theValue / 10);
                }

                splitedNum = splitedNum.reverse();
                return splitedNum;
            };

            var steps = 1;
            var old_obj = angular.copy(obj);
            console.log(old_obj);

            for(var o in obj)
            {
                if(keys.indexOf(o) >= 0 && angular.isArray(obj[o]))
                {
                    obj[o] = valueToSplittedNum(0, obj[o].length);  // 重置为0，从0开始滚动
                }
            }

            var is_finished = false;

            var a = setInterval(function(){
                if(is_finished)
                {
                    clearInterval(a);
                }
                else
                {
                    is_finished = true;
                    for(var o in obj)
                    {
                        if(keys.indexOf(o) >= 0 && angular.isArray(obj[o]))
                        {
                            var originLength = old_obj[o].length;
                            var originValue = splittedNumToValue(old_obj[o]);
                            var value = splittedNumToValue(obj[o]);
                            if(originValue > value)
                            {
                                steps = Math.max(steps, Math.round(originValue/amplitude));
                                console.log(o + "-steps",steps)
                                value += steps;
                                value = originValue-value < 1 ? originValue : Math.min(value, originValue);
                                console.log(o + "-value",value)
                                obj[o] = valueToSplittedNum(value, originLength);
                            }
                            is_finished = is_finished && value >= originValue;
                        }
                    }
                    $scope.$apply(function(){
                        obj = obj;
                    });
                }
            }, frequency);
        },

        // 页面载入时通用初始化函数
        on_load_func: function($scope){
            // 增加 loading 状态
            global.loading_num += 1;
            global.loading_show();

            // 复用 goto 函数到每个页面, 因统计代码所需, 挪至最前面
            $scope.settings = settings;

            // 添加公共函数给 $scope
            $scope["goto"] = global["goto"];
            $scope.ajax_catch = global.ajax_catch;
            $scope.get_datas = global.get_datas;
            $scope.reset_datas = global.reset_datas;
            $scope.get_datas_next = global.get_datas_next;
            $scope.get_datas_prev = global.get_datas_prev;

            // 前端校验用户登录
            var _session = global.read_storage('session');
            var user = _session.user;
            console.log(user);
            if(!user) {
                global["goto"]('login');
            }
        },

        // 页面载入完成后调用函数
        on_loaded_func: function($scope){
            // 移除 loading 状态
            global.loading_num -= 1;
            global.loading_hide();

            //gtm使用的scope对象
            window._scope = $scope;  // 标记局部变量，提供给外部访问
        },

        ajax_catch: function(data) {
            $scope.ajax_loading = false;
            console.log("ajax_catch", data);
            alert("获取数据失败:"+data.error);
        },

        get_datas: function ($scope, page) {
            if(!$scope.ajax_loading) {
                $scope.datas.cur_page = page || $scope.datas.page_default;
                $scope.ajax_loading = true;

                $scope.ajax_data()
                    .then($scope.get_datas_callback)
                    .then(function () {
                        $scope.ajax_loading = false;
                    })
                    .catch($scope.ajax_catch);
            }
        },

        get_current_page: function(){
            // 根据页面名字修改body的class
            var url_list = window.location.href.split("#").pop();
            var page = url_list.split("/")[1];
            if(page.indexOf("?") > 0)
            {
                page = page.split("?")[0];
            }
            console.log(page);
            return page;
        },

        /**
         * ajax等待层处理
         * @param showFlag true/false： 显示/隐藏，传false时，以下两个参数省略
         * @param tipWords 可不传，默认显示器"请等待..."
         * @param isShowOverLay 是否显示遮罩层，默认显示
         */
        iloading : function(showFlag, tipWords, isShowOverLay) {
            if (showFlag) {
                var iloadingDom = $("#iloadingbox");
                if (iloadingDom.length > 0) {
                    $("#iloadingbox").show();
                } else {
                    $('body').append(
                        '<div style="z-index: 20000; left: 0px; width: 0px; height: auto; top: 0px; margin-left: 0px;" id="iloadingbox" class="xubox_layer" type="page">' +
                        '<div style="z-index: 20000; height: 0px; background-color: rgb(255, 255, 255);" class="xubox_main">' +
                        '<div class="xubox_page">' +
                        '<div class="xuboxPageHtml">' +
                        '<div id="iLoading_overlay" class="iLoading_overlay" style="display: block;"></div>' +
                        '<div class="iLoading_showbox" style="display: block; opacity: 1;">' +
                        '<div class="iLoading_pic">' +
                        '<div class="iLoading_loading_pic"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<span class="xubox_botton"></span>' +
                        '</div>' +
                        '<div id="xubox_border2" class="xubox_border" style="z-index: 19891015; opacity: 0; top: 0px; left: 0px; width: 0px; height: 0px; background-color: rgb(255, 255, 255);"></div>' +
                        '</div>'
                    );
                }
            } else {
                $("#iloadingbox").hide();
            }
        },

        // 在屏幕中间显示loading图标
        loading_show: function() {
            global.iloading (true, '', false);
        },

        // 在屏幕中间隐藏loading图标
        loading_hide: function() {
            if(global.loading_num <= 0)
            {
                global.loading_num = 0;
                global.iloading (false, '', false);
            }
        },

        // 保存cookie
        set_cookie: function(name,value) {
            var Days = 30;
            var exp = new Date();
            exp.setTime(exp.getTime() + Days*24*60*60*1000);
            document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
        },

        //读取cookies
        get_cookie: function(name) {
            var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

            if(arr=document.cookie.match(reg))
            {
                return unescape(arr[2]);
            }
            else
            {
                return '';
            }
        },

        //删除cookies
        remove_cookie: function(name) {
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var cval = global.get_cookie(name);
            if(cval != '') {
                document.cookie= name + "="+cval+";expires="+exp.toGMTString();
            }
        },

        "goto": function(page){
            console.log(page);
            if(!page || page == '#' || page == '/'){ return; }

            // blur 页面的 input
            try{
                $("input,button").blur();
            }catch(e){}
            var new_page = settings.root + "#/"+page;
            // 计入history的页面跳转
            window.location.href = new_page;
        },

        // init 分页函数
        pageInit : function(max_entries, current_page, callback) {
            $("#Pagination").pagination({
                max_entries: max_entries,
                prev_text: settings.prev_text,
                next_text: settings.next_text,
                items_per_page: settings.items_per_page, //每页的数据个数
                num_display_entries: settings.items_num_edge, //两侧首尾分页条目数
                current_page: current_page,   // 当前页码, 默认初始化为第一页
                num_edge_entries: settings.items_num_edge, //连续分页主体部分分页条目数
                callback: function(page_id, jq){ //为翻页调用次函数。
                    console.log(page_id);
                    console.log(jq);
                    callback(page_id, jq);
                }
            });
        },

        //读取共享存储区域的session字段
        read_storage: function(field){
            //read data from window.localStorage['field']
            field = field || "session";
            var res = {};
            if(settings.can_localStorage){
                var d = window.localStorage[field];
                try{
                    res = JSON.parse(d);
                }catch(e){ res = d; }
            }
            return res || {};
        },
        //默认修改localStorage的session字段
        write_storage: function(field, data){
            var k = null, v = null;
            if(typeof field == "string"){
                k = field;
                v = data;
            }
            else if(typeof field == "object"){
                //only pass a value, write to window.localStorage.session
                k = "session";
                v = field
            }
            else{
                k = "session";
                v = window.session;
            }
            if(settings.can_localStorage){
                window.localStorage[k] = (typeof v == "string") ? v : JSON.stringify(v);
            }
        },
        //为localStorage的field字段添加新的键值对key-data
        set_storage_key: function(field, array){
            if(typeof field == "string" && typeof array == "object"){
                var res = global.read_storage(field);
                for(var item in array){
                    var temp_key = array[item].key;
                    var temp_val = array[item].val;
                    if(typeof temp_key == "string" && typeof temp_val != "undefined"){
                        res[temp_key] = temp_val;
                    }
                }
                global.write_storage(field, JSON.stringify(res));
            }
        },

        // 清除前端注册状态
        clearLoginStatus: function() {
            var temp_session = global.read_storage('session');
            var cleared_session = {
                user: ""
            };
            global.write_storage('session', cleared_session);
        },

        // 退出登录提示，点击作页面跳转
        do_logout: function()
        {
            global.clearLoginStatus();
            global["goto"]("login");
            return false;
        },

        // 获取浏览器版本
        versions : function () {
            var u = navigator.userAgent,
                app = navigator.appVersion;
            return {
                trident : u.indexOf('Trident') > -1,
                presto : u.indexOf('Presto') > -1,
                webKit : u.indexOf('AppleWebKit') > -1,
                gecko : u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
                mobile : !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/),
                ios : !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                android : u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                iPhone : u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1,
                iPad : u.indexOf('iPad') > -1,
                webApp : u.indexOf('Safari') == -1,
                QQbrw : u.indexOf('MQQBrowser') > -1,
                weiXin : u.indexOf('MicroMessenger') > -1,
                ucLowEnd : u.indexOf('UCWEB7.') > -1,
                ucSpecial : u.indexOf('rv:1.2.3.4') > -1,
                ucweb : function () {
                    try {
                        return parseFloat(u.match(/ucweb\d+\.\d+/gi).toString().match(/\d+\.\d+/).toString()) >= 8.2
                    } catch (e) {
                        if (u.indexOf('UC') > -1) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }(),
                Symbian : u.indexOf('Symbian') > -1,
                ucSB : u.indexOf('Firefox/1.') > -1
            };
        },

        guid : function () {
            return 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
                return v.toString(16);
            });
        },

        // 检查是否登录
        check_login: function($scope, logined_callback, logout_callback) {
            var param = {
                _method: 'post',
                _url: settings.ajax_url,
                _param: {
                    act: settings.ajax_func.get_user_info // 获取账号相关信息
                }
            };

            global.ajax_data($scope, param,
                function (data) {
                    // 用户没有登录
                    if(data.code == -200)
                    {
                        // 刷新缓存数据
                        $scope.$apply(function(){
                            $scope.data.from = "";
                            $scope.data.mobile = "";
                            $scope.data.userinfo = null;
                            $scope.data.token = "";
                            global.set_storage_key('session', [
                                {key:'mobile', val:''},
                                {key:'from', val:''},
                                {key:'token', val:''},
                                {key:'userinfo', val:''}
                            ]);
                        });
                        // 未登录状态时需要执行的函数
                        if(angular.isFunction(logout_callback))
                        {
                            logout_callback(data);
                        }
                    }
                    else
                    {
                        // 是登录状态时需要执行的函数
                        if(angular.isFunction(logined_callback))
                        {
                            logined_callback(data);
                        }
                    }
                }, [-100,-200]);
        },

        // 调用ajax做服务器端logout操作，【主要为了触发清除App内部登录状态】
        remote_do_logout: function(callback) {
            var param = {
                _method: 'post',
                _url: settings.ajax_url,
                _param: {
                    act: settings.ajax_func.logout
                }
            };
            global.ajax_data({}, params, function (data) {
                console.log(data);
                if (data.code == 200 || data.code == 401) {
                    global.clearLoginStatus();
                    global.clearLoginStatusByPhp( function(){
                      if(angular.isFunction(callback)) {
                          callback();
                      }
                    });
                }
            }, [401]);
        },

        // 初始化地图
        init_map: function($scope) {
            $scope.map = new AMap.Map($scope.datas.map_id,{
                resizeEnable: true,
                rotateEnable:true,
                pitchEnable:true,
                zoom: parseInt(($scope.datas.map_zoom_min + $scope.datas.map_zoom_max)/2),
                pitch:45,
                rotation:0,
                //viewMode:'3D',//开启3D视图,默认为关闭
                expandZoomRange:true,
                zooms:[$scope.datas.map_zoom_min, $scope.datas.map_zoom_max_limit],
            });

        }
    }

    // 扩展array的indexOf方法
    Array.prototype.indexOf = function(el) {
        for (var i = 0, n = this.length; i < n; i++) {
            if (this[i] === el) {
                return i;
            }
        }
        return -1;
    }


    module.exports = {
        session: session,
        settings: settings,
        global: global,
    };

});
