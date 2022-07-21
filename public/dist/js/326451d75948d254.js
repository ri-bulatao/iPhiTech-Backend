"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[8564],{9198:(t,e,n)=>{n.d(e,{bW:()=>c,ui:()=>o,xO:()=>r});var i=n(6455),s=n.n(i),a=s().mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,timerProgressBar:!0,didOpen:function(t){t.addEventListener("mouseenter",s().stopTimer),t.addEventListener("mouseleave",s().resumeTimer)}}),o=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Question",e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Question description",n=arguments.length>2?arguments[2]:void 0,i=arguments.length>3?arguments[3]:void 0;return new Promise((function(a,o){s().fire({icon:"question",title:t,text:e,showCancelButton:n,confirmButtonText:i}).then((function(t){t.isConfirmed&&a(t),o(t)}))}))},r=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Success",e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Success Message";a.fire({icon:"success",title:t,text:e})},c=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Ooops",e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Something went wrong!";a.fire({icon:"error",title:t,text:e})}},8564:(t,e,n)=>{n.r(e),n.d(e,{default:()=>r});var i=n(629),s=n(2552),a=n(9198);const o={name:"attendance-employee",data:function(){return{routeNames:s}},computed:(0,i.Se)({attendances:"attendances/attendances"}),methods:{prepareRemove:function(t){var e=this;(0,a.ui)("Are you sure?","There is no going back once deleted",!0,"Yes, Delete it!").then((function(n){e.removeAttendance(t)}))},removeAttendance:function(t){var e=this,n={id:t};this.$store.dispatch("attendances/deleteAttendance",n).then((function(t){n={user_id:e.$route.params.id},(0,a.xO)("Attendance Deleted"),e.$store.dispatch("attendances/fetchEmployeeAttendances",n)})).catch((function(t){return(0,a.bW)()}))}},mounted:function(){var t={user_id:this.$route.params.id};this.$store.dispatch("attendances/fetchEmployeeAttendances",t)}};const r=(0,n(1900).Z)(o,(function(){var t=this,e=t._self._c;return e("div",{staticClass:"container-fluid"},[t._m(0),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-sm-12 col-lg-7 d-flex m-auto justify-content-center py-3"},[e("table",{staticClass:"table table-striped"},[t._m(1),t._v(" "),e("tbody",t._l(t.attendances,(function(n){return e("tr",{key:n.id},[e("td",[t._v(t._s(n.id))]),t._v(" "),e("td",[t._v(t._s(n.date))]),t._v(" "),e("td",[t._v(t._s(n.time_in))]),t._v(" "),e("td",[t._v(t._s(n.time_out))]),t._v(" "),e("td",[e("router-link",{staticClass:"btn btn-sm btn-warning",attrs:{to:{name:[t.routeNames.attendance_edit],params:{id:n.id}}}},[t._v("Edit")]),t._v(" "),e("a",{staticClass:"btn btn-sm btn-danger",attrs:{href:"javascript:void(0)"},on:{click:function(){return t.prepareRemove(n.id)}}},[t._v("Delete")])],1)])})),0)])])])])}),[function(){var t=this,e=t._self._c;return e("div",{staticClass:"row"},[e("div",{staticClass:"col-sm-12 col-lg-7 m-auto border-bottom mb-3"},[e("h1",[t._v("Attendance")]),t._v(" "),e("small",[t._v("Attendance")])])])},function(){var t=this,e=t._self._c;return e("thead",[e("tr",[e("td",[t._v("ID")]),t._v(" "),e("td",[t._v("Date")]),t._v(" "),e("td",[t._v("Time In")]),t._v(" "),e("td",[t._v("Time Out")]),t._v(" "),e("td",[t._v("Actions")])])])}],!1,null,null,null).exports}}]);