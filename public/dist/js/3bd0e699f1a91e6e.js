"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[94],{9198:(t,n,e)=>{e.d(n,{bW:()=>c,ui:()=>o,xO:()=>a});var s=e(6455),i=e.n(s),r=i().mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3,timerProgressBar:!0,didOpen:function(t){t.addEventListener("mouseenter",i().stopTimer),t.addEventListener("mouseleave",i().resumeTimer)}}),o=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Question",n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Question description",e=arguments.length>2?arguments[2]:void 0,s=arguments.length>3?arguments[3]:void 0;return new Promise((function(r,o){i().fire({icon:"question",title:t,text:n,showCancelButton:e,confirmButtonText:s}).then((function(t){t.isConfirmed&&r(t),o(t)}))}))},a=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Success",n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Success Message";r.fire({icon:"success",title:t,text:n})},c=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"Ooops",n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Something went wrong!";r.fire({icon:"error",title:t,text:n})}},7094:(t,n,e)=>{e.r(n),e.d(n,{default:()=>o});var s=e(629),i=e(9198);const r={middleware:"admin",data:function(){return{sortBy:"title",sortOrder:"asc"}},computed:(0,s.Se)({announcements:"announcements/announcements"}),methods:{handleSort:function(t){this.sortBy=t,this.sortOrder="asc"==this.sortOrder?"desc":"asc";var n={sortBy:this.sortBy,sortOrder:this.sortOrder};this.$store.dispatch("announcements/fetchAnnouncements",n).catch((function(t){return(0,i.bW)()}))},deleteReady:function(t){var n=this;(0,i.ui)("Are you sure to delete ?","There is no undo for this action",!0,"Yes, Delete!").then((function(e){n.delete(t)}))},delete:function(t){var n=this;this.$store.dispatch("announcements/deleteAnnouncement",t).then((function(t){(0,i.xO)("Deleted!",t.message),n.$store.dispatch("announcements/fetchAnnouncements")})).catch((function(t){(0,i.bW)()}))}},mounted:function(){var t={sortBy:this.sortBy,sortOrder:this.sortOrder};this.$store.dispatch("announcements/fetchAnnouncements",t).catch((function(t){(0,i.bW)()}))}};const o=(0,e(1900).Z)(r,(function(){var t=this,n=t._self._c;return n("div",[n("div",{staticClass:"row"},[n("div",{staticClass:"col-sm-12"},[n("div",{staticClass:"d-flex justify-content-end"},[n("router-link",{staticClass:"btn btn-success",attrs:{to:{name:"admin.announcements.create"}}},[t._v("Create Announcement")])],1),t._v(" "),n("table",{staticClass:"table table-striped caption-top"},[n("caption",[t._v("List of Announcements")]),t._v(" "),n("thead",[n("tr",[n("td",[n("strong",[n("a",{attrs:{href:"javascript:void(0)"},on:{click:function(){return t.handleSort("id")}}},[t._v("ID")])])]),t._v(" "),n("td",[n("strong",[n("a",{attrs:{href:"javascript:void(0)"},on:{click:function(){return t.handleSort("title")}}},[t._v("Announcement Title")])])]),t._v(" "),n("td",[n("strong",[n("a",{attrs:{href:"javascript:void(0)"},on:{click:function(){return t.handleSort("excerpt")}}},[t._v("Excerpt")])])]),t._v(" "),n("td",[n("strong",[n("a",{attrs:{href:"javascript:void(0)"},on:{click:function(){return t.handleSort("status")}}},[t._v("Status")])])]),t._v(" "),t._m(0)])]),t._v(" "),n("tbody",t._l(t.announcements,(function(e){return n("tr",{key:e.id},[n("td",[t._v(t._s(e.id))]),t._v(" "),n("td",[t._v(t._s(e.title))]),t._v(" "),n("td",[t._v(t._s(e.excerpt))]),t._v(" "),n("td",[t._v(t._s(e.status))]),t._v(" "),n("td",[n("router-link",{staticClass:"btn btn-primary btn-sm",attrs:{to:{name:"admin.announcements.single",params:{id:e.id}}}},[t._v("View")]),t._v(" "),n("router-link",{staticClass:"btn btn-warning btn-sm",attrs:{to:{name:"admin.announcements.edit",params:{id:e.id}}}},[t._v("Edit")]),t._v(" "),n("a",{staticClass:"btn btn-danger btn-sm",attrs:{href:"javascript:void(0)"},on:{click:function(){return t.deleteReady(e.id)}}},[t._v("Delete")])],1)])})),0)])])])])}),[function(){var t=this._self._c;return t("td",[t("strong",[this._v("Actions")])])}],!1,null,null,null).exports}}]);