define(function (require, exports, module) {

    function S4() {
        return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
    }

    var BaseDialogWidget = function()
    {
        this.getPageSize = function () {
            var width = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth),
            height = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
            return {
                width: width,
                height: height
            };
        };
        this.getElementRealSize = function (el) {
            var $el = $(el);
            return {
                width: $el.width(),
                height: $el.height()
            };
        };
    };

    var BasePop = function(opts)
    {
        this.base = BaseDialogWidget;
        this.base.call(this);

        var self = this;
        var doc = $('body');

        this.defaultOpts = {
            prefix : 'myPop_',
            id: '',
            "class": '',    // default, info(blue), warning(orange), customise
            showMask: true,
            clickMask:false,
            type: 'alert',        // message,alert,confirm,custom

            showTitle: true,
            showTitleBtn: true,
            txtTitle: '',        // 蓝色标题文字
            txtContent: '',    // 弹出框内容文字

            isOkHide: false,    // ok 按钮点击不关闭

            isBtnOkHide: false,    // ok 按钮隐藏
            isBtnCancelHide: false,    // Cancel 按钮隐藏
            _OK: function(obj){
                    self.hide();
                },
            _Cancel: function(obj){
                    self.hide();
                },

            btns: [],

            beforeShow: function(){},
            afterHide: function(){}
        };
        this.opts = $.extend(this.defaultOpts, opts);

        this.id = this.opts.id;
        this.timeout_hide = null;
        this.$mask = $('<div class="maskDiv"></div>');
        this.$popdiv = $('<div class="dialogDiv"></div>');
        this.$popTitle = $('<div class="dialogTitle"></div>');
        this.$popBody = $('<div class="dialogBody"></div>');
        this.$popBottom = $('<div class="dialogBottom"></div>');
        this.$popBottomRow = $('<div class="btnRow"></div>');
        this.$titleTxt = $('<h1 class="title"></h1>');
        this.$titleCancel = $('<span class="btn pull-right">&times;</span>');
        this.$btnOk = $('<button class="btn-solid btn-lt">确定</button>');
        this.$btnCancel = $('<button class="btn-light btn-lt">取消</button>');

        var titleTemp = '<button class="btn btn-link btn-nav pull-right">&times;</button><h1 class="title"></h1>';

        this.__init__ = function(){
            this.$titleTxt.append(self.opts.txtTitle);
            this.$popTitle.append(this.$titleTxt)
                          .append(this.$titleCancel);
            //console.log(self.opts);
            this.$popBody.append(self.opts.txtContent);

            this.$popBottom.append(this.$popBottomRow);

            this.$popBottomRow.append(this.$btnCancel);
            this.$popBottomRow.append(this.$btnOk);
            if(this.opts.isBtnOkHide)
            {
                this.$btnOk.hide();
            }
            if(this.opts.isBtnCancelHide)
            {
                this.$btnCancel.hide();
            }

            // add custom btns
            for(var i=0; i<this.opts.btns.length; i++)
            {
                b = $.extend({
                        text: '',
                        "class": '',
                        _click: function(){}
                    }, self.opts.btns[i]);

                this.$btnCancel.before($('<button class="btnItems '+b["class"] +'">'+b.text+'</button>')
                                            .data('i', i)
                                            .on('click', function(){
                                                self.opts.btns[($(this).data('i'))]._click(self);
                                            })
                                        );
            }

            this.$popdiv.append(this.$popTitle);
            this.$popdiv.append(this.$popBody);
            this.$popdiv.append(this.$popBottom);
            this.$popdiv.addClass(this.opts.type+'Div');

            doc.append(this.$mask);
            doc.append(this.$popdiv);

            this.resetWithType();

            this.bindFunc();

            this.opts.beforeShow();

            this.show();
        };

        this.resetWithType = function()
        {
            if(this.opts.type == 'alert')
            {
                this.$popTitle.hide();
                this.$btnCancel.hide();
                this.$btnOk.css({'width': '100%'});
            }
            else if(this.opts.type == 'message')
            {
                this.$popTitle.hide();
                this.$popBottom.hide();
            }
            else if(this.opts.type == 'confirm')
            {
                //this.$popTitle.hide();
            }
            else if(this.opts.type == 'custom')
            {
                if(this.opts.txtTitle == '' || !this.opts.showTitle)
                {
                    this.$popTitle.hide();
                }
                //console.log(this.$popBottomRow.width());
                //console.log((this.$popBottomRow.width()/(this.opts.btns.length+2) - 10));
            }

            if(this.opts.txtTitle == '' || !this.opts.showTitle)
            {
                this.$popTitle.hide();
            }

            if( !this.opts.showTitleBtn ) {
                this.$titleCancel.hide();
            }

            /*
            var bl = this.$popBottomRow.find('button:visible').length;
            this.$popBottomRow.find('button:visible').css({
                                    'width': (((this.$popBottomRow.width() - (bl-1)*0) - 0)/bl)*100/(this.$popBottomRow.width()-0) + '%'
                                })
                                .first().css({'margin-left': '0px'})
            */
        };

        this.bindFunc = function(){
            //this.$mask.on('click', function(){
            this.$btnOk.on('click', function(){
                self.opts._OK(self);
                if(!self.opts.isOkHide)
                {
                    self.hide();
                }
            });

            this.$btnCancel.on('click', function(){
                self.opts._Cancel(self);
                self.hide();
            });

            this.$titleCancel.on('click', function(){
                self.hide();
                self.opts._Cancel(self);
            });

            if(this.opts.clickMask || this.opts.type == 'message')
            {
                // 添加点击空白处隐藏功能
                this.$mask.on('click', function(){
                    self.hide();
                });
                // 添加点击空白处隐藏功能
                this.$popdiv.on('click', function(){
                    self.hide();
                });
            }
        };

        this.show = function(){
            this.$mask.show();
            this.$popdiv.show().css('visibility', 'hidden');
            $('.maskDiv,.dialogDiv ').bind("touchmove", function (e) {
                e.preventDefault(); // 阻止滑动
            });
            $('.maskDiv').css('height',document.body.scrollHeight);
            setTimeout(function(){
                var ws = self.getPageSize();
                var popwh = self.getElementRealSize(self.$popdiv);
                self.$mask.css({
                    width: ws.width,
                    height: ws.height
                });
                self.$popdiv.css({
                    top: ($(window).height()-popwh.height)/2 - 80 + $(document).scrollTop(),
                    //left:(ws.width-popwh.width)/2,
                    visibility: 'visible'
                });
            }, 0);

            // 如果传入自动隐藏时间, 调用自动隐藏
            if(!isNaN(this.opts.time) && this.opts.time > 0)
            {
                this.timeout_hide = setTimeout(function(){
                    self.hide();
                }, self.opts.time * 1000);
            }
            if(this.opts["class"] != '')
            {
                this.$popdiv.addClass(this.opts["class"]);
            }

        };

        this.hide = function()
        {
            //self.$mask.hide();
            //self.$popdiv.hide();
            clearTimeout(this.timeout_hide);
            self.$mask.empty().remove();
            self.$popdiv.empty().remove();
            this.opts.afterHide();
        };

        self.__init__();
        return this;
    }



    // 封装好的方法实例
    var MyMsg = function(opts)
    {
        //str, classtype, time
        var opts = {
            id: 'MyConfirm_'+Math.random(),
            clickMask: true,    // 点击旁边遮罩层可隐藏
            type: 'message',
            "class": opts.classtype,    // default, info(blue), warning(orange), customise
            txtContent: opts.str,
            time: opts.time,
            afterHide: opts.afterHide
        }
        this.base = BasePop;
        this.base.call(this, opts);
    }
    var MyConfirm = function(opts)
    {
        opts = $.extend({
                            id: 'MyConfirm_'+Math.random(),
                            type: 'confirm',
                            "class" : 'default'
                        }, opts);
        this.base = BasePop;
        this.base.call(this, opts);
    }

    /*
     var opts = {
     id: 'MyPop_'+Math.random(),
     type: 'custom',
     class: classtype,    // default, info(blue), warning(orange), customise
     txtTitle: title,
     txtContent: content,
     _OK: function(obj){
     alert('ok');
     },
     _Cancel: function(obj){

     },
     btns: [
     {
     text: '按钮1',
     class: 'btn btn-positive',
     _click: function(obj){
     alert('自定义按钮1');
     }
     },
     {
     text: '按钮2',
     class: 'btn btn-negative',
     _click: function(obj){
     alert('自定义按钮2');
     obj.otherFunc();
     obj.hide();
     }
     }
     ]
     }
     */
    var MyCustomPop = function(opts)
    {
        var _type = opts.type ? opts.type : "info";
        var icon = "info_icon";
        if(_type == 'success')
        {
            icon = "success_msg_icon";
        }
        else if(_type == 'warning')
        {
            icon = "warning_icon";
        }
        else if(_type == 'error')
        {
            icon = "error_msg_icon";
        }

        var $body = $("<div></div>");
        $body.append("<div class='title'>" + opts.txtContent + "</div>");

        opts.txtContent = $body;

        opts = $.extend({
                            id: 'MyPop_'+Math.random()
                        }, opts);

        this.base = BasePop;
        this.base.call(this, opts);
    };



    //充值确认框
    var RechargeConfirm = function(content, callback)
    {
        if (!content) {
            content = '<p class="text" style="text-align: left; font-size:15px;">' +
                '亲，充值成功后将在16:00自动申购金腾通货币基金。<br><br>' +
                '申购金额=账户余额-保留金额<br><br>' +
                '您也可以在16:00前通过全能行客户端银证转账转出可取金额。</p>';
        }
        var opts = {
            id: 'MyPop_'+Math.random(),
            type: 'custom',
            "class": '',    // default, info(blue), warning(orange), customise
            txtTitle: "",
            txtContent: content,
            _OK: callback
            //_Cancel: function(obj){}
        }
        this.base = BasePop;
        this.base.call(this, opts);

        this.otherFunc = function()
        {
            alert('other functions is called11111');
        }
    }

    //密码确认框
    var PwdPop = function(callback, isOkHide, text)
    {
        if (!text) {
            text = "亲，请输入交易密码";
        }
        var opts = {
            id: 'pwdPop',
            type: 'custom',
            "class": 'pwdpop',
            txtTitle: '',
            isOkHide: isOkHide,
            txtContent: '<div class="win_title">'+
                    '<div class="pic">'+
                        '<img src="../../web/src/images/icon12.png" width="32" height="32">'+
                    '</div>'+
                    '<div class="text">' + text + '</div>'+
                '</div>'+
                '<div id="textbtn">'+
                    '<input type="password" class="pwd_input" placeholder="请重新输入密码" id="password" maxlength="6">'+
                '</div>'+
                '<div id="failtext"></div>'+
                '<p class="pwd_p" id="errorTips" style="display: none">亲，密码错误！</p>',
            _OK: callback,
            //_Cancel: function(obj){},
            btns: []
        }
        this.base = BasePop;
        this.base.call(this, opts);

        this.otherFunc = function()
        {
            alert('other functions is called11111');
        }

    }

    //短信验证码确认框
    var SmsPop = function(callback, content) {
        var opts = {
            id: 'pwdPop',
            type: 'custom',
            "class": 'pwdpop',
            txtTitle: '',
            isBtnCancelHide:false,
            isBtnOkHide: false,
            txtContent: content,
                // '<div class="win_title">'+
                // '<div class="pic">'+
                // '<img src="../../web/src/images/icon12.png" width="32" height="32">'+
                // '</div>'+
                // '<div class="text">' + text + '</div>'+
                // '</div>'+
                // '<div id="textbtn">'+
                // '<input type="number" class="pwd_input" placeholder="请输入短信验证码" id="sms_input" maxlength="6">'+
                // '</div>'+
                // '<div id="failtext"></div>'+
                // '<p class="pwd_p" id="errorTips" style="display: none">亲，验证码错误！</p>',
            _OK: callback,
            //_Cancel: function(obj){},
            btns: []
        }
        this.base = BasePop;
        this.base.call(this, opts);

        this.otherFunc = function() {
            alert('other functions is called11111');
        }

    }

    /**
     * 通用弹出框
     * @param param
     * param.type 弹出框类型
     * param.content 弹出框内容
     * @constructor
     */
    var Pop = function(param){
        var pop = "";
        if (param.type == "msg") {
            if ("" != pop) {

            } else {
                pop = new MyMsg(param.content);
            }
        } else if (param.type == "recharge") {
            if ("" != pop) {

            } else {
                pop = new RechargeConfirm(param.content);
            }
        } else if (param.type == "pwd") {
            if ("" != pop) {

            } else {
                pop = new PwdPop();
            }
        } else if (param.type == "sms") {
            if ("" != pop) {

            } else {
                pop = new SmsPop(param.content);
            }
        }
        return pop;
    };

    var MyAlert = function(msg, callback, type, extra_class, btn_txt)
    {
        // ios 先 blur 输入框
        $("input").blur();
        var _type = type ? type : "info";
        if(!angular.isFunction(callback))
        {
            if(angular.isString(callback))
            {
                _type = callback;
            }
        }

        var c = new MyConfirm({
            id: 'MyPop_'+Math.random(),
            type: 'custom',
            "class" : 'window_alert ' + extra_class,
            txtContent: "<div style='text-align: center; margin-bottom: 20px;'>" + msg + "</div>",
            isBtnOkHide: true,
            isBtnCancelHide: true,
            btns: [
            {
                text: typeof btn_txt == "undefined" ? '知道了' : btn_txt,
                "class": 'btn-solid btn-lt',
                _click: function(obj){
                    obj.hide();
                    if(angular.isFunction(callback))
                    {
                        callback();
                    }
                }
            }]
        });
    }

    var MyAlertError = function(msg, callback, type, extra_class, btn_txt)
    {
        arr = msg.split("->");
        // ios 先 blur 输入框
        $("input").blur();
        var _type = type ? type : "info";
        if(!angular.isFunction(callback))
        {
            if(angular.isString(callback))
            {
                _type = callback;
            }
        }
        var icon = "info_icon";
        if(_type == 'success')
        {
            icon = "success_msg_icon";
        }
        else if(_type == 'warning')
        {
            icon = "warning_icon";
        }
        else if(_type == 'error')
        {
            icon = "error_msg_icon";
        }

        var $body = $("<div></div>");
        $body.append("<div class='title'>" +"<h4>"+ arr[0] +"</h4>" + "</div>");

        var c = new MyConfirm({
            id: 'MyPop_'+Math.random(),
            type: 'custom',
            "class" : 'window_alert ' + extra_class,
            txtContent: $body,
            isBtnOkHide: true,
            isBtnCancelHide: true,
        });
    }

    module.exports = {
        MyAlertError: MyAlertError,
        MyAlert: MyAlert,
        PwdPop: PwdPop,
        SmsPop: SmsPop,
        MyCustomPop: MyCustomPop,
        MyConfirm: MyConfirm,
        MyMsg: MyMsg,
        BaseDialogWidget: BaseDialogWidget
    };

});
