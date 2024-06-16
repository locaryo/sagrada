<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TRSH26BG" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script src="<?=$_ENV['WEB_URL']?>assets/js/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="<?=$_ENV['WEB_URL']?>assets/js/aos.js?v=<?=filemtime('assets/js/aos.js')?>"></script>
<script src="<?=$_ENV['WEB_URL']?>assets/js/main.js?v=<?=filemtime('assets/js/main.js')?>"></script>
<script src="<?=$_ENV['WEB_URL']?>assets/js/datepicker.min.js?v=<?=filemtime('assets/js/datepicker.min.js')?>"></script>
<script src="//code.tidio.co/rtlhokzis61ystldcuxhnzlr5n1bakga.js" async></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script type="module" src="assets/js/cookieconsent-config.js?v=<?=filemtime('assets/js/cookieconsent-config.js')?>"></script>
<script>
    let prices = {
        qtya: <?=$amountValues->qtya?>,
        qtyb: <?=$amountValues->qtyb?>,
        qtyc: <?=$amountValues->qtyc?>,
    };

    const dropdownBtns = document.querySelectorAll(".dropdown-btn");
    const dropdownContents = document.querySelectorAll(".dropdown-content");

    dropdownBtns.forEach((dropdownBtn, i) => {
        dropdownBtn.addEventListener("click", () => {
            dropdownContents[i].classList.toggle("show");
        });
    });

    document.body.addEventListener("click", (event) => {
        dropdownContents.forEach((dropdownContent, i) => {
            if (!dropdownContent.contains(event.target) && !dropdownBtns[i].contains(event.target)) {
                dropdownContent.classList.remove("show");
            }
        });
    });

    const setSelectedLocale = (locale) => window.location.href = `./?lang=${locale}`;

    // Check if the URL contains an anchor
    if (window.location.hash) {
        // Remove the anchor from the URL
        history.replaceState(null, document.title, window.location.pathname);
        
        // Scroll to the top of the page
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }

    $(document).ready(function () {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });

        $('.menu-area nav li a[href^="#"], .mobile-menu nav li a[href^="#"]').on("click", function (e) {
            e.preventDefault();

            const targetSection = $($(this).attr("href"));
            const offset = 60; // Adjust this value according to your header height

            $("html, body").animate({ scrollTop: targetSection.offset().top - offset }, 800);
        });

        const validateTickets = () => {
            const qty_a = $($('.Ticket_quantity[data-input=qty__a]')[0]).find('.counter__input').val();
            const qty_b = $($('.Ticket_quantity[data-input=qty__b]')[0]).find('.counter__input').val();
            const qty_c = $($('.Ticket_quantity[data-input=qty__c]')[0]).find('.counter__input').val();

            $.ajax({
                url: "<?=$_ENV['API_URL']?>api/attraction/stock",
                data: {
                    attraction: <?=$_ENV['ATTRACTION_ID']?>,
                    lang: '<?=strtolower($userLanguage['code'])?>',
                    date: datepickerValue,
                    time: datepickerHour
                }
            }).done(function(stock){
                if (stock.warning == 'auto-purchase disabled') {
                    $(".Ticket_purchase_error").hide()
                    $(".Ticket_purchase").removeClass("disabled");
                } else {
                    hasError = false
                    
                    if(stock.qty_a < qty_a) {
                        hasError = true
                        $(".Ticket_purchase_error_qty_a").text("<?=__('error.qty_a', ['num' => "%num%"])?>".replace('%num%', stock.qty_a));
                        $(".Ticket_purchase_error_qty_a").show()
                    }

                    if(stock.qty_b < +qty_b) {
                        hasError = true
                        $(".Ticket_purchase_error_qty_b").text("<?=__('error.qty_b', ['num' => "%num%"])?>".replace('%num%', stock.qty_b));
                        $(".Ticket_purchase_error_qty_b").show()
                    }

                    if(stock.qty_c < qty_c) {
                        hasError = true
                        $(".Ticket_purchase_error_qty_c").text("<?=__('error.qty_c', ['num' => "%num%"])?>".replace('%num%', stock.qty_c));
                        $(".Ticket_purchase_error_qty_c").show()
                    }

                    if (hasError) {
                        $(".Ticket_purchase_error").show()
                        $(".Ticket_purchase").addClass("disabled")
                    } else {
                        $(".Ticket_purchase_error").hide()
                        $(".Ticket_purchase").removeClass("disabled")
                    }
                }
            }).fail(function(){
                $("#stockError").show()
                $(".Ticket_purchase").addClass("disabled")
            });
        }

        <?php if (isset($loadFormScript) && !!$loadFormScript) { ?>
        (function($) {
            $.fn.inputFilter = function(callback, errMsg) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
                    if (callback(this.value)) {
                        // Accepted value
                        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0) {
                            $(this).removeClass("input-error");
                            this.setCustomValidity("");
                        }
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        // Rejected value - restore the previous one
                        $(this).addClass("input-error");
                        this.setCustomValidity(errMsg);
                        this.reportValidity();
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        // Rejected value - nothing to restore
                        this.value = "";
                    }
                });
            };
        }(jQuery));
        
        let focusedTicketInput, datepickerValue = "", datepickerFormat = "", datepickerHour = "";
        $(".Ticket_purchase").addClass("disabled")
        $(".Ticket_purchase_error").hide()
        $("#calendar_ticket_purchase").addClass("d-none")
        
        const calculateAmount = (redirect) => {
            const qty_a = $($('.Ticket_quantity[data-input=qty__a]')[0]).find('.counter__input').val();
            const qty_b = $($('.Ticket_quantity[data-input=qty__b]')[0]).find('.counter__input').val();
            const qty_c = $($('.Ticket_quantity[data-input=qty__c]')[0]).find('.counter__input').val();
            const total = (qty_a * prices.qtya) + (qty_b * prices.qtyb) + (qty_c * prices.qtyc);
            if (total > 0) {
                $(".Ticket_total").text(`${total}€`)
                $("#calendar_ticket_purchase").removeClass("d-none")
                localStorage.setItem("qty_a", qty_a)
                localStorage.setItem("qty_b", qty_b)
                localStorage.setItem("qty_c", qty_c)
                localStorage.setItem("total", `${total}€`)
                if (datepickerHour != "") {
                    $(".Ticket_purchase").removeClass("disabled")
                    if (datepickerValue != "" && datepickerFormat != "") {
                        localStorage.setItem("fecha", datepickerValue)
                        localStorage.setItem("fecha_formatted", datepickerFormat)
                        if (!!redirect) window.location.href = "purchase.php"
                        validateTickets()
                    }
                }
            } else {
                $("#totalAmount").hide()
                $(".Ticket_total").text("0")
                $(".Ticket_purchase").addClass("disabled")
                $("#calendar_ticket_purchase").addClass("d-none")
            }
        }

        $('.counter__input').inputFilter(function(value) {
            return /^\d*$/.test(value);
        }, '<?=__('error.onlynumber')?>').on('input', function (e) {
            $input = $(this);
            $(`.Ticket_quantity[data-input=${$input.closest('div.Ticket_quantity').data('input')}]`).find('.counter__input').val($input.val());
            calculateAmount();
        }).on('focus', function () {
            if (focusedTicketInput == this) return; //already focused, return so user can now place cursor at specific point in input.
            focusedTicketInput = this;
            setTimeout(function () { focusedTicketInput.select(); }, 100); //select all text in any field on focus for easy re-entry. Delay sightly to allow focus to "stick" before selecting.
        });

        $(".counter__increment, .counter__decrement").click(function (e) {
            e.preventDefault()
            $this = $(this);
            $counter__input = $(this).parent().find(".counter__input");
            $currentVal = parseInt($(this).parent().find(".counter__input").val());
            if (isNaN($currentVal)) { $currentVal = 0; }
            let nextVal;
            if ($this.hasClass('counter__increment')) {
                nextVal = $currentVal + 1;
                $counter__input.val(nextVal);
            } else if ($this.hasClass('counter__decrement')) {
                if ($currentVal >= 1) {
                    nextVal = $currentVal - 1;
                    $counter__input.val(nextVal);
                }
            }
            if ($currentVal != 0) $(`.Ticket_quantity[data-input=${$this.closest('div.Ticket_quantity').data('input')}]`).find('.counter__input').val(nextVal);
            calculateAmount();
        });

        $('.Ticket_purchase').click(function(e){
            e.preventDefault();
            calculateAmount(true);
        });
        
        const currentDate = new Date();
        
        const picker = datepicker("#datepicker", {
            autoClose: false,
            alwaysShow: true,
            startDay: 1,
            maxDate: addDays(currentDate, <?=$_ENV['CALENDAR_CHECK_DAYS']?>),
            minDate: currentDate,
            customMonths: <?=json_encode($calendarMonths)?>,
            customDays: <?=json_encode($calendarDaysAbbrev)?>,
            <?php if (count($calendarDisabledDates) > 0) { ?>
                disabledDates: [<?php for ($i=0; $i < count($calendarDisabledDates); $i++) { ?>
                    new Date(<?=$calendarDisabledDates[$i][0]?>, <?=$calendarDisabledDates[$i][1]-1?>, <?=$calendarDisabledDates[$i][2]?>)<?=$i!=count($calendarDisabledDates)-1?',':''?>
                <?php } ?>],
                events: [<?php for ($i=0; $i < count($calendarDisabledDates); $i++) { ?>
                    new Date(<?=$calendarDisabledDates[$i][0]?>, <?=$calendarDisabledDates[$i][1]-1?>, <?=$calendarDisabledDates[$i][2]?>)<?=$i!=count($calendarDisabledDates)-1?',':''?>
                <?php } ?>],
            <?php } ?>
            onShow: (instance) => $(".qs-datepicker-container div.qs-num.qs-square:not(-qs-event):not(.qs-disabled):first").addClass('qs-first-available'),
            onSelect: (instance, d) => {
                datepickerHour = "";
                datepickerValue = formatDate(d);
                datepickerFormat = d.toLocaleDateString("<?=$userLanguage['code']?>", {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                });
                $(".Ticket_purchase").addClass("disabled")
                $(".datepicker").val(datepickerFormat);
                $("#time-select").html(``);
                $.ajax({
                    url: "<?=$_ENV['API_URL']?>api/attraction/schedule",
                    data: {
                        attraction: <?=$_ENV['ATTRACTION_ID']?>,
                        days: '<?=$_ENV['CALENDAR_CHECK_DAYS']?>',
                        date: datepickerValue
                    }
                }).done(function(schedule){
                    let options = "", options_a = "", options_b = "";
                    for (let i = 0; i < schedule.length; i++) {
                        const time = schedule[i].split(":");
                        if (time[0] < 12) {
                            options_a += `<div class="col-4 col-md-3 p-1 my-2 rounded text-center btn-hour" data-hour="${schedule[i]}">${schedule[i]}</div>`;
                        } else {
                            options_b += `<div class="col-4 col-md-3 p-1 my-2 rounded text-center btn-hour" data-hour="${schedule[i]}">${schedule[i]}</div>`;
                        }
                    }
                    if (options_a != "" || options_b != "") {
                        options = `<div class="row">`;
                        if (options_a != "") {
                            options += `<div class="col col-12 text-center fw-light mt-2"><small><?=__('modal.schedula_1')?></small></div>${options_a}`
                        }
                        if (options_b != "") {
                            options += `<div class="col col-12 text-center fw-light mt-2"><small><?=__('modal.schedula_2')?></small></div>${options_b}`
                        }
                        options += `</div>`
                    }
                    $("#time-select").html(options !== "" ? options : `<div class="col text-center mb-2"><?=__('modal.error_1')?></div>`);
                }); 
                $.ajax({
                    url: "<?=$_ENV['API_URL']?>api/attraction/prices/override",
                    data: {
                        attraction: <?=$_ENV['ATTRACTION_ID']?>,
                        date: datepickerValue
                    }
                }).done(function(override){
                    prices = override;
                    calculateAmount(false);
                });
            }
        });

        $(this).on('click', '.btn-hour', function (e) {
            e.preventDefault();
            datepickerHour = $(this).data('hour');
            localStorage.setItem("hora", datepickerHour);
            $(".btn-hour").removeClass('bg-primary text-white');
            $(this).addClass('bg-primary text-white');
            calculateAmount();
        });

        $(".datepicker").click(function (e) {
            e.stopPropagation();
            $("#pickerModal").modal('show');
        });

        function addDays(date, days) {
            let result = new Date(date);
                result = result.setDate(result.getDate() + days);
            return new Date(result);
        }

        function formatDate(d) {
            return [d.getFullYear(), ("0" + (d.getMonth() + 1)).slice(-2), ("0" + d.getDate()).slice(-2)].join('-');
        }
        
        <?php } else if (isset($loadPurchaseScript) && !!$loadPurchaseScript) { ?>
        const regexEmail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        
        $(document).ready(function(){
            validateForm();

            $("#Ticket__schedule").text(localStorage.getItem('fecha_formatted') || "");
            $("#Ticket__datetime").text(localStorage.getItem('hora') || "");
            $("#Ticket__qty_a").text(localStorage.getItem('qty_a') || "0");
            $("#Ticket__qty_b").text(localStorage.getItem('qty_b') || "0");
            $("#Ticket__qty_c").text(localStorage.getItem('qty_c') || "0");
            $("#Ticket__total").text(localStorage.getItem('total') || "0");
            
            $('#paymentModal').on('show.bs.modal', function (e) {
                prepareCheckout();
            });
            $('#paymentModal').on('hidden.bs.modal', function (e) {
                $("#payment-method-loader").show();
            });

            $("#contact_firstname").on("input propertychange", function(e) {
                e.preventDefault();
                validateForm();
                $("#contact_firstname").removeClass('error-input');
                if ($("#contact_firstname").val().length < 1 || !$("#contact_firstname").val().replace(/\s/g, '').length) {
                    $("#contact_firstname").addClass('error-input');
                    return false
                }
            })

            $("#contact_lastname").on("input propertychange", function(e) {
                validateForm();
                $("#contact_lastname").removeClass('error-input');
                if ($("#contact_lastname").val().length < 1 || !$("#contact_lastname").val().replace(/\s/g, '').length) {
                    $("#contact_lastname").addClass('error-input');
                    return false
                }
            })

            $("#contact_email").val($("#contact_email").val().replace(/\s/g, ''));
            $("#contact_email").on("input propertychange", function(e) {
                e.preventDefault();
                validateForm();
                $("#contact_email").removeClass('error-input');
                if (!regexEmail.test($("#contact_email").val())) {
                    $("#contact_email").addClass('error-input');
                    return false
                }
            })

            $("#contact_email_check").val($("#contact_email_check").val().replace(/\s/g, ''));
            $("#contact_email_check").on("input propertychange", function(e) {
                e.preventDefault();
                validateForm();
                $("#contact_email_check").removeClass('error-input');
                if (!regexEmail.test($("#contact_email_check").val())) {
                    $("#contact_email_check").addClass('error-input');
                    return false
                }
            })

            $("#checkbox").on("input propertychange", function(e) {
                e.preventDefault();
                validateForm();
                $("#checkbox").removeClass('error-input');
                if (!$("#checkbox").is(':checked')) {
                    $("#checkbox").addClass('error-input');
                    return false
                }
            })
        });

        function validateForm() {
            $("#paymentAction").prop('disabled', true);
            $("#paymentAction").addClass('disabled');
            
            $("#contact_email").val($("#contact_email").val().replace(/\s/g, ''));
            $("#contact_email_check").val($("#contact_email_check").val().replace(/\s/g, ''));

            if ($("#contact_firstname").val().length < 1) {
                return false
            }
            
            if ($("#contact_lastname").val().length < 1) {
                return false
            }
            
            if (!regexEmail.test($("#contact_email").val())) {
                $("#contact_email").addClass('error-input');
                return false;
            }
            
            if (!regexEmail.test($("#contact_email_check").val())) {
                $("#contact_email_check").addClass('error-input');
                return false;
            }

            if ($("#contact_email").val().toLowerCase() != $("#contact_email_check").val().toLowerCase()) {
                $("#contact_email").addClass('error-input');
                $("#contact_email_check").addClass('error-input');
                return false;
            } else {
                $("#contact_email").removeClass('error-input');
                $("#contact_email_check").removeClass('error-input');
            }

            if (!$("#checkbox").is(':checked')) {
                return false;
            }

            $("#paymentAction").prop('disabled', false);
            $("#paymentAction").removeClass('disabled');
        }

        const stripe = Stripe('<?=$_ENV['STRIPE_KEY_'.$_ENV['STRIPE_MODE']]?>', {
            locale: '<?=$userLanguage['code']?>'
        });

        let elements, paymentElement, paymentIdentifier;

        document
            .querySelector("#btn-checkout")
            .addEventListener("click", handleSubmit);

        async function prepareCheckout () {
            setLoading(true);

            if (!!paymentElement) {
                paymentElement.unmount();
                paymentElement.destroy();
            }

            $("#payment-spinner").hide();

            try {
                const { clientSecret, orderId } = await fetch("<?=$_ENV['STRIPE_URL']?>/checkout", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        rtime: localStorage.getItem('hora'),
                        rdate: localStorage.getItem('fecha'),
                        qty_a: $("#Ticket__qty_a").text() || 0,
                        qty_b: $("#Ticket__qty_b").text() || 0,
                        qty_c: $("#Ticket__qty_c").text() || 0,
                        total: $("#Ticket__total").text().replace('€', ''),
                        firstname: $("#contact_firstname").val(),
                        lastname: $("#contact_lastname").val(),
                        email: $("#contact_email").val(),
                        phone: "123456789",
                        redirect: "<?=$_ENV['REDIRECT_URL']?>",
                        description: "<?=$_ENV['WEB_NAME']?>",
                        aid: "<?=$_ENV['ATTRACTION_ID']?>",
                        lang: "<?=$userLanguage['code']?>",
                        currency: "<?=$userCurrency?>"
                    }),
                })
                .then((r) => {
                    if (!r.ok) {
                        // make the promise be rejected if we didn't get a 2xx response
                        throw new Error("Not 2xx response", {cause: r});
                    } else {
                        return r.json()
                    }
                })

                elements = stripe.elements({ clientSecret });
                const paymentElementOptions = {
                    layout: {
                        type: 'accordion',
                        defaultCollapsed: false,
                        radios: false,
                        spacedAccordionItems: true
                    },
                    fields: {
                        billingDetails: {
                            name: 'never',
                            email: 'never',
                        }
                    }
                };

                paymentElement = elements.create("payment", paymentElementOptions);
                paymentElement.mount("#payment-element");

                $("#payment-method-loader").fadeOut('slow');

                paymentIdentifier = orderId;
                
                setLoading(false);
            } catch (e) {
                showMessage("<?=__('error.purchase')?>", true);
                setLoading(false, true);
            }
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);
            $("#payment-message").hide();
            
            $.ajax({
                url: "<?=$_ENV['API_URL']?>api/attraction/stock",
                data: {
                    attraction: <?=$_ENV['ATTRACTION_ID']?>,
                    lang: '<?=strtolower($userLanguage['code'])?>',
                    date: localStorage.getItem('fecha'),
                    time: localStorage.getItem('hora')
                }
            }).done(async function(stock){
                hasError = false
                
                if (stock.warning != 'auto-purchase disabled') {
                    if (stock.warning == "no ticket available") {
                        showError = true;
                    } else {
                        const qty_a = +$("#Ticket__qty_a").text() || 0;
                        const qty_b = +$("#Ticket__qty_b").text() || 0;
                        const qty_c = +$("#Ticket__qty_c").text() || 0;
                        
                        if(stock.qty_a < qty_a) {
                            hasError = true
                        }

                        if(stock.qty_b < +qty_b) {
                            hasError = true
                        }

                        if(stock.qty_c < qty_c) {
                            hasError = true
                        }
                    }
                }
                
                if (hasError) {
                    showMessage("<?=__('error.purchase')?>");
                } else {
                    const { error } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            return_url: `<?=$_ENV['REDIRECT_URL']?>?oid=${paymentIdentifier}&total=${$("#total").text().replace('€', '')}&currency=<?=$userCurrency?>`,
                            payment_method_data: {
                                billing_details: {
                                    name: `<?=$_ENV['STRIPE_NAME']?>: ${$("#contact_firstname").val()} | ${$("#contact_lastname").val()}`,
                                    email: $("#contact_email").val()
                                }
                            }
                        },
                    });

                    if (error.type === "card_error" || error.type === "validation_error") {
                        showMessage(error.message);
                    } else {
                        showMessage("<?=__('checkout.failed3')?>");
                    }
                }
            }).always(function(){
                setLoading(false);
            });
        }

        function showMessage(messageText, html) {
            $("#payment-message").show();
            if (!!html) $("#payment-message").html(messageText);
            else $("#payment-message").text(messageText);
        }

        function setLoading(isLoading, error) {
            $("#paymentModal").find(".modal-body.p-4").show();
            if (isLoading) {
                $("#payment-loading-spinner").show();
                $("#payment-message").hide();
                $("#btn-checkout").show();
                $("#btn-checkout").prop('disabled', true);
                $("#btn-checkout").addClass('disabled');
                $("#payment-spinner").show();
                $("#btn-payment-text").hide();
            } else {
                $("#payment-loading-spinner").hide();
                $("#payment-spinner").hide();
                $("#btn-payment-text").show();
                $("#btn-checkout").prop('disabled', false);
                $("#btn-checkout").removeClass('disabled');
                if (!!error) {
                    $("#paymentModal").find(".modal-body.p-4").hide();
                    $("#btn-checkout").hide();
                }
            }
        }
        <?php } ?>
    });
</script>