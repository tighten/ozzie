(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _Layout__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../Layout */ \"./resources/js/Pages/Layout.vue\");\n/* harmony import */ var _components_GoBack__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/GoBack */ \"./resources/js/components/GoBack.vue\");\n/* harmony import */ var _Partials_ProjectHeader__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../Partials/ProjectHeader */ \"./resources/js/Pages/Partials/ProjectHeader.vue\");\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  components: {\n    GoBack: _components_GoBack__WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n    Layout: _Layout__WEBPACK_IMPORTED_MODULE_0__[\"default\"],\n    ProjectHeader: _Partials_ProjectHeader__WEBPACK_IMPORTED_MODULE_2__[\"default\"]\n  },\n  props: {\n    project: {\n      required: true,\n      type: Object\n    },\n    issue: {\n      required: true,\n      type: Object\n    }\n  },\n  data: function data() {\n    return {\n      issueBody: '',\n      loaded: false\n    };\n  },\n  mounted: function mounted() {\n    var _this = this;\n\n    window.axios.post('https://api.github.com/markdown', {\n      text: this.issue.body\n    }, {\n      headers: {\n        Authorization: \"token \".concat(window.githubToken)\n      }\n    }).then(function (response) {\n      _this.issueBody = response.data;\n      _this.loaded = true;\n    })[\"catch\"](function (error) {\n      return console.log(error.message);\n    });\n  },\n  methods: {\n    baseUrl: function baseUrl(section) {\n      return section ? this.issue.url + '/' + section : this.issue.url;\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2pzL1BhZ2VzL0lzc3VlL1Nob3cudnVlPzQzZTEiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFzQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBLHNFQURBO0FBRUEsMkRBRkE7QUFHQTtBQUhBLEdBREE7QUFNQTtBQUNBO0FBQ0Esb0JBREE7QUFFQTtBQUZBLEtBREE7QUFLQTtBQUNBLG9CQURBO0FBRUE7QUFGQTtBQUxBLEdBTkE7QUFnQkEsTUFoQkEsa0JBZ0JBO0FBQ0E7QUFDQSxtQkFEQTtBQUVBO0FBRkE7QUFJQSxHQXJCQTtBQXNCQSxTQXRCQSxxQkFzQkE7QUFBQTs7QUFDQSxpQkFDQSxJQURBLENBQ0EsaUNBREEsRUFFQTtBQUNBO0FBREEsS0FGQSxFQUtBO0FBQ0E7QUFDQTtBQURBO0FBREEsS0FMQSxFQVdBLElBWEEsQ0FXQTtBQUNBO0FBQ0E7QUFDQSxLQWRBLFdBZUE7QUFBQTtBQUFBLEtBZkE7QUFnQkEsR0F2Q0E7QUF3Q0E7QUFDQSxXQURBLG1CQUNBLE9BREEsRUFDQTtBQUNBLHVCQUNBLDhCQURBLEdBRUEsY0FGQTtBQUdBO0FBTEE7QUF4Q0EiLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8hLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvaW5kZXguanM/IS4vcmVzb3VyY2VzL2pzL1BhZ2VzL0lzc3VlL1Nob3cudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJi5qcyIsInNvdXJjZXNDb250ZW50IjpbIjx0ZW1wbGF0ZT5cbiAgPGxheW91dCA6dGl0bGU9XCInT3p6aWUgLSAnICsgcHJvamVjdC5uYW1lc3BhY2UgKyAnLycgKyBwcm9qZWN0Lm5hbWUgKyAnIC0gcHVsbCByZXF1ZXN0ICMnICsgaXNzdWUubnVtYmVyXCI+XG4gICAgPEdvQmFjayAvPlxuICAgIDxQcm9qZWN0SGVhZGVyXG4gICAgICA6bmFtZXNwYWNlPVwicHJvamVjdC5uYW1lc3BhY2VcIlxuICAgICAgOm5hbWU9XCJwcm9qZWN0Lm5hbWVcIlxuICAgICAgOnVybD1cInByb2plY3QudXJsXCJcbiAgICAgIDptYWludGFpbmVycz1cInByb2plY3QubWFpbnRhaW5lcnNcIlxuICAgIC8+XG4gICAgPGRpdiBjbGFzcz1cImZsZXggZmxleC1jb2wgYmctd2hpdGUgcm91bmRlZCBzaGFkb3dcIj5cbiAgICAgIDxzcGFuIGNsYXNzPVwiYm9yZGVyLWdyZXkgYm9yZGVyLWItMiBwLTQgYmctZ3JleS1ibHVlLWxpZ2h0IHVwcGVyY2FzZSB0ZXh0LXhzIGxlYWRpbmctbm9uZSB0cmFja2luZy13aWRlIGZvbnQtYm9sZCB0ZXh0LWdyZXktZGFya2VzdFwiPlxuICAgICAgICBJc3N1ZVxuICAgICAgPC9zcGFuPlxuICAgICAgPGRpdiBjbGFzcz1cInB4LTYgcHktMlwiPlxuICAgICAgICA8aDIgY2xhc3M9XCJtdC0wIHRleHQtMnhsIHRleHQtYmxhY2sgZm9udC1zZW1pYm9sZCB0cmFja2luZy13aWRlXCI+XG4gICAgICAgICAge3sgaXNzdWUudGl0bGUgfX1cbiAgICAgICAgPC9oMj5cbiAgICAgICAgPGRpdlxuICAgICAgICAgIHYtaWY9XCJsb2FkZWRcIlxuICAgICAgICAgIGNsYXNzPVwibXQtNCBtYXJrZG93bi1ib2R5XCJcbiAgICAgICAgPlxuICAgICAgICAgIDxkaXZcbiAgICAgICAgICAgIHYtaWY9XCJpc3N1ZUJvZHkgIT09ICcnXCJcbiAgICAgICAgICAgIGNsYXNzPVwicHQtNCBib3JkZXItdCBib3JkZXItY2xvdWRzXCJcbiAgICAgICAgICA+XG4gICAgICAgICAgICA8YXJ0aWNsZSB2LWh0bWw9XCJpc3N1ZUJvZHlcIiAvPlxuICAgICAgICAgIDwvZGl2PlxuICAgICAgICAgIDxlbVxuICAgICAgICAgICAgdi1lbHNlXG4gICAgICAgICAgICBjbGFzcz1cInRleHQtZ3JleS1kYXJrZXJcIlxuICAgICAgICAgID5ObyBkZXNjcmlwdGlvbiBwcm92aWRlZC48L2VtPlxuICAgICAgICA8L2Rpdj5cbiAgICAgIDwvZGl2PlxuICAgIDwvZGl2PlxuICA8L2xheW91dD5cbjwvdGVtcGxhdGU+XG5cbjxzY3JpcHQ+XG5pbXBvcnQgTGF5b3V0IGZyb20gJy4uL0xheW91dCc7XG5pbXBvcnQgR29CYWNrIGZyb20gJy4uLy4uL2NvbXBvbmVudHMvR29CYWNrJztcbmltcG9ydCBQcm9qZWN0SGVhZGVyIGZyb20gJy4uL1BhcnRpYWxzL1Byb2plY3RIZWFkZXInO1xuXG5leHBvcnQgZGVmYXVsdCB7XG4gICAgY29tcG9uZW50czoge1xuICAgICAgICBHb0JhY2ssXG4gICAgICAgIExheW91dCxcbiAgICAgICAgUHJvamVjdEhlYWRlcixcbiAgICB9LFxuICAgIHByb3BzOiB7XG4gICAgICAgIHByb2plY3Q6IHtcbiAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlLFxuICAgICAgICAgICAgdHlwZTogT2JqZWN0LFxuICAgICAgICB9LFxuICAgICAgICBpc3N1ZToge1xuICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgICAgICB0eXBlOiBPYmplY3QsXG4gICAgICAgIH0sXG4gICAgfSxcbiAgICBkYXRhKCkge1xuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgaXNzdWVCb2R5OiAnJyxcbiAgICAgICAgICAgIGxvYWRlZDogZmFsc2UsXG4gICAgICAgIH07XG4gICAgfSxcbiAgICBtb3VudGVkKCkge1xuICAgICAgICB3aW5kb3cuYXhpb3NcbiAgICAgICAgICAgIC5wb3N0KCdodHRwczovL2FwaS5naXRodWIuY29tL21hcmtkb3duJyxcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHRleHQ6IHRoaXMuaXNzdWUuYm9keSxcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaGVhZGVyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgQXV0aG9yaXphdGlvbjogYHRva2VuICR7d2luZG93LmdpdGh1YlRva2VufWAsXG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgKVxuICAgICAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xuICAgICAgICAgICAgICAgIHRoaXMuaXNzdWVCb2R5ID0gcmVzcG9uc2UuZGF0YTtcbiAgICAgICAgICAgICAgICB0aGlzLmxvYWRlZCA9IHRydWU7XG4gICAgICAgICAgICB9KVxuICAgICAgICAgICAgLmNhdGNoKGVycm9yID0+IGNvbnNvbGUubG9nKGVycm9yLm1lc3NhZ2UpKTtcbiAgICB9LFxuICAgIG1ldGhvZHM6IHtcbiAgICAgICAgYmFzZVVybChzZWN0aW9uKSB7XG4gICAgICAgICAgICByZXR1cm4gKHNlY3Rpb24pXG4gICAgICAgICAgICAgICAgPyB0aGlzLmlzc3VlLnVybCArICcvJyArIHNlY3Rpb25cbiAgICAgICAgICAgICAgICA6dGhpcy5pc3N1ZS51cmw7XG4gICAgICAgIH0sXG4gICAgfSxcbn07XG48L3NjcmlwdD5cbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return staticRenderFns; });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\n    \"layout\",\n    {\n      attrs: {\n        title:\n          \"Ozzie - \" +\n          _vm.project.namespace +\n          \"/\" +\n          _vm.project.name +\n          \" - pull request #\" +\n          _vm.issue.number\n      }\n    },\n    [\n      _c(\"GoBack\"),\n      _vm._v(\" \"),\n      _c(\"ProjectHeader\", {\n        attrs: {\n          namespace: _vm.project.namespace,\n          name: _vm.project.name,\n          url: _vm.project.url,\n          maintainers: _vm.project.maintainers\n        }\n      }),\n      _vm._v(\" \"),\n      _c(\"div\", { staticClass: \"flex flex-col bg-white rounded shadow\" }, [\n        _c(\n          \"span\",\n          {\n            staticClass:\n              \"border-grey border-b-2 p-4 bg-grey-blue-light uppercase text-xs leading-none tracking-wide font-bold text-grey-darkest\"\n          },\n          [_vm._v(\"\\n      Issue\\n    \")]\n        ),\n        _vm._v(\" \"),\n        _c(\"div\", { staticClass: \"px-6 py-2\" }, [\n          _c(\n            \"h2\",\n            {\n              staticClass:\n                \"mt-0 text-2xl text-black font-semibold tracking-wide\"\n            },\n            [_vm._v(\"\\n        \" + _vm._s(_vm.issue.title) + \"\\n      \")]\n          ),\n          _vm._v(\" \"),\n          _vm.loaded\n            ? _c(\"div\", { staticClass: \"mt-4 markdown-body\" }, [\n                _vm.issueBody !== \"\"\n                  ? _c(\"div\", { staticClass: \"pt-4 border-t border-clouds\" }, [\n                      _c(\"article\", {\n                        domProps: { innerHTML: _vm._s(_vm.issueBody) }\n                      })\n                    ])\n                  : _c(\"em\", { staticClass: \"text-grey-darker\" }, [\n                      _vm._v(\"No description provided.\")\n                    ])\n              ])\n            : _vm._e()\n        ])\n      ])\n    ],\n    1\n  )\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvUGFnZXMvSXNzdWUvU2hvdy52dWU/MmQ5MCJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBLGlCQUFpQix1REFBdUQ7QUFDeEU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWDtBQUNBO0FBQ0E7QUFDQSxtQkFBbUIsMkJBQTJCO0FBQzlDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxhQUFhO0FBQ2I7QUFDQTtBQUNBO0FBQ0E7QUFDQSx5QkFBeUIsb0NBQW9DO0FBQzdEO0FBQ0EsK0JBQStCLDZDQUE2QztBQUM1RTtBQUNBLG1DQUFtQztBQUNuQyx1QkFBdUI7QUFDdkI7QUFDQSw4QkFBOEIsa0NBQWtDO0FBQ2hFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiIuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9sb2FkZXJzL3RlbXBsYXRlTG9hZGVyLmpzPyEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8hLi9yZXNvdXJjZXMvanMvUGFnZXMvSXNzdWUvU2hvdy52dWU/dnVlJnR5cGU9dGVtcGxhdGUmaWQ9MDczYzFiN2MmLmpzIiwic291cmNlc0NvbnRlbnQiOlsidmFyIHJlbmRlciA9IGZ1bmN0aW9uKCkge1xuICB2YXIgX3ZtID0gdGhpc1xuICB2YXIgX2ggPSBfdm0uJGNyZWF0ZUVsZW1lbnRcbiAgdmFyIF9jID0gX3ZtLl9zZWxmLl9jIHx8IF9oXG4gIHJldHVybiBfYyhcbiAgICBcImxheW91dFwiLFxuICAgIHtcbiAgICAgIGF0dHJzOiB7XG4gICAgICAgIHRpdGxlOlxuICAgICAgICAgIFwiT3p6aWUgLSBcIiArXG4gICAgICAgICAgX3ZtLnByb2plY3QubmFtZXNwYWNlICtcbiAgICAgICAgICBcIi9cIiArXG4gICAgICAgICAgX3ZtLnByb2plY3QubmFtZSArXG4gICAgICAgICAgXCIgLSBwdWxsIHJlcXVlc3QgI1wiICtcbiAgICAgICAgICBfdm0uaXNzdWUubnVtYmVyXG4gICAgICB9XG4gICAgfSxcbiAgICBbXG4gICAgICBfYyhcIkdvQmFja1wiKSxcbiAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICBfYyhcIlByb2plY3RIZWFkZXJcIiwge1xuICAgICAgICBhdHRyczoge1xuICAgICAgICAgIG5hbWVzcGFjZTogX3ZtLnByb2plY3QubmFtZXNwYWNlLFxuICAgICAgICAgIG5hbWU6IF92bS5wcm9qZWN0Lm5hbWUsXG4gICAgICAgICAgdXJsOiBfdm0ucHJvamVjdC51cmwsXG4gICAgICAgICAgbWFpbnRhaW5lcnM6IF92bS5wcm9qZWN0Lm1haW50YWluZXJzXG4gICAgICAgIH1cbiAgICAgIH0pLFxuICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiZmxleCBmbGV4LWNvbCBiZy13aGl0ZSByb3VuZGVkIHNoYWRvd1wiIH0sIFtcbiAgICAgICAgX2MoXG4gICAgICAgICAgXCJzcGFuXCIsXG4gICAgICAgICAge1xuICAgICAgICAgICAgc3RhdGljQ2xhc3M6XG4gICAgICAgICAgICAgIFwiYm9yZGVyLWdyZXkgYm9yZGVyLWItMiBwLTQgYmctZ3JleS1ibHVlLWxpZ2h0IHVwcGVyY2FzZSB0ZXh0LXhzIGxlYWRpbmctbm9uZSB0cmFja2luZy13aWRlIGZvbnQtYm9sZCB0ZXh0LWdyZXktZGFya2VzdFwiXG4gICAgICAgICAgfSxcbiAgICAgICAgICBbX3ZtLl92KFwiXFxuICAgICAgSXNzdWVcXG4gICAgXCIpXVxuICAgICAgICApLFxuICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcInB4LTYgcHktMlwiIH0sIFtcbiAgICAgICAgICBfYyhcbiAgICAgICAgICAgIFwiaDJcIixcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6XG4gICAgICAgICAgICAgICAgXCJtdC0wIHRleHQtMnhsIHRleHQtYmxhY2sgZm9udC1zZW1pYm9sZCB0cmFja2luZy13aWRlXCJcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBbX3ZtLl92KFwiXFxuICAgICAgICBcIiArIF92bS5fcyhfdm0uaXNzdWUudGl0bGUpICsgXCJcXG4gICAgICBcIildXG4gICAgICAgICAgKSxcbiAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgIF92bS5sb2FkZWRcbiAgICAgICAgICAgID8gX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJtdC00IG1hcmtkb3duLWJvZHlcIiB9LCBbXG4gICAgICAgICAgICAgICAgX3ZtLmlzc3VlQm9keSAhPT0gXCJcIlxuICAgICAgICAgICAgICAgICAgPyBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcInB0LTQgYm9yZGVyLXQgYm9yZGVyLWNsb3Vkc1wiIH0sIFtcbiAgICAgICAgICAgICAgICAgICAgICBfYyhcImFydGljbGVcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgZG9tUHJvcHM6IHsgaW5uZXJIVE1MOiBfdm0uX3MoX3ZtLmlzc3VlQm9keSkgfVxuICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgIF0pXG4gICAgICAgICAgICAgICAgICA6IF9jKFwiZW1cIiwgeyBzdGF0aWNDbGFzczogXCJ0ZXh0LWdyZXktZGFya2VyXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgICAgIF92bS5fdihcIk5vIGRlc2NyaXB0aW9uIHByb3ZpZGVkLlwiKVxuICAgICAgICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgOiBfdm0uX2UoKVxuICAgICAgICBdKVxuICAgICAgXSlcbiAgICBdLFxuICAgIDFcbiAgKVxufVxudmFyIHN0YXRpY1JlbmRlckZucyA9IFtdXG5yZW5kZXIuX3dpdGhTdHJpcHBlZCA9IHRydWVcblxuZXhwb3J0IHsgcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnMgfSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&\n");

