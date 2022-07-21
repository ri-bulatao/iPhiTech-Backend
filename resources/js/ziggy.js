const Ziggy = {"url":"http:\/\/127.0.0.1:8000","port":8000,"defaults":{},"routes":{"dusk.login":{"uri":"_dusk\/login\/{userId}\/{guard?}","methods":["GET","HEAD"]},"dusk.logout":{"uri":"_dusk\/logout\/{guard?}","methods":["GET","HEAD"]},"dusk.user":{"uri":"_dusk\/user\/{guard?}","methods":["GET","HEAD"]},"logout":{"uri":"api\/logout","methods":["POST"]},"user.profile":{"uri":"api\/user","methods":["GET","HEAD"]},"settings.update.profile":{"uri":"api\/settings\/profile","methods":["PATCH"]},"settings.update.password":{"uri":"api\/settings\/password","methods":["PATCH"]},"announcements.list":{"uri":"api\/announcements","methods":["GET","HEAD"]},"announcements.single":{"uri":"api\/announcements\/{id}","methods":["GET","HEAD"]},"announcements.store":{"uri":"api\/announcements","methods":["POST"]},"announcements.upload":{"uri":"api\/announcements\/upload","methods":["POST"]},"announcements.post":{"uri":"api\/announcements\/post","methods":["PUT"]},"announcements.update":{"uri":"api\/announcements\/update\/{id}","methods":["PUT"]},"announcements.delete":{"uri":"api\/announcements\/{id}","methods":["DELETE"]},"notifications.list":{"uri":"api\/notifications","methods":["GET","HEAD"]},"notifications.unread":{"uri":"api\/notifications\/unread","methods":["GET","HEAD"]},"notifications.update":{"uri":"api\/notifications\/{id}","methods":["PUT"]},"notifications.delete":{"uri":"api\/notifications\/{id}","methods":["DELETE"]},"position.list":{"uri":"api\/positions\/fetch","methods":["GET","HEAD"]},"position.single":{"uri":"api\/positions\/{id}","methods":["GET","HEAD"]},"position.store":{"uri":"api\/positions","methods":["POST"]},"position.update":{"uri":"api\/positions\/update\/{id}","methods":["PUT"]},"position.delete":{"uri":"api\/positions\/{id}","methods":["DELETE"]},"admin_user.list":{"uri":"api\/admin_user\/fetch","methods":["GET","HEAD"]},"admin_user.single":{"uri":"api\/admin_user\/{id}","methods":["GET","HEAD"]},"admin_user.store":{"uri":"api\/admin_user","methods":["POST"]},"admin_user.update":{"uri":"api\/admin_user\/update\/{id}","methods":["PUT"]},"admin_user.delete":{"uri":"api\/admin_user\/{id}","methods":["DELETE"]},"handbook.all":{"uri":"api\/handbook","methods":["GET","HEAD"]},"handbook.show":{"uri":"api\/handbook\/{id}","methods":["GET","HEAD"]},"handbook.download":{"uri":"api\/handbook\/download\/{id}","methods":["GET","HEAD"]},"handbook.store":{"uri":"api\/handbook","methods":["POST"]},"handbook.update":{"uri":"api\/handbook\/update\/{id}","methods":["PUT"]},"handbook.delete":{"uri":"api\/handbook\/{id}","methods":["DELETE"]},"handbook_page.all":{"uri":"api\/handbook_page\/{id}","methods":["GET","HEAD"]},"handbook_page.show":{"uri":"api\/handbook_page\/single\/{id}","methods":["GET","HEAD"]},"handbook_page.store":{"uri":"api\/handbook_page","methods":["POST"]},"handbook_page.update":{"uri":"api\/handbook_page\/update\/{id}","methods":["PUT"]},"handbook_page.delete":{"uri":"api\/handbook_page\/{id}","methods":["DELETE"]},"attendances.today":{"uri":"api\/attendance\/today","methods":["GET","HEAD"]},"attendances.list":{"uri":"api\/attendance","methods":["GET","HEAD"]},"attendances.time_in":{"uri":"api\/attendance\/timein","methods":["POST"]},"attendances.time_out":{"uri":"api\/attendance\/timeout","methods":["PUT"]},"attendances.employee":{"uri":"api\/attendance\/employee","methods":["GET","HEAD"]},"attendances.show":{"uri":"api\/attendance\/get\/{id}","methods":["GET","HEAD"]},"attendances.update":{"uri":"api\/attendance\/update\/{id}","methods":["PUT"]},"attendances.delete":{"uri":"api\/attendance\/delete\/{id}","methods":["DELETE"]},"course_category.list":{"uri":"api\/course_category\/fetch","methods":["GET","HEAD"]},"course_category.single":{"uri":"api\/course_category\/{id}","methods":["GET","HEAD"]},"course_category.store":{"uri":"api\/course_category","methods":["POST"]},"course_category.update":{"uri":"api\/course_category\/update\/{id}","methods":["PUT"]},"course_category.delete":{"uri":"api\/course_category\/{id}","methods":["DELETE"]},"course.list":{"uri":"api\/course\/fetch","methods":["GET","HEAD"]},"course.single":{"uri":"api\/course\/{id}","methods":["GET","HEAD"]},"course.store":{"uri":"api\/course","methods":["POST"]},"course.update":{"uri":"api\/course\/update\/{id}","methods":["PUT"]},"course.delete":{"uri":"api\/course\/{id}","methods":["DELETE"]},"course.upload":{"uri":"api\/course\/upload","methods":["POST"]},"leaves.list":{"uri":"api\/leave","methods":["GET","HEAD"]},"leaves.single":{"uri":"api\/leave\/{id}","methods":["GET","HEAD"]},"leaves.store":{"uri":"api\/leave","methods":["POST"]},"leaves.update":{"uri":"api\/leave\/{id}","methods":["PUT"]},"leaves.delete":{"uri":"api\/leave\/{id}","methods":["DELETE"]},"user_course.list":{"uri":"api\/user_course","methods":["GET","HEAD"]},"user_course.single":{"uri":"api\/user_course\/{id}","methods":["GET","HEAD"]},"user_course.subscribe":{"uri":"api\/user_course\/subscribe","methods":["POST"]},"user_course.unsubscribe":{"uri":"api\/user_course\/unsubscribe\/{id}","methods":["DELETE"]},"user_course.process":{"uri":"api\/user_course\/process","methods":["PUT"]},"course_comment.store":{"uri":"api\/course_comment\/post","methods":["POST"]},"course_comment.delete":{"uri":"api\/course_comment\/{id}","methods":["DELETE"]},"admin.login":{"uri":"api\/admin\/login","methods":["POST"]},"login":{"uri":"api\/login","methods":["POST"]},"register":{"uri":"api\/register","methods":["POST"]},"password.email-reset":{"uri":"api\/password\/email","methods":["POST"]},"password.reset":{"uri":"api\/password\/reset","methods":["POST"]},"verification.verify":{"uri":"api\/email\/verify\/{user}","methods":["POST"],"bindings":{"user":"id"}},"verification.resend":{"uri":"api\/email\/resend","methods":["POST"]},"oauth.redirect":{"uri":"api\/oauth\/{driver}","methods":["POST"]},"oauth.callback":{"uri":"api\/oauth\/{driver}\/callback","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
