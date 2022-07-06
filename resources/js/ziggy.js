const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"dusk.login":{"uri":"_dusk\/login\/{userId}\/{guard?}","methods":["GET","HEAD"]},"dusk.logout":{"uri":"_dusk\/logout\/{guard?}","methods":["GET","HEAD"]},"dusk.user":{"uri":"_dusk\/user\/{guard?}","methods":["GET","HEAD"]},"logout":{"uri":"api\/logout","methods":["POST"]},"admin.login":{"uri":"api\/admin\/login","methods":["POST"]},"login":{"uri":"api\/login","methods":["POST"]},"verification.verify":{"uri":"api\/email\/verify\/{user}","methods":["POST"],"bindings":{"user":"id"}},"oauth.callback":{"uri":"api\/oauth\/{driver}\/callback","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
