/**
 * @file       main.js
 * @project    Sociopata
 * @developer  Thiago Braga <thiago@sociopata.org>
 * @url        http://sociopata.org
 */

var main = (function () {

    'use strict';
    var

        /**
         * Send mail via ajax
         *
         * @param  HTMLElement form The contact form
         * @return void
         */
        sendMail = function () {
            $.ajax({
                url: 'home/ajax_send',
                type: 'post',
                dataType: 'json',
                data: $('#contact').serialize()
            }).done(function (response) {

            });
        },

        /**
         * Configura a conta de usuário do Google Analytics.
         *
         * @return {[type]}
         */
        setGoogleAnalytics = function () {
            // Google Analytics
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-36613651-1', 'auto');
            ga('send', 'pageview');
        },

        /**
         * Carrega arquivos JavaScript assincronamente.
         *
         * @param  {String}  url   A URL do arquivo JavaScript
         * @param  {String}  id    O ID do objeto <script> (opcional)
         * @param  {Boolean} async Se a requisição será assíncrona (padrão: true)
         * @return {void}
         */
        loadJS = function (url, id, async) {
            var js,
                doc = window.document,
                first_js = doc.getElementsByTagName('script')[0];

            if (doc.getElementById(id)) {
                return;
            }

            js = doc.createElement('script');
            js.src = url;
            js.async = (async === undefined);

            if (id) {
                js.id = id;
            }

            first_js.parentNode.insertBefore(js, first_js);
        },

        /**
         * [description]
         *
         * @param
         * @return
         */
        init = (function () {
            var body = $('body'),
                news = $('#news');

            news.linkify();
            setGoogleAnalytics();

            // Noty Defaults
            $.noty.defaults.layout  = 'topRight';
            $.noty.defaults.theme   = 'bootstrapTheme';
            $.noty.defaults.timeout = 7000;

            // Make a embed youtube dinamically
            // news.find('a[href*="youtu.be"], a[href*="youtube.com"]');

            $('a[href="#"]').on('click', function (event) {
                event.preventDefault();
            });

            $(window).scroll(function () {
                var yPos  = -($(window).scrollTop() / 10),
                    bgpos = yPos + 'px';

                body.css('background-position-y', bgpos);
            });
        }());

}());