/***/ }),

/***/ "./resources/js/Pages/Issue/Show.vue":
/*!*******************************************!*\
  !*** ./resources/js/Pages/Issue/Show.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Show.vue?vue&type=template&id=073c1b7c& */ \"./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&\");\n/* harmony import */ var _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Show.vue?vue&type=script&lang=js& */ \"./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n\nvar component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(\n  _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n  _Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__[\"render\"],\n  _Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"],\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/Pages/Issue/Show.vue\"\n/* harmony default export */ __webpack_exports__[\"default\"] = (component.exports);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvUGFnZXMvSXNzdWUvU2hvdy52dWU/YzkyMCJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFtRjtBQUMzQjtBQUNMOzs7QUFHbkQ7QUFDZ0c7QUFDaEcsZ0JBQWdCLDJHQUFVO0FBQzFCLEVBQUUsMEVBQU07QUFDUixFQUFFLCtFQUFNO0FBQ1IsRUFBRSx3RkFBZTtBQUNqQjtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLElBQUksS0FBVSxFQUFFLFlBaUJmO0FBQ0Q7QUFDZSxnRiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9QYWdlcy9Jc3N1ZS9TaG93LnZ1ZS5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCB7IHJlbmRlciwgc3RhdGljUmVuZGVyRm5zIH0gZnJvbSBcIi4vU2hvdy52dWU/dnVlJnR5cGU9dGVtcGxhdGUmaWQ9MDczYzFiN2MmXCJcbmltcG9ydCBzY3JpcHQgZnJvbSBcIi4vU2hvdy52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9anMmXCJcbmV4cG9ydCAqIGZyb20gXCIuL1Nob3cudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJlwiXG5cblxuLyogbm9ybWFsaXplIGNvbXBvbmVudCAqL1xuaW1wb3J0IG5vcm1hbGl6ZXIgZnJvbSBcIiEuLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvcnVudGltZS9jb21wb25lbnROb3JtYWxpemVyLmpzXCJcbnZhciBjb21wb25lbnQgPSBub3JtYWxpemVyKFxuICBzY3JpcHQsXG4gIHJlbmRlcixcbiAgc3RhdGljUmVuZGVyRm5zLFxuICBmYWxzZSxcbiAgbnVsbCxcbiAgbnVsbCxcbiAgbnVsbFxuICBcbilcblxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHtcbiAgdmFyIGFwaSA9IHJlcXVpcmUoXCIvVXNlcnMvanN1Z2FyL1NpdGVzL29wZW4tc291cmNlL296emllL25vZGVfbW9kdWxlcy92dWUtaG90LXJlbG9hZC1hcGkvZGlzdC9pbmRleC5qc1wiKVxuICBhcGkuaW5zdGFsbChyZXF1aXJlKCd2dWUnKSlcbiAgaWYgKGFwaS5jb21wYXRpYmxlKSB7XG4gICAgbW9kdWxlLmhvdC5hY2NlcHQoKVxuICAgIGlmICghYXBpLmlzUmVjb3JkZWQoJzA3M2MxYjdjJykpIHtcbiAgICAgIGFwaS5jcmVhdGVSZWNvcmQoJzA3M2MxYjdjJywgY29tcG9uZW50Lm9wdGlvbnMpXG4gICAgfSBlbHNlIHtcbiAgICAgIGFwaS5yZWxvYWQoJzA3M2MxYjdjJywgY29tcG9uZW50Lm9wdGlvbnMpXG4gICAgfVxuICAgIG1vZHVsZS5ob3QuYWNjZXB0KFwiLi9TaG93LnZ1ZT92dWUmdHlwZT10ZW1wbGF0ZSZpZD0wNzNjMWI3YyZcIiwgZnVuY3Rpb24gKCkge1xuICAgICAgYXBpLnJlcmVuZGVyKCcwNzNjMWI3YycsIHtcbiAgICAgICAgcmVuZGVyOiByZW5kZXIsXG4gICAgICAgIHN0YXRpY1JlbmRlckZuczogc3RhdGljUmVuZGVyRm5zXG4gICAgICB9KVxuICAgIH0pXG4gIH1cbn1cbmNvbXBvbmVudC5vcHRpb25zLl9fZmlsZSA9IFwicmVzb3VyY2VzL2pzL1BhZ2VzL0lzc3VlL1Nob3cudnVlXCJcbmV4cG9ydCBkZWZhdWx0IGNvbXBvbmVudC5leHBvcnRzIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/Pages/Issue/Show.vue\n");

