function tabSwitch(type) {
    console.log(type)
    type = String(type) + 'Tab'
    var clickedField = type + 'field';
    jQuery('.sticky-field').css('display','none');
    jQuery('.' + clickedField).fadeIn('slow');
    jQuery('.nav-tab').removeClass('nav-tab-active')
    jQuery('.' + type).addClass('nav-tab-active')
}