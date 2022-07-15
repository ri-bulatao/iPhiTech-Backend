"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[975],{9198:(t,s,i)=>{i.d(s,{bW:()=>c,ui:()=>a,xO:()=>r});var e=i(6455),n=i.n(e),o=n().mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,timerProgressBar:!0,didOpen:function(t){t.addEventListener("mouseenter",n().stopTimer),t.addEventListener("mouseleave",n().resumeTimer)}}),a=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Question",s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Question description",i=arguments.length>2?arguments[2]:void 0,e=arguments.length>3?arguments[3]:void 0;return new Promise((function(o,a){n().fire({icon:"question",title:t,text:s,showCancelButton:i,confirmButtonText:e}).then((function(t){t.isConfirmed&&o(t),a(t)}))}))},r=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Success",s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Success Message";o.fire({icon:"success",title:t,text:s})},c=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Ooops",s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Something went wrong!";o.fire({icon:"error",title:t,text:s})}},1975:(t,s,i)=>{i.r(s),i.d(s,{default:()=>a});var e=i(629),n=i(9198);const o={name:"admin-user-positions",middleware:"admin",computed:(0,e.Se)({positions:"positions/positions"}),methods:{remove:function(t){var s=this;this.$store.dispatch("positions/removePosition",{id:t}).then((function(t){t.data.success?(s.$store.dispatch("positions/fetchPositions"),(0,n.xO)("Success!",t.data.message)):(0,n.bW)("Oops!","There's something wrong, please try again.")})).catch((function(t){(0,n.bW)("Oops!","There's something wrong, please try again."),console.log(t)}))}}};const a=(0,i(1900).Z)(o,(function(){var t=this,s=t._self._c;return s("div",[s("div",{staticClass:"row"},[s("div",{staticClass:"col-sm-12"},[s("div",{staticClass:"d-flex justify-content-end mb-3"},[s("router-link",{staticClass:"btn btn-success",attrs:{to:{name:"admin.positions.create"}}},[t._v("Create Position")])],1),t._v(" "),s("div",{staticClass:"card"},[s("div",{staticClass:"card-header"},[t._v("\n                    List of positions\n                ")]),t._v(" "),s("div",{staticClass:"card-body"},[s("table",{staticClass:"table table-striped caption-top"},[t._m(0),t._v(" "),s("tbody",t._l(t.positions,(function(i,e){return s("tr",{key:i.id},[s("td",{staticClass:"col-md-1"},[t._v(t._s(e+1))]),t._v(" "),s("td",[t._v(t._s(i.name))]),t._v(" "),s("td",{staticClass:"col-md-2"},[s("router-link",{staticClass:"btn btn-primary btn-sm",attrs:{to:{name:"admin.positions.single",params:{id:i.id}}}},[t._v(" View ")]),t._v(" "),s("button",{staticClass:"btn btn-danger btn-sm",on:{click:function(s){return t.remove(i.id)}}},[t._v("Remove")])],1)])})),0)])])])])])])}),[function(){var t=this,s=t._self._c;return s("thead",[s("tr",[s("td",[s("strong",[t._v("#")])]),t._v(" "),s("td",[s("strong",[t._v("Position")])]),t._v(" "),s("td",[s("strong",[t._v("Actions")])])])])}],!1,null,null,null).exports}}]);