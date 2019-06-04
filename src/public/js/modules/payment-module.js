// noinspection JSUnusedGlobalSymbols,JSUnusedLocalSymbols
function PaymentModule(language) {

    // noinspection ES6ConvertVarToLetConst
    this.languageId = language;

    // noinspection JSUnusedGlobalSymbols
    this.cardInfo = function (aliasNumber) {
        // noinspection JSUnusedLocalSymbols,ES6ConvertVarToLetConst
        var that = this;
        // noinspection ES6ConvertVarToLetConst
        var uri = 'search/card/get-info/' + aliasNumber + '/' + that.languageId;
        // noinspection JSUnresolvedVariable
        $.get(uri, function (response) {
            // noinspection JSUnresolvedFunction
            $('#card-info-container').html(response);
        });
    };

    // noinspection JSUnusedGlobalSymbols
    this.productProfile = function (aliasNumber, rechargeTypeId, zoneId) {
        // noinspection JSUnresolvedVariable,JSUnresolvedFunction
        $.post('get-product-profile', {
            'alias-number': aliasNumber,
            'recharge-type-id': rechargeTypeId,
            'zone-id': zoneId
        }, function (response) {
            // noinspection JSUnresolvedFunction
            $('#product-profile-container').html(response);
        });
    };

}