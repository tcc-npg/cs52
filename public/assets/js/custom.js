'use strict';

window.onload = function() {
    console.log('page loaded');

    document.querySelectorAll('label.required').forEach(e => {
        e.setAttribute('title', 'This field is required');
    })
}

function toPhoneOnly(element) {
    let value = element.value;
    value = value.replace(/[^0-9.]/g, '');
    value = value.replace(/(\..*?)\..*/g, '$1');
    if (value.length > 11) {
        value = value.slice(0, 11);
    }

    element.value = value;
}