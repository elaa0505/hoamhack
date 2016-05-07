/**
 * @module
 * This module defines the settings that need to be configured for a new
 * environment.
 * The clientId and clientSecret are provided when you create
 * a new security profile in Login with Amazon.  
 * 
 * You will also need to specify
 * the redirect url under allowed settings as the return url that LWA
 * will call back to with the authorization code.  The authresponse endpoint
 * is setup in app.js, and should not be changed.  
 * 
 * lwaRedirectHost and lwaApiHost are setup for login with Amazon, and you should
 * not need to modify those elements.
 */
var config = {
    clientId: 'amzn1.application-oa2-client.daf95c1636c74fc384e4630c42607d71',
    clientSecret: '0e18e989d6ef2ae8d3d357ebe9fa6fb5ec51a1f7c9cfa7f6b99dfd3e771c07d2',
    redirectUrl: 'https://localhost:3000/authresponse',
    lwaRedirectHost: 'amazon.com',
    lwaApiHost: 'api.amazon.com',
    validateCertChain: true,
    sslKey: '/Users/harlassal/repos/hoamhack/AlexaVoiceServiceExamples/samples/javaclient/certs/server/node.key',
    sslCert: '/Users/harlassal/repos/hoamhack/AlexaVoiceServiceExamples/samples/javaclient/certs/server/node.crt',
    sslCaCert: '/Users/harlassal/repos/hoamhack/AlexaVoiceServiceExamples/samples/javaclient/certs/ca/ca.crt',
    products: {
        "my_device": ["123456"] // Fill in with valid device values, eg: "testdevice1": ["DSN1234", "DSN5678"]
    }
};

module.exports = config;
