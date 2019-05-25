const languageId = 2;

// noinspection ES6ConvertVarToLetConst,JSUnusedGlobalSymbols
var payment = new PaymentModule(languageId);

$(document)

    .on('click', '#search-alias-number', function () {
        payment.cardInfo($('#alias-number').val());
    })

    .on('change', '#recharge-type, #zone', function () {
        // noinspection ES6ConvertVarToLetConst
        var aliasNumber = $('#alias-number').val();
        // noinspection ES6ConvertVarToLetConst
        var rechargeTypeId = $('#recharge-type').val();
        // noinspection ES6ConvertVarToLetConst
        var zoneId = $('#zone').val();
        payment.productProfile(aliasNumber, rechargeTypeId, zoneId);
    });