/**
 * 发起赞
 * @param {string} model
 * @param {int} model_id
 * @param callback
 */
function support(model, model_id, callback) {
    callback = callback || jQuery.noop;
    jQuery.post("/support/support/store", {model: model, model_id: model_id}, function (result) {
        return callback(result.status);
    });
}

/**
 * 发起赞
 * @param {string} model
 * @param {int} model_id
 * @param callback
 */
function checkSupport(model, model_id, callback) {
    callback = callback || jQuery.noop;
    jQuery.post("/support/support/check", {model: model, model_id: model_id}, function (result) {
        return callback(result.status);
    });
}