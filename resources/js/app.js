require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.private('orders')
    .listen('.order.created', function (event) {
        alert(`New Order Created ${event.order.number}`)
    });

const chat = window.Echo.join('chat')
    .here((users) => {
        console.log(users);
    })
    .joining((user) => {
        $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">User ${user.name} Joined !</div>`);
    })
    .leaving((user) => {
        $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">User ${user.name} Leave !</div>`);
    })
    .listen('.message', function (event) {
        addMessage(event);
    })
    .listenForWhisper('typing', (e) => {
        $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">${e.name} Typing !</div>`);
    });

(function ($) {
    $('#chat-form').on('submit', function (event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function (res) {
            $('#chat-form input').val('');
        })
    })
})(jQuery);

function addMessage(event) {
    $('#messages').append(`<div class="shadow-sm my-5 sm:rounded-lg">${event.sender.name}: ${event.message}</div>`); 
}

$('#chat-form input').on('keypress', function() {
    chat.whisper('typing', {
        name: 'Someone Typing'
    });
});

