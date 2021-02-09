(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_ts_Pages_Partials_DebtTableRow_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'DebtTableRow',
  props: {
    project: {
      type: Object,
      required: true
    },
    hacktoberfest: {
      type: Boolean,
      "default": false
    },
    showProjectName: {
      type: Boolean,
      "default": true
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=template&id=e8b21b8e":
/*!**************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=template&id=e8b21b8e ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* binding */ render
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  key: 0,
  "class": "p-4"
};
var _hoisted_2 = {
  "class": "text-black-lightest p-4"
};
var _hoisted_3 = {
  "class": "text-black-lightest p-4"
};
var _hoisted_4 = {
  "class": "text-black-lightest p-4"
};
var _hoisted_5 = {
  "class": "text-black-lightest p-4"
};
var _hoisted_6 = {
  "class": "text-black-lightest p-4"
};
var _hoisted_7 = {
  "class": "text-black-lightest p-4"
};
var _hoisted_8 = {
  key: 1,
  "class": "p-4"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_InertiaLink = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("InertiaLink");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("tr", null, [$props.showProjectName ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_InertiaLink, {
    "class": "text-indigo no-underline p-2 -mx-2",
    href: '/inertia/projects/' + $props.project.namespace + '/' + $props.project.name,
    method: "get"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.namespace) + "/" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.name), 1
      /* TEXT */
      )];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["href"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td", _hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.debtScore), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("img", {
    src: "data:image/jpeg;base64, ".concat($props.project.debtScoreGraph)
  }, null, 8
  /* PROPS */
  , ["src"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td", _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.oldPrCount), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td", _hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.oldIssueCount), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td", _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.prCount), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.issueCount), 1
  /* TEXT */
  ), $props.hacktoberfest ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("a", {
    "class": "text-indigo no-underline p-2 -mx-2",
    href: 'https://github.com/' + $props.project.namespace + '/' + $props.project.name + '/labels/hacktoberfest',
    target: "_blank"
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.project.hacktoberfestIssues), 9
  /* TEXT, PROPS */
  , ["href"])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]);
}

/***/ }),

/***/ "./resources/ts/Pages/Partials/DebtTableRow.vue":
/*!******************************************************!*\
  !*** ./resources/ts/Pages/Partials/DebtTableRow.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _DebtTableRow_vue_vue_type_template_id_e8b21b8e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DebtTableRow.vue?vue&type=template&id=e8b21b8e */ "./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=template&id=e8b21b8e");
/* harmony import */ var _DebtTableRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DebtTableRow.vue?vue&type=script&lang=js */ "./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=script&lang=js");



_DebtTableRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default.render = _DebtTableRow_vue_vue_type_template_id_e8b21b8e__WEBPACK_IMPORTED_MODULE_0__.render
/* hot reload */
if (false) {}

_DebtTableRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default.__file = "resources/ts/Pages/Partials/DebtTableRow.vue"

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_DebtTableRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default);

/***/ }),

/***/ "./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=script&lang=js":
/*!******************************************************************************!*\
  !*** ./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=script&lang=js ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DebtTableRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__.default
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DebtTableRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DebtTableRow.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=script&lang=js");


/***/ }),

/***/ "./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=template&id=e8b21b8e":
/*!************************************************************************************!*\
  !*** ./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=template&id=e8b21b8e ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DebtTableRow_vue_vue_type_template_id_e8b21b8e__WEBPACK_IMPORTED_MODULE_0__.render
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DebtTableRow_vue_vue_type_template_id_e8b21b8e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DebtTableRow.vue?vue&type=template&id=e8b21b8e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/ts/Pages/Partials/DebtTableRow.vue?vue&type=template&id=e8b21b8e");


/***/ })

}]);
