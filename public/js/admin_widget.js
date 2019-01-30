$(document).ready(function () {

    $(document).ready(function () {
        let imgs = document.getElementsByClassName('change')
        let img_length = imgs.length
        for (let i = 0; i < img_length; i++) {
            (function (i) {
                imgs[i].onclick = function () {
                    if ($(this).css('z-index') == 2) {
                        $(this).removeClass('larger')
                    } else {
                        $(this).addClass('larger')
                    }
                }
            })(i)
        }
    })

})