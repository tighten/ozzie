(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Partials_GithubItem__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../Partials/GithubItem */ "./resources/js/Pages/Partials/GithubItem.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    GithubItem: _Partials_GithubItem__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: {
    project: {
      required: true,
      type: Object
    },
    issue: {
      required: true,
      type: Object
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Partials/GithubItem.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Pages/Partials/GithubItem.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Layout__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../Layout */ "./resources/js/Pages/Layout.vue");
/* harmony import */ var _components_GoBack__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/GoBack */ "./resources/js/components/GoBack.vue");
/* harmony import */ var _Partials_ProjectHeader__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../Partials/ProjectHeader */ "./resources/js/Pages/Partials/ProjectHeader.vue");
/* harmony import */ var _components_Card__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../components/Card */ "./resources/js/components/Card.vue");
/* harmony import */ var _components_CardBody__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../components/CardBody */ "./resources/js/components/CardBody.vue");
/* harmony import */ var _components_CardHeader__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../components/CardHeader */ "./resources/js/components/CardHeader.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    CardHeader: _components_CardHeader__WEBPACK_IMPORTED_MODULE_5__["default"],
    CardBody: _components_CardBody__WEBPACK_IMPORTED_MODULE_4__["default"],
    Card: _components_Card__WEBPACK_IMPORTED_MODULE_3__["default"],
    GoBack: _components_GoBack__WEBPACK_IMPORTED_MODULE_1__["default"],
    Layout: _Layout__WEBPACK_IMPORTED_MODULE_0__["default"],
    ProjectHeader: _Partials_ProjectHeader__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  props: {
    projectNamespace: {
      required: true,
      type: String
    },
    projectName: {
      required: true,
      type: String
    },
    projectUrl: {
      required: true,
      type: String
    },
    projectMaintainers: {
      required: true,
      type: Array
    },
    githubItemTitle: {
      required: true,
      type: String
    },
    githubItemNumber: {
      required: true,
      type: Number
    },
    githubItemBody: {
      required: true,
      type: String
    },
    githubItemHtmlUrl: {
      required: true,
      type: String
    },
    githubItemUserUrl: {
      required: true,
      type: String
    },
    githubItemUserLogin: {
      required: true,
      type: String
    },
    githubItemCreatedAt: {
      required: true,
      type: String
    }
  },
  data: function data() {
    return {
      parsedGithubItemBody: '',
      loaded: false
    };
  },
  mounted: function mounted() {
    var _this = this;

    window.axios.post('https://api.github.com/markdown', {
      text: this.githubItemBody
    }, {
      headers: {
        Authorization: "token ".concat(window.githubToken)
      }
    }).then(function (response) {
      _this.parsedGithubItemBody = response.data;
      _this.loaded = true;
    })["catch"](function (error) {
      return console.log(error.message);
    });
  },
  methods: {
    baseUrl: function baseUrl(section) {
      return section ? this.githubItemHtmlUrl + '/' + section : this.githubItemHtmlUrl;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "github-item",
    {
      attrs: {
        "project-namespace": _vm.project.namespace,
        "project-name": _vm.project.name,
        "project-maintainers": _vm.project.maintainers,
        "project-url": _vm.project.url,
        "github-item-title": _vm.issue.title,
        "github-item-number": _vm.issue.number,
        "github-item-body": _vm.issue.body,
        "github-item-html-url": _vm.issue.html_url,
        "github-item-user-url": _vm.issue.user.html_url,
        "github-item-user-login": _vm.issue.user.login,
        "github-item-created-at": _vm.issue.created_at
      }
    },
    [_c("template", { slot: "github-item-type" }, [_vm._v("\n    Issue\n  ")])],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Partials/GithubItem.vue?vue&type=template&id=1305613a&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Pages/Partials/GithubItem.vue?vue&type=template&id=1305613a& ***!
  \*****************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "layout",
    {
      attrs: {
        title:
          "Ozzie - " +
          _vm.projectNamespace +
          "/" +
          _vm.projectName +
          " - #" +
          _vm.githubItemNumber
      }
    },
    [
      _c("GoBack"),
      _vm._v(" "),
      _c("ProjectHeader", {
        attrs: {
          namespace: _vm.projectNamespace,
          name: _vm.projectName,
          url: _vm.projectUrl,
          maintainers: _vm.projectMaintainers
        }
      }),
      _vm._v(" "),
      _c(
        "card",
        [
          _c("card-header", [
            _c(
              "div",
              { staticClass: "flex justify-between" },
              [
                _vm._t("github-item-type"),
                _vm._v(" "),
                _c("span", { staticClass: "normal-case font-normal" }, [
                  _vm._v("opened by "),
                  _c(
                    "a",
                    {
                      staticClass: "font-semibold text-indigo",
                      attrs: { href: _vm.githubItemUserUrl, target: "_blank" }
                    },
                    [
                      _vm._v(
                        "\n          " +
                          _vm._s(_vm.githubItemUserLogin) +
                          "\n        "
                      )
                    ]
                  ),
                  _vm._v(
                    " " +
                      _vm._s(
                        _vm.$luxon.fromISO(_vm.githubItemCreatedAt).toRelative()
                      ) +
                      "\n        "
                  )
                ])
              ],
              2
            )
          ]),
          _vm._v(" "),
          _c(
            "card-body",
            [
              _c(
                "h2",
                {
                  staticClass:
                    "mt-0 text-xl text-black font-semibold tracking-wide leading-none truncate"
                },
                [
                  _vm._v(
                    "\n        " + _vm._s(_vm.githubItemTitle) + "\n        "
                  ),
                  _c(
                    "span",
                    { staticClass: "ml-2 text-grey-dark font-normal" },
                    [
                      _vm._v(
                        "\n          #" +
                          _vm._s(_vm.githubItemNumber) +
                          "\n        "
                      )
                    ]
                  )
                ]
              ),
              _vm._v(" "),
              _vm._t("title-extra"),
              _vm._v(" "),
              _vm.loaded
                ? _c("div", { staticClass: "mt-4 markdown-body" }, [
                    _vm.githubItemBody !== ""
                      ? _c(
                          "div",
                          { staticClass: "pt-4 border-t border-clouds" },
                          [
                            _c("article", {
                              domProps: {
                                innerHTML: _vm._s(_vm.parsedGithubItemBody)
                              }
                            })
                          ]
                        )
                      : _c("em", { staticClass: "text-grey-darker" }, [
                          _vm._v("No description provided.")
                        ])
                  ])
                : _vm._e()
            ],
            2
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/Pages/Issue/Show.vue":
/*!*******************************************!*\
  !*** ./resources/js/Pages/Issue/Show.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Show.vue?vue&type=template&id=073c1b7c& */ "./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&");
/* harmony import */ var _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Show.vue?vue&type=script&lang=js& */ "./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Pages/Issue/Show.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Show.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&":
/*!**************************************************************************!*\
  !*** ./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Show.vue?vue&type=template&id=073c1b7c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/Pages/Partials/GithubItem.vue":
/*!****************************************************!*\
  !*** ./resources/js/Pages/Partials/GithubItem.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _GithubItem_vue_vue_type_template_id_1305613a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./GithubItem.vue?vue&type=template&id=1305613a& */ "./resources/js/Pages/Partials/GithubItem.vue?vue&type=template&id=1305613a&");
/* harmony import */ var _GithubItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./GithubItem.vue?vue&type=script&lang=js& */ "./resources/js/Pages/Partials/GithubItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _GithubItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _GithubItem_vue_vue_type_template_id_1305613a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _GithubItem_vue_vue_type_template_id_1305613a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/Pages/Partials/GithubItem.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/Pages/Partials/GithubItem.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/Pages/Partials/GithubItem.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./GithubItem.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Partials/GithubItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/Pages/Partials/GithubItem.vue?vue&type=template&id=1305613a&":
/*!***********************************************************************************!*\
  !*** ./resources/js/Pages/Partials/GithubItem.vue?vue&type=template&id=1305613a& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubItem_vue_vue_type_template_id_1305613a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./GithubItem.vue?vue&type=template&id=1305613a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Partials/GithubItem.vue?vue&type=template&id=1305613a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubItem_vue_vue_type_template_id_1305613a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GithubItem_vue_vue_type_template_id_1305613a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);