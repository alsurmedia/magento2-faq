/*
 * Copyright (c) 2020. Alsurmedia
 * Author: Santiago Bermejo - sbermejo@alsurmedia.com
 * Site: https://alsurmedia.com
 */

require([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function ($, mageTemplate) {
    "use strict";

    $(document).ready(function () {

        setAccordions();

        function setAccordions() {
            $(".faq__question").accordion({
                collapsible: true,
                heightStyle: "content",
                active: '',
                animate: 250,
                icons: {
                    header: "faq-plus",
                    activeHeader: "faq-minus"
                }
            });
        }

        $('.faq__category').find('ol').find('li').first().addClass('active');

        $('.faqs-list .item > a').on('click', function () {
            if ($(this).parent().children('.description').css('display') !== 'none') {
                $(this).parents('li').removeClass('active', 250, 'easeOutQuad');
            } else {
                $(this).parents('.faq__category').find('ol li').removeClass('active');
                $(this).parents('li').addClass('active', 250, 'easeOutQuad');
            }
            return false;
        });

        $('.faq__category').find('ol li .read-more').click(function () {
            window.location.href = $(this).parent().find('a').attr('href');
        });

        addFeedBackAlsurmediaFaq(1);
        addFeedBackAlsurmediaFaq(0);

        function addFeedBackAlsurmediaFaq(type) {

            var BASE_URL = $('#feedback #BASE_URL').text();
            var selector = null;
            if (type === 1) {
                selector = '#feedback #btn-like';
            } else if (type === 0) {
                selector = '#feedback #btn-dislike';
            }

            $(document).on('click', selector, function () {
                $('#feedback').text($('#feedback #message').text()).addClass('green');
                var formData = new FormData();
                formData.append('type', type);
                $.ajax({
                    url: BASE_URL,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {

                    }
                });
            });
        }
    });
});
