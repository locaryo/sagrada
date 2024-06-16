<?php $loadFormScript = true ?>
<div class="hero__form" data-aos="fade-up" >
    <h3><?=__('form.text_1')?></h3>
    <p><img src="<?=$_ENV['WEB_URL']?>assets/img/info_icon.svg" alt=""> <?=__('form.text_2')?></p>
    <p class="Ticket_purchase_error">
        <span class="Ticket_purchase_error Ticket_purchase_error_qty_a"></span><br>
        <span class="Ticket_purchase_error Ticket_purchase_error_qty_b"></span><br>
        <span class="Ticket_purchase_error Ticket_purchase_error_qty_c"></span>
    </p>
    <div class=" form__content">
        <div class="hero__form__blk">
            <label for="">
                <?=__('form.text_3')?>
                <img alt="info icon"
                    src="<?=$_ENV['WEB_URL']?>assets/img/info_icon.svg"
                    data-bs-toggle="popover"
                    data-bs-placement="bottom"
                    data-bs-trigger="hover"
                    data-bs-html="true"
                    data-bs-content="<?=__('tooltip.text_1')?>">
            </label>
            <div class="Ticket_quantity" data-input="qty__a">
                <button type="button" class="counter__decrement">-</button>
                <input type="text" class="counter__input" value="0">
                <button type="button" class="counter__increment">+ </button>
            </div>
        </div>
        <div class="hero__form__blk">
            <label for="">
                <?=__('form.text_4')?>
                <img alt="info icon"
                    src="<?=$_ENV['WEB_URL']?>assets/img/info_icon.svg"
                    data-bs-toggle="popover"
                    data-bs-placement="bottom"
                    data-bs-trigger="hover"
                    data-bs-html="true"
                    data-bs-content="<?=__('tooltip.text_2')?>">
            </label>
            <div class="Ticket_quantity" data-input="qty__b">
                <button type="button" class="counter__decrement">-</button>
                <input type="text" class="counter__input" value="0">
                <button type="button" class="counter__increment">+ </button>
            </div>
        </div>
        <div class="hero__form__blk">
            <label for="">
                <?=__('form.text_7')?>
                <img alt="info icon"
                    src="<?=$_ENV['WEB_URL']?>assets/img/info_icon.svg"
                    data-bs-toggle="popover"
                    data-bs-placement="bottom"
                    data-bs-trigger="hover"
                    data-bs-html="true"
                    data-bs-content="<?=__('tooltip.text_3')?>">
            </label>
            <div class="Ticket_quantity" data-input="qty__c">
                <button type="button" class="counter__decrement">-</button>
                <input type="text" class="counter__input" value="0">
                <button type="button" class="counter__increment">+ </button>
            </div>
        </div>
        <div class="hero__form__blk">
            <label for=""><?=__('form.text_5')?></label>
            <input type="text" class="datepicker" placeholder="<?=$calendarDatePlaceholder?>" readonly>
        </div>
        <div class="hero__form__blk sb_btn order-last order-md-5">
            <a href="#!" class="thm_btn Ticket_purchase"><?=__('form.text_6')?> <img src="<?=$_ENV['WEB_URL']?>assets/img/right-arrow.svg" alt=""></a>
        </div>
        <div class="hero__form__blk total__price order-5 order-md-last">
            <h1><?=__('form.total')?>: <span class="Ticket_total"></span></h1>
        </div>
    </div>
</div>