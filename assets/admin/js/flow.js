var base_url = $("#myBase").attr('href');
$(function () {
    miningflow._loginvalidate();
    miningflow._contactvalidate();
    miningflow.payouts();
    miningflow.set_accept_cookie();
    miningflow._requestvalidate();
});


miningflow = {
    _loginvalidate: function () {
        jQuery.validator.addMethod("validebtc", function (value, element) {
            var validadd = validatebtc(value);
            if (validadd) {
                return true;
            } else {
                return false;
            };
        }, "This is not valid BTC address");
        $("#login-form").validate({
            rules: {
                baddress: {
                    required: true,
                    validebtc: true
                }
            },
            messages: {
                baddress: {
                    required: "Please enter address",
                }
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                error.insertAfter(element);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".padding-leftright-null").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".padding-leftright-null").addClass("has-success").removeClass("has-error");
            },
            submitHandler: function (form) {
                var address = document.getElementById('baddress').value;
                //var reffid = document.getElementById('reffid').value;, reffid: reffid
                miningflow.ajax_req({ baddress: address}, '/userlogin').done(function (response) {
                    if (response.auth === true) {
                        miningflow.notifyWithtEle(response.msg, response.type , 'topRight', 1000);
                        setTimeout(() => {
                            $("#mySidenav").hide();
                            window.location = "/dashboard";
                        },2000)
                    } else {
                        $("#mySidenav").hide();
                        miningflow.notifyWithtEle('OOops Something Went Wrong Please Try after some time.', 'danger', 'topRight', 2000);
                    }
                });
                return false;
            }
        });
    },
    _requestvalidate :() =>{

        if (("#requestForm").length > 0) {
            $("#requestForm").validate({
                ignore: ".ignore",
                rules: {
                    fullname: {
                        required: true
                    }, 
                    email: {
                        required: true,
                        email: true
                    },
                    phone : {
                        required: true,
                        digits: true,
                    },
                    message: {
                        required: true
                    },
                    hiddenRecaptcha: {
                        required: function () {
                            if (grecaptcha.getResponse() == '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                messages: {
                    fullname: {
                        required : "Please enter your Firstname."
                    },
                    email: {
                        required: "Please enter a email address.",
                        email: "Please enter a valid email address."
                    },
                    phone: {
                        required : "Please enter your mobile no.",
                    },
                    message: {
                        required : "Please enter your message."
                    },
                    hiddenRecaptcha: {
                        required: "Please verify captcha."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".padding-leftright-null").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".padding-leftright-null").addClass("has-success").removeClass("has-error");
                }
            });
        }
    },
    _contactvalidate : () => {
        if (("#contactform").length > 0) {
            $("#contactform").validate({
                ignore: ".ignore",
                rules: {
                    fname: {
                        required: true
                    }, 
                    lname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone : {
                        required: true,
                        digits: true,
                    },
                    message: {
                        required: true
                    },
                    hiddenRecaptcha: {
                        required: function () {
                            if (grecaptcha.getResponse() == '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                messages: {
                    fname: {
                        required : "Please enter your Firstname."
                    },
                    lname: {
                        required : "Please enter your Lastname."
                    },
                    email: {
                        required: "Please enter a email address.",
                        email: "Please enter a valid email address."
                    },
                    phone: {
                        required : "Please enter your mobile no.",
                    },
                    message: {
                        required : "Please enter your message."
                    },
                    hiddenRecaptcha: {
                        required: "Please verify captcha."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".padding-leftright-null").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".padding-leftright-null").addClass("has-success").removeClass("has-error");
                }
            });
        }
    },
    _bountyvalidate: () => {
        $("#bountyform").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                profile_link:{
                    required: true,
                },
                no_friend:{
                    required: true,
                },
                verify_captcha: {
                    required: true,
                }
            },
            messages: {
                email: {
                    required: "Please enter mail address.",
                    email: "Please enter valid mail address.",
                },
                profile_link: {
                    required: "Please enter your Social Handler Profile Link."
                },
                no_friend: {
                    required: "Please enter your Number of Friends/Followers."
                },
                verify_captcha: {
                    required: "Please enter Verify Captcha."
                }
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                error.insertAfter(element);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".padding-leftright-null").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".padding-leftright-null").addClass("has-success").removeClass("has-error");
            },
            submitHandler: function (form) {
                var address = document.getElementById('baddress').value;
                var reffid = document.getElementById('reffid').value;
                miningflow.ajax_req({ baddress: address, reffid: reffid }, '/userlogin').done(function (response) {
                    if (response.auth === true) {
                        miningflow.notifyWithtEle(response.msg, response.type, 'topRight', 1000);
                        setTimeout(() => {
                            $("#mySidenav").hide();
                            window.location = "/profile";
                        }, 2000)
                    } else {
                        $("#mySidenav").hide();
                        miningflow.notifyWithtEle('OOops Something Went Wrong Please Try after some time.', 'danger', 'topRight', 2000);
                    }
                });
                return false;
            }
        });
    },
    _earnBalance: () => {
        setInterval(() => {
            var oldvalue = $('#newtext').val();
            var result = parseFloat(parseFloat(oldvalue) + (parseFloat(curpermin) / 60)).toFixed(9);
            $("#newtext").val(result);
            var newresult = parseFloat(result).toFixed(8);
            $('.changetext').html(newresult);
        }, 1000);
    },
   /* _upgrade: () => {
        if (($(".get_payto_address").length > 0)){
            $(".get_payto_address").click(function() {
                package_id = $(this).attr('data-packageid');
                miningflow.showAjaxModal({ package_id: package_id }, '/upgrade');
            });
        }
    },*/
    showAjaxModal: (data, url) => {
        $('#myModal .modal-body .plan-poup').html('<div class="linear-background"></div><div class="inter-crop"></div><div class="inter-right--bottom"></div></div >');

        $('#myModal').modal('show', { backdrop: 'true' });

        miningflow.ajax_req(data , url).done(function (response) {
            $('#myModal .modal-body .plan-poup').html(response);
        });
        return false;
    },
    _withdraw : () => {
        $("#btnwithdraw").on('click', () => {
            
            let newTitle = document.getElementById('btnwithdraw').value;
            alert(newTitle);
            var earning = parseFloat($(".changetext").html()).toFixed(8);

            $(".alert-message").html("Min " + min_with_limit + " BTC");
            $(".alert-message").show();

            if(newTitle == "Withdraw") {
                document.getElementById('btnwithdraw').value = "Confirm";
                $('.changetext').hide()
                $("#widthsum").val(earning);
                $("#widthsum").show();
                $(".licancle").show();
                $(".liaccount").hide();
            }else{
                $(".alert-message").html("Confirming the Withdrawal....");
                $("#widthsum").hide();
                $(".licancle").hide();
                $(".liaccount").show();
                $('.changetext').show()
                document.getElementById('btnwithdraw').value = "Withdraw";

                miningflow.ajax_req({ amount: earning }, '/withdrawal').done(function (response) {
                    if(response.success === true){
                        miningflow.notifyWithtEle(response.msg, response.type, 'topRight', 2000);
                        setTimeout(() => {
                            window.location = "/account?tab=finance";
                        }, 2000)
                    }else{
                        miningflow.notifyWithtEle(response.msg, response.type , 'topRight', 2000);
                    }
                });
                return false;
            }
        });
    },
    openCity : (evt, cityName) => {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    },

    // Get the element with id="defaultOpen" and click on it
    notifyWithtEle: function (msg, type, pos, timeout) {
        pos = "";
        timeout = "";
        var noty = new Noty({
            theme: 'metroui',
            text: msg,
            type: type,
            layout: (pos != "") ? pos : 'topRight',
            timeout: (timeout != "") ? timeout : 2000,
            closeWith: ['click'], 
            animation: {
                open: 'animated slideInRight',
                close: 'animated slideOutRight'
            }
        });
        noty.show();
    },
    ajax_req: function (fields, url) {
        return $.ajax({
            url: base_url + url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: fields,
            datatype: "application/json"
        });
    },

    payouts: function () {
        if ($("#payoutTable").length > 0) {
            let offset = parseInt($("#loadMore").attr('data-number'));
            $('#payoutTable tr:last').after('<tr id="loader"><td colspan="4"><div class="FB-Loading-Card"><div></div><div></div><div></div></div></td></tr>');
            miningflow.ajax_req({ offset: offset }, '/ajaxpayouts').done(function (response) {
                if (response.success == true) {
                    console.log("last tr >>> ", $('tbody#payoutTable tr:last'));
                    $('#payoutTable tr:last').remove();
                    $("#payoutBody").append(response.result);
                    let off_num = offset + 10;
                    $("#loadMore").attr('data-number', off_num);
                }
            });
            return false;
        }
    },
    _updateMail: () => {
        let email = $("#email").val();
        miningflow.ajax_req({ email: email }, '/updatemail').done(function (response) {
            if (response.success === true) {
                miningflow.notifyWithtEle(response.msg, response.type, 'topRight', 2000);
                $("#noty_mail").modal('hide');
            } else {
                $("#noty_mail").modal('hide');
                miningflow.notifyWithtEle('OOops Something Went Wrong Please Try after some time.', 'danger', 'topRight', 2000);
            }
        });
        return false;
    },
    _autoReload : () => {
        $("#auto-reload").submit();
    },
    set_accept_cookie: function () {

        if ($('#accept_btn').length > 0) {
            var accept_btn = document.getElementById('accept_btn');
            accept_btn.addEventListener("click", function () {
                $(".window_wrapp").hide();
                miningflow.setCookie('accept_cookies', '1', 7200);
            });
        }
    },
    setCookie: function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    _copy: function (element){
        if (document.selection) { // IE
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(element));
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(document.getElementById(element));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        }
        document.execCommand("copy");
        $(element).html("Copied !!!");
    }
};