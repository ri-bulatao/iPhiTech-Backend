const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"dusk.login":{"uri":"_dusk\/login\/{userId}\/{guard?}","methods":["GET","HEAD"]},"dusk.logout":{"uri":"_dusk\/logout\/{guard?}","methods":["GET","HEAD"]},"dusk.user":{"uri":"_dusk\/user\/{guard?}","methods":["GET","HEAD"]},"logout":{"uri":"api\/logout","methods":["POST"]},"user.profile":{"uri":"api\/user","methods":["GET","HEAD"]},"settings.update.profile":{"uri":"api\/settings\/profile","methods":["PATCH"]},"settings.update.password":{"uri":"api\/settings\/password","methods":["PATCH"]},"announcement.list":{"uri":"api\/announcements\/fetch","methods":["GET","HEAD"]},"announcement.single":{"uri":"api\/announcements\/{id}","methods":["GET","HEAD"]},"announcement.store":{"uri":"api\/announcements","methods":["POST"]},"announcement.update":{"uri":"api\/announcements\/update\/{id}","methods":["PUT"]},"announcement.delete":{"uri":"api\/announcements\/{id}","methods":["DELETE"]},"position.list":{"uri":"api\/positions\/fetch","methods":["GET","HEAD"]},"position.single":{"uri":"api\/positions\/{id}","methods":["GET","HEAD"]},"position.store":{"uri":"api\/positions","methods":["POST"]},"position.update":{"uri":"api\/positions\/update\/{id}","methods":["PUT"]},"position.delete":{"uri":"api\/positions\/{id}","methods":["DELETE"]},"admin.login":{"uri":"api\/admin\/login","methods":["POST"]},"login":{"uri":"api\/login","methods":["POST"]},"register":{"uri":"api\/register","methods":["POST"]},"password.email-reset":{"uri":"api\/password\/email","methods":["POST"]},"password.reset":{"uri":"api\/password\/reset","methods":["POST"]},"verification.verify":{"uri":"api\/email\/verify\/{user}","methods":["POST"],"bindings":{"user":"id"}},"verification.resend":{"uri":"api\/email\/resend","methods":["POST"]},"oauth.redirect":{"uri":"api\/oauth\/{driver}","methods":["POST"]},"oauth.callback":{"uri":"api\/oauth\/{driver}\/callback","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
