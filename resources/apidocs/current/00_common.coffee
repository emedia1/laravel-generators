###
@apiDefine RequestHeader

@apiDescription
  Common headers.

@apiHeader (Header Params) {String} X-api-key   API Key. Use the pre-defined API Key issued.
@apiHeader (Header Params) {String} X-device-id  UUID (or the unique identifier) for the device.
@apiHeader (Header Params) {String} X-device-type  Type of the device. (eg. apple, android etc)
@apiHeader (Header Params) {String} X-push-token  Push notification token for the device.

@apiErrorExample {json} Invalid Token 401
{
    "message": "Token expired. Please update your app from the App Store."
}

@apiErrorExample {json} Missing Params 400
{
    "result": false,
    "message": "The x-device-type field is required. The x-push-token field is required."
}
###