/***/ }),

/***/ "./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Show.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__[\"default\"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[\"default\"]); //# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvUGFnZXMvSXNzdWUvU2hvdy52dWU/YjJkNSJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUEsd0NBQTBMLENBQWdCLGdQQUFHLEVBQUMiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvUGFnZXMvSXNzdWUvU2hvdy52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9anMmLmpzIiwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IG1vZCBmcm9tIFwiLSEuLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/cmVmLS00LTAhLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2luZGV4LmpzPz92dWUtbG9hZGVyLW9wdGlvbnMhLi9TaG93LnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIjsgZXhwb3J0IGRlZmF1bHQgbW9kOyBleHBvcnQgKiBmcm9tIFwiLSEuLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/cmVmLS00LTAhLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2luZGV4LmpzPz92dWUtbG9hZGVyLW9wdGlvbnMhLi9TaG93LnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/Pages/Issue/Show.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&":
/*!**************************************************************************!*\
  !*** ./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Show.vue?vue&type=template&id=073c1b7c& */ \"./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_073c1b7c___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"]; });\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvUGFnZXMvSXNzdWUvU2hvdy52dWU/YzA2OSJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUEiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvUGFnZXMvSXNzdWUvU2hvdy52dWU/dnVlJnR5cGU9dGVtcGxhdGUmaWQ9MDczYzFiN2MmLmpzIiwic291cmNlc0NvbnRlbnQiOlsiZXhwb3J0ICogZnJvbSBcIi0hLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2xvYWRlcnMvdGVtcGxhdGVMb2FkZXIuanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvaW5kZXguanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL1Nob3cudnVlP3Z1ZSZ0eXBlPXRlbXBsYXRlJmlkPTA3M2MxYjdjJlwiIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/Pages/Issue/Show.vue?vue&type=template&id=073c1b7c&\n");

/***/ })

}]);