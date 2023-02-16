yii.confirm = function(message, ok, cancel) {
    bootbox.confirm({
        message: '<h5>'+message+'</h5>',
        buttons: {
            cancel: {
                label: 'Нет',
                className: 'btn-secondary col-3 mx-3'
            },
            confirm: {
                label: 'Да',
                className: 'btn-danger col-3 mx-3'
            },
        },
        callback: function (result) {
            if (result) { !ok || ok(); } else { !cancel || cancel(); }
        }
    })
}