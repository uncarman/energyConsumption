
function deepCopy(data){
    return JSON.parse(JSON.stringify(data));
}


    MyAlert = alert;
    var session = {
        mobile: "",
        password: ""
    };

    var settings = {
        default_datas :{
            ajax_loading: false,  // 是否正在执行ajax

            // 分页参数
            page_default: 1,        // 默认第一页
            items_per_page: 10,     // 数据每页显示10条
            items_num_edge: 3,      // 两侧首尾，主体分页条目数
            prev_text: "上一页",    // 上一页文字
            next_text: "下一页",    // 下一页文字
        },
        default_page : "dashboard",

        is_fake_ajax : true,
        is_debug : true,
        fake_sms : true,
        can_localStorage: true, // 能否使用 localStorage
        sms_cd: 60, //短信验证码cd (单位:秒)
        msg_duration: 12, //弹出提示框持续时间, 单位:秒
        root: "",

        domain: "",  // 接口地址
        cross_domain: true,
        ajax_timeout: 30*1000, //ajax超时时间 (单位:毫秒)



        ajax_func: {
            login: "login",
            getLoginCode: "api/backend/v1/base/verify",
            user: "user",
            getList: "getList",
            profile: "profile",

            "baseTableList": "/system/base/table_list", // table列表
            "baseTableDetail": "/system/base/table_detail/{table_name}", // table列表


            "ajaxGetSummary": "/ajax_get_building_total", //
            "ajaxGetSummaryByDate": "/ajax_get_building_total_by_date", //
            "ajaxGetMeters": "/ajax_get_meters", //
            "ajaxGetMeterDatas": "/ajax_get_meter_datas", //

            "ajaxGroupTree": "/building/ajaxGroupTree", //

        },

        // 分页参数
        items_per_page: 10,     // 数据每页显示10条
        items_num_edge: 3,      // 两侧首尾，主体分页条目数
        prev_text: "上一页",    // 上一页文字
        next_text: "下一页",    // 下一页文字

        ajax_succ_code : 10000,       // ajax 成功code
        ajax_auth_failed_code : 4,       // ajax 失败code
        ajax_error_msg: {    // ajax请求，错误码对应错误信息
            "0": "请求成功",
            "1": "服务器内部错误",
            "2": "服务器维护中",
            "3": "接口版本过低",
            "4": "用户验证失败",
            "5": "操作被拒绝",
        },

        colors : ["#ff7f50", "#87cefa", "#da70d6", "#32cd32", "#6495ed", "#ff69b4",
            "#ba55d3", "#cd5c5c", "#ffa500", "#40e0d0", "#1e90ff", "#ff6347", "#7b68ee",
            "#00fa9a", "#ffd700", "#6699FF", "#ff6666", "#3cb371", "#b8860b", "#30e0e0"],

    };

    var global = {
        loading_num: 0,    // for ajax loading number record

        copy: function (obj){
            return angular.copy(obj);
        },

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

            // 补充 sign 信息
            //_param = global.generateSign(_param);

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
                    console.log(url, data);
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

            // 添加formData需要的参数
            if(param["_is_form_file"] === true) {
                req.dataType = "json";
                req.cache = false; // 上传文件无需缓存
                req.processData = false; // 用于对data参数进行序列化处理 这里必须false
                req.contentType = false; // 必须
            }

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

        get_datas_prev: function  ($scope) {
            var page = Math.max(1,($scope.datas.cur_page-1));
            if(page != $scope.datas.cur_page) {
                $scope.get_datas($scope, page);
            }
        },

        get_datas_next : function ($scope) {
            var page = Math.min($scope.datas.pageList.length,($scope.datas.cur_page+1));
            if(page != $scope.datas.pageList.length) {
                $scope.get_datas($scope, page);
            }
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

        //校验手机号码
        check_mobile_number: function(mobile_number){
            var re = /^1[0-9]{10}$/;
            if (!mobile_number || !re.test(mobile_number)) {
                return false;
            }
            return true;
        },

        //校验真实姓名
        check_real_name: function(name){
            //var re = /^([\u4e00-u9fa5]|[\ufe30-uffa0])*$/gi;
            var re = /^([\u4e00-\u9fa5]|[\ufe30-\uffa0]){2,8}$/i;
            if (!name || !re.test(name)) {
                return false;
            }
            return true;
        },

        //校验银行卡号
        check_bankcard_number: function(bankcard_number) {
            var re = /^\d{8,}$/;
            return re.test(bankcard_number);
        },

        // 验证身份证合法性
        id_card_validate:function(id_card){
            id_card = $.trim(id_card.replace(/ /g, ""));               //去掉字符串头尾空格
            if (id_card.length == 15) {
                return false;       //进行15位身份证的验证
            } else if (id_card.length == 18) {
                var a_id_card = id_card.split("");                // 得到身份证数组
                if(global.fn_card_id(id_card).status){   //进行18位身份证的基本验证和第18位的验证
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },

        //校验交易密码或资金密码
        check_pwd: function(pwd){
            var re = /^\d{6}$/;
            return re.test(pwd);
        },

        // 校验登录密码规则
        // 返回：
        //    成功： null
        //    失败： 错误信息
        check_login_pwd: function(pwd)
        {
            if(pwd)
            {
                // 校验规则改为 6-16位的数字或字母组合
                // var fail = !/(?!^\d+$)(?!^[A-z]+$)(?!^[^A-z\d]+$)^.{6,16}$/.test(pwd) || /[\u4E00-\u9FA5]/.test(pwd);
                // return fail ? '密码为6~16位的数字和字母组合' : null;
                var fail = !/^[A-z0-9]{6,16}$/.test(pwd) || /[\u4E00-\u9FA5]/.test(pwd);
                return fail ? '密码为6~16位的数字和字母组合' : null;
            }
            else
            {
                return "登录密码不能为空";
            }
        },

        // 替换敏感字符串
        crossfade_str:function (str) {
            if(str == '')
            {
                return '';
            }
            else if(str.length>7)
            {
                var strLeft = str.substr(0, 3);
                var strRight = str.substr(str.length-4, str.length);
                return strLeft + "****" + strRight;
            }
            else
            {
                var strLeft = str.substr(0, str.length/2);
                return strLeft + "****";
            }
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

        /*
         *@ param cardID{string} 要验证的身份证号码
         *@ return {Object} 属性见下列说明
         status : true //是否合法
         alt : 身份证号码合法 //验证提示语
         adress : //地址信息
         birthday : 1990211 //生日
         gender : 男 //性别
         age : 25 //年龄
         zodiac : 蛇 //生肖
         constellation : 水瓶座 //星座
         */
        fn_card_id:function(cardID){
            var
                sCardID = cardID,
                beginYear = new Date().getFullYear() - 110,
                overYear = new Date().getFullYear(),
                aFactor = [7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2], //前17位号码乘数系数
                nDivisor = 11,//积数和除数系数
                aBigMon = [1,3,5,7,8,10,12],
                aSmallMon = [4,6,9,11],
                oRemainder = {'0':1,'1':0,'2':'X','3':9,'4':8,'5':7,'6':6,'7':5,'8':4,'9':3,'10':2},
                nCardIDlength = 18,
                sBirth = null,
                nYear = null,
                nMon = null,
                nDay = null,
                nOrderCode = null,
                nVercode = null,
                oXMLHTTP = null,
                aConstellation = ["水瓶","双鱼","白羊","金牛","双子","巨蟹","狮子","处女","天秤","天蝎","射手","魔羯"],
                aConstellationDate = [20, 19, 21, 21, 21, 22, 23, 23, 23, 23, 22, 22],
                oZodiac = {"0":"猴","1":"鸡","2":"狗","3":"猪","4":"鼠","5":"牛","6":"虎","7":"兔","8":"龙","9":"蛇","10":"马","11":"羊"},
                oReturn = {"status":false,    "alt":"","adress":"","birthday":"","gender":"","age":null,"zodiac":"","constellation":""},
                sVercode = null,
                sErr = "号码非法:",
                sRegDate = /^(?:(?:1[0-9]|[0-9]{2})[0-9]{2}([-/.]?)(?:(?:0?[1-9]|1[0-2])\1(?:0?[1-9]|1[0-9]|2[0-8])|(?:0?[13-9]|1[0-2])\1(?:29|30)|(?:0?[13578]|1[02])\1(?:31))|(?:(?:1[6-9]|[2-9][0-9])(?:0[48]|[2468][048]|[13579][26])|(?:16|[2468][048]|[3579][26])00)([-/.]?)0?2\2(?:29))$/,
                oAlt = {
                    "length":sErr+"长度错误",
                    "adress":sErr+"地址码不存在",
                    "birthday":sErr+"出生日期错误",
                    "ver":sErr+"尾四位校验码错误",
                    "success":"身份证号码合法"
                };
            if(sCardID.length != nCardIDlength ){
                oReturn.alt = oAlt.length;
                return oReturn;
            }
            sBirth = sCardID.slice(6,14);
            if(!sRegDate.test(sBirth)){
                oReturn.alt = oAlt.birthday;
                return oReturn;
            }
            nYear = Number(sCardID.substring(6,10));
            if(nYear < beginYear || nYear > overYear){
                oReturn.alt = oAlt.birthday;
                return oReturn;
            }
            nMon = Number(sCardID.substring(10,12));
            if(nMon<1 || nMon > 12){
                oReturn.alt = oAlt.birthday;
                return oReturn;
            }
            nDay = Number(sCardID.substring(12,14));
            if(nYear == overYear ){
                if(nMon - 1 > new Date().getMonth() || nDay >= new Date().getDate()){
                    oReturn.alt = oAlt.birthday;
                    return oReturn;
                }
            }
            if(nYear%4 == 0 && nMon == 2){//闰年2月
                if(nDay<1 || nMon > 29){
                    oReturn.alt = oAlt.birthday;
                    return oReturn;
                }
            }else if(nYear%4 != 0 && nMon == 2){//非闰年2月
                if(nDay<1 || nMon > 28){
                    oReturn.alt = oAlt.birthday;
                    return oReturn;
                }
            }
            for(var x in aBigMon){
                if(aBigMon[x] == nMon){
                    if(nDay<1 || nMon > 31){
                        oReturn.alt = oAlt.birthday;
                        return oReturn;
                    }
                }
            }
            for(var x in aSmallMon){
                if(aSmallMon[x] == nMon){
                    if(nDay<1 || nMon > 30){
                        oReturn.alt = oAlt.birthday;
                        return oReturn;
                    }
                }
            }
            oReturn.birthday = sCardID.substring(6,14);
            oReturn.age =   overYear - nYear;
            oReturn.zodiac = oZodiac [nYear%12];
            if(nDay >= aConstellationDate[nMon-1]){
                oReturn.constellation = aConstellation[nMon-1]+"座";
            }else{
                oReturn.constellation = aConstellation[nMon-2]+"座";
            }
            if(Number(sCardID.substring(16,17))%2 == 0){
                oReturn.gender = "女";
            }else{
                oReturn.gender = "男";
            }
            var  nSum = 0;
            for(var i = 0 ; i <17; i++){
                nSum += Number(sCardID.substring(i,i+1))*aFactor[i];
            }

            sCardID.substring(17,18) == "x" ||  sCardID.substring(17,18) == "X" ? sVercode = "X" : sVercode = sCardID.substring(17,18);
            if(sVercode !=oRemainder[(nSum%nDivisor).toString()]){
                oReturn.alt = oAlt.ver;
                return oReturn;
            }else{
                oReturn.alt=oAlt.success;
                oReturn.status = true;
                return  oReturn;
            }
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

        // 页面载入时通用初始化函数
        on_load_func: function($scope){
            // 增加 loading 状态
            global.loading_num += 1;
            global.loading_show();

            $scope.settings = settings;

            // 添加公共函数给 $scope
            $scope["copy"] = global["copy"];
            $scope["goto"] = global["goto"];
            $scope.ajax_catch = $scope.ajaxCatch = global.ajax_catch;
            $scope.pageJump = global.pageJump;
            $scope.get_datas = global.get_datas;
            $scope.reset_datas = global.reset_datas;
            $scope.is_view = global.is_view;
            $scope.item_view = global.item_view;
            $scope.item_edit = global.item_edit;
            $scope.item_update = global.item_update;
            $scope.item_remove = global.item_remove;
            $scope.remove_poster = global.remove_poster;
            //$scope.ajax_base_upload = global.ajax_base_upload;
            $scope.get_datas_next = global.get_datas_next;
            $scope.get_datas_prev = global.get_datas_prev;
            $scope.topMenuClick = global.topMenuClick;

            $scope.normalCompareClass = global.normalCompareClass;
            $scope.normalCompareValue = global.normalCompareValue;

            // 前端校验用户登录
            var _session = global.read_storage('session');
            var token = _session.token;
            // if(!token) {
            //     global["goto"]('login');
            // }

            window._scope = $scope;  // 标记局部变量，提供给外部访问
        },

        // 页面载入完成后调用函数
        on_loaded_func: function($scope){
            $scope.settings = settings;

            // 移除 loading 状态
            global.loading_num -= 1;
            global.loading_hide();

            // 初始化当前公共模块(菜单)
            global.init_comm($scope);

            //gtm使用的scope对象
            window._scope = $scope;  // 标记局部变量，提供给外部访问
        },

        ajax_catch: function(data) {
            console.log("ajax_catch", data);
            alert("获取数据失败:"+data.error);
        },

        get_datas: function ($scope, page) {
            if(!$scope.ajax_loading) {
                $scope.datas.cur_page = page || $scope.datas.page_default;
                $scope.ajax_loading = true;

                $scope.ajax_data()
                    .then($scope.get_datas_callback)
                    .catch($scope.ajax_catch);
            }
        },

        reset_datas: function($scope, tp) {
            $scope.datas.cur_page = 1;
            try {
                $scope.datas.opt.state = typeof tp != "undefined" ? tp : $scope.datas.opt.state;
            } catch (ex) {
                // pass
            }
            $scope.get_datas($scope);
        },

        is_view: function ($scope) {
            return $scope.datas.item_view_type == "view";
        },

        item_view: function($scope, pk) {
            $scope.ajax_item_detail(pk)
                .then($scope.item_view_callback)
                .catch($scope.ajax_catch);
        },

        item_edit: function($scope, pk) {
            $scope.ajax_item_detail(pk)
                .then($scope.item_edit_callback)
                .catch($scope.ajax_catch);
        },

        item_update: function ($scope) {
            $scope.ajax_item_update()
                .then($scope.item_update_callback)
                .catch($scope.ajax_catch);
        },

        item_remove: function($scope, good) {
            MyConfirm({
                showTitleBtn: false,
                txtTitle: "确定删除?",
                //txtContent: "<div style='text-align: center; margin-bottom: 20px;'>"+good.name+"</div>",
                _OK: function(obj){
                    $scope.ajax_remove_data(good.pk)
                        .then($scope.item_remove_callback)
                        .catch($scope.ajax_catch);
                    obj.hide();
                },
                _Cancel: function(obj){
                    obj.hide();
                },
                isBtnOkHide: false,
                isBtnCancelHide: false,
            });
        },

        base_add_files: function ($scope, fileId, type, callback) {
            $("#"+fileId).off("change").on("change", function () {
                var fileObj = document.getElementById(fileId).files[0]; // js 获取文件对象
                console.log(fileObj);
                if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                    return;
                }
                var formFile = new FormData();
                formFile.append("file", fileObj); //加入文件对象

                var file_kind = 0;
                if((fileObj.type).indexOf("image/")>=0){
                    file_kind = 0;
                } else if((fileObj.type).indexOf("video/")>=0) {
                    file_kind = 1;
                } else {
                    alert("只能上传图片或视频");
                }
                $scope.datas.upload_file_type = type;
                $scope.datas.upload_file_file_kind = file_kind;
                var callback_func = $scope.add_file_callback;
                if(typeof callback == "function") {
                    callback_func = callback;
                }
                global.ajax_base_upload($scope, formFile)
                    .then(callback_func)
                    .catch($scope.ajax_catch);
            }).click();
        },

        remove_poster: function (ind) {
            if($scope.datas.selected_item && $scope.datas.selected_item["posters"].length > 0) {
                try {
                    $scope.datas.selected_item["posters"].splice(ind, 1);
                    if($scope.datas.selected_item["posters"].length <= 0) {
                        $scope.datas.selected_item["thumbnail"] = "";
                    }
                } catch (e) {
                    // pass
                }
            }
        },

        // 上传文件
        ajax_base_upload: function ($scope, formFile) {
            var param = {
                _method: 'post',
                _url: settings.ajax_func.baseUpload,
                _is_form_file: true,
                _param: formFile
            };
            return global.return_promise($scope, param);
        },

        // add_posters: function ($scope) {
        //     if($scope.datas.selected_good["pk"] != "") {
        //         $("#poster_file").click();
        //         $("#poster_file").off("change").on("change", function () {
        //             var fileObj = document.getElementById("poster_file").files[0]; // js 获取文件对象
        //             console.log(fileObj);
        //             if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
        //                 return;
        //             }
        //             var formFile = new FormData();
        //             formFile.append("file", fileObj); //加入文件对象
        //
        //             var file_kind = 0;
        //             if((fileObj.type).indexOf("image/")>=0){
        //                 file_kind = 0;
        //             } else if((fileObj.type).indexOf("video/")>=0) {
        //                 file_kind = 1;
        //             } else {
        //                 alert("只能上传图片或视频");
        //             }
        //
        //             global.ajax_base_upload($scope, formFile).then(function(data){
        //                 $scope.$apply(function () {
        //                     $scope.datas.selected_item["posters"].push({
        //                         kind: file_kind,
        //                         url: data.data.url,
        //                     });
        //                 });
        //             }).catch(function(data){
        //                 alert("获取数据失败(add_posters):"+data.error);
        //             });
        //         });
        //     }
        // },

        /**
         * ajax等待层处理
         * @param showFlag true/false： 显示/隐藏，传false时，以下两个参数省略
         * @param tipWords 可不传，默认显示器"请等待..."
         * @param isShowOverLay 是否显示遮罩层，默认显示
         */
        iloading : function(showFlag, tipWords, isShowOverLay)
        {
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

        topMenuClick : function (o) {
            console.log(o);
            if($(o).hasClass("open")) {
                $(o).removeClass("open");
            } else {
                $(o).addClass("open");
            }
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

        /**
         * 清除前端注册状态
         *
         */
        clearLoginStatus: function() {
            var temp_session = global.read_storage('session');
            var cleared_session = {
                mobile: "",
                password: "",
                from: temp_session.from || "profile",  // 保留回去的页面地址
                inviter: temp_session.inviter,        // 保留之前的邀请信息
                device: temp_session.device,        // 保留之前的设备信息
                channel_type: temp_session.channel_type,        // 保留之前的渠道信息
                activity_name: temp_session.activity_name,        // 保留之前的活动信息
                token: "",
                openid: temp_session.openid //保留之前的openid
            };
            global.write_storage('session', cleared_session);
        },

        // 退出登录提示，点击作页面跳转
        do_logout: function()
        {
            //MyAlert("您离开页面很久了，请重新登录。", function(){
            global.clearLoginStatus();
            //global["goto"]("login");
            //}, "warning");
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

        // 初始化最基本的scope
        init_base_scope: function ($scope) {
            $scope.base_init_page = function () {
                global.init_top_menu($scope);
                global.init_left($scope);
            };

            //年月日范围
            var sm = shortcutMonth();
            var rangeShortcutOption = [
                {
                    name: '昨天',
                    day: '-1,0',
                },
                {
                    name: '最近7天',
                    day: '-7,0'
                },
                {
                    name: '最近30天',
                    day: '-30,0'
                },
                {
                    name: '最近90天',
                    day: '-90, 0'
                },
                {
                    name: '这一月',
                    day: sm.now,
                },
                {
                    name: '上一个月',
                    day: sm.prev,
                },
                {
                    name: '上二个月',
                    day: sm.prev2,
                },
                {
                    name: '上三个月',
                    day: sm.prev3,
                }
            ];
            function shortcutMonth () {
                // 当月
                var nowDay = moment().get('date');
                var prevMonthFirstDay = moment().subtract(1, 'months').set({ 'date': 1 });
                var prevMonth2FirstDay = moment().subtract(2, 'months').set({ 'date': 1 });
                var prevMonth3FirstDay = moment().subtract(3, 'months').set({ 'date': 1 });
                var prevMonthDay = moment().diff(prevMonthFirstDay, 'days');
                var prevMonth2Day = moment().diff(prevMonth2FirstDay, 'days');
                var prevMonth3Day = moment().diff(prevMonth3FirstDay, 'days');
                return {
                    now: '-' + (nowDay-1) + ',0',
                    prev: '-' + prevMonthDay + ',-' + nowDay,
                    prev2: '-' + prevMonth2Day + ',-' + (prevMonthDay+1),
                    prev3: '-' + prevMonth3Day + ',-' + (prevMonth2Day+1)
                }
            }
            $scope.init_datepicker = function (className) {
                $(function(){
                    $(className).datePicker({
                        //isRange: true,
                        //hasShortcut: true,
                        format: "YYYY-MM-DD",
                        //shortcutOptions: rangeShortcutOption,
                        //between: "year",
                    });
                });
            };

            return $scope;
        },

        fmtEChartData: function (data){
            var tmpSeriesData = [];
            data.datas.map(function (p) {
                tmpSeriesData.push([
                    new Date(p.key),
                    (p.val == "" ? 0 : parseFloat(p.val).toFixed(2))
                ])
            });
            return tmpSeriesData;
        },
        drawEChart: function (echart, opt) {
            echart.setOption(opt, true);
            echart.resize();
        },

        pageJump : function(url) {
            if(url != "") {
                window.location.href = url;
            }
        },

        // 顶部菜单加高亮
        init_top_menu : function($scope){
            try{
                var pages = window.location.pathname.split("/");
                var curPage = "";
                // 检查是否包含buildingId
                if(parseInt(pages[1]) == pages[1]) {
                    $scope.datas.buildingId = pages[1];
                    curPage = pages[2];
                } else {
                    curPage = pages[1];
                }
                $(".top-"+curPage).addClass("active");
            } catch (e) {

            }
        },
        // 通用左侧菜单
        init_left: function ($scope, callback) {
            if($scope.datas.leftOn) {
                $("body").addClass("left-on");
            } else {
                $("body").removeClass("left-on");
            }
            if(typeof callback == "function") {
                callback($scope);
            }
        },

        // 通用筛查条件中 同比数据
        init_compareto: function($scope) {
            var res = [];
            var current = new Date().getFullYear();
            for(var i = $scope.datas.startYear; i<current; i++) {
                res.push({
                    val: i,
                    name: i + "年同期数据"
                });
            }
            $scope.datas.opts.compareTos = res;
        },

        normalCompareClass : function (d, t) {
            if(t == 't') {
                return d > 0 ? 'up' : (d == 0 ? 'right' : 'down');
            } else if(t == 'i') {
                return d > 0 ? 'glyphicon-arrow-up' : (d == 0 ? 'glyphicon-arrow-right' : 'glyphicon-arrow-down');
            } else if(t == 'd') {
                return d == 0 ? 'grey' : '';
            }
        },
        normalCompareValue : function(d) {
            return Math.abs(d).toFixed(2) + '%';
        },

        // 初始化页面公共内容(比如顶部菜单)
        init_comm : function($scope) {
            $scope.top_menus = settings.top_menus;
            $scope.cur_page = global.get_current_page();
            $scope.cur_page_level_1 = global.get_page_detail(global.get_page_name(1, $scope.cur_page));
            $scope.cur_page_level_2 = global.get_page_detail(global.get_page_name(2, $scope.cur_page));
            $scope.cur_page_level_3 = global.get_page_detail(global.get_page_name(3, $scope.cur_page));
        },

        get_page_name: function (level, page_name) {
            let _page = page_name.split("_");
            let _level = Math.max(1, _page.length);

            if(level > _level) {
                for (let i = 0; i < level - _level; i++) {
                    _page.push("1");
                }
            } else {
                _page = _page.slice(0, level);
            }
            return _page.join("_");
        },

        get_page_detail : function (page_name, page) {
            if(typeof page === "undefined") {
                page = settings.top_menus;
            }
            if(angular.isArray(page)) {
                for(let i in page) {
                    if(page[i]['page'] == page_name) {
                        return page[i];
                    } else if(typeof page[i]["children"] !== "undefined" && angular.isArray(page[i]["children"])) {
                        let ch = global.get_page_detail(page_name, page[i]["children"]);
                        if(ch !== null) {
                            return ch;
                        }
                    }
                }
            } else if(angular.isObject(page)) {
                if (page["page"] == page_name) {
                    return page;
                }
                if(typeof page["children"] !== "undefined" && angular.isArray(page["children"])) {
                    return global.get_page_detail(page_name, page["children"]);
                }
            }
            return null;
        },

    };

    // 扩展array的indexOf方法
    Array.prototype.indexOf = function(el) {
        for (var i = 0, n = this.length; i < n; i++) {
            if (this[i] === el) {
                return i;
            }
        }
        return -1;
    }

    // 扩展function的getName方法
    Function.prototype.getName = function(){
        return this.name || this.toString().match(/function\s*([^(]*)\(/)[1]
    }